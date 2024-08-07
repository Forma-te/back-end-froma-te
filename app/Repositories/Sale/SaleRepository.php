<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\DTO\User\CreateUserDTO;
use App\Events\SaleToNewAndOldMembers;
use App\Models\Sale;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Gate;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(
        protected CourseRepository $courseRepository,
        protected UserRepository $userRepository,
        protected BankRepository $bankRepository,
        protected Sale $entity
    ) {
    }

    public function getMyStudents(int $page = 1, int $totalPerPage  = 15, string $filter = null): PaginationInterface
    {
        $query = $this->entity
                      ->newQuery()
                      ->join('courses', 'courses.id', '=', 'sales.course_id')
                      ->join('users', 'users.id', '=', 'sales.user_id')
                      ->select('sales.transaction', 'sales.status', 'sales.date_created', 'sales.date_expired', 'sales.id', 'courses.name as course_name', 'courses.price', 'courses.url', 'courses.image', 'users.name as user_name', 'users.email as student_email', 'users.image as student_image')
                      ->where('courses.user_id', auth()->user()->id)
                      ->where('sales.status', 'A');

        // Aplicar o filtro se fornecido
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('email_student', $filter)
                  ->orWhere('name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function getMembersByStatus(int $page = 1, int $totalPerPage  = 15, string $status, string $filter = null): PaginationInterface
    {
        $query = $this->entity
                    ->newQuery()
                    ->join('courses', 'courses.id', '=', 'sales.course_id')
                    ->join('users', 'users.id', '=', 'sales.user_id')
                    ->select('sales.transaction', 'sales.status', 'sales.date_created', 'sales.id', 'courses.name as course_name', 'courses.price', 'courses.url', 'courses.image', 'users.name as user_name', 'users.email as student_email', 'users.image as student_image')
                    ->where('courses.user_id', auth()->user()->id);
        // Aplicar filtro por status
        if ($status) {
            $query->where('status', $status);
        }

        // Aplicar filtro por e-mail do estudante
        if ($filter) {
            $query->orWhere('email_student', 'like', "%{$filter}%");
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function findById(string $id): ?object
    {
        return $this->entity->with('student', 'instrutor')->find($id);
    }

    public function createNewSale(CreateNewSaleDTO $dto)
    {
        $course = $this->courseRepository->getCourseById($dto->course_id);
        $authUser = $this->userRepository->findByAuth();
        $bankUsers = $this->bankRepository->findBankByUserId($authUser->first()->id);
        $member = $this->userRepository->findByEmail($dto->email_student);

        $password = null;
        if($member === null) {
            $password = generatePassword();
            $userDto = new CreateUserDTO(
                $dto->name,
                $dto->email_student,
                bcrypt($password),
                'default_device' // ou alguma lógica para definir o device_name
            );

            $member = $this->userRepository->create($userDto);
        }

        $newSale = Sale::create([
            'course_id' => $course->id,
            'user_id' => $member->id,
            'instrutor_id' => $authUser->first()->id,
            'email_student' => $dto->email_student,
            'transaction' => $dto->transaction,
            'date_expired' => $dto->date_expired,
            'status' => $dto->status,
            'blocked' => $dto->blocked,
            'payment_mode' => 'banco',
            'date_created' => $dto->date_created
            ]);

        event(new SaleToNewAndOldMembers($member, $course, $password, $bankUsers));

        return $newSale;
    }

    public function updateSale(UpdateNewSaleDTO $dto): ?Sale
    {
        $sale = $this->entity->find($dto->id);
        Gate::authorize('owner-sale', $sale);

        if($sale) {
            $sale->update((array) $dto);
            return $sale;
        }

        return null;
    }

    public function delete(string $id): void
    {
        $this->entity->findOrFail($id)->delete();
    }

}
