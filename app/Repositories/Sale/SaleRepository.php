<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\ImportCsvDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\DTO\User\CreateUserDTO;
use App\Enum\ProductTypeEnum;
use App\Enum\SaleEnum;
use App\Enum\SalesChannelEnum;
use App\Events\SaleToNewAndOldMembers;
use App\Models\Sale;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(
        protected CourseRepository $courseRepository,
        protected UserRepository $userRepository,
        protected BankRepository $bankRepository,
        protected Sale $entity
    ) {
    }

    public function getMyStudents(
        int $page = 1,
        int $totalPerPage  = 10,
        string $status = '',
        string $channel = '',
        string $type = '',
        string $startDate = null,
        string $endDate = null,
        string $filter = null
    ): PaginationInterface {
        $query = $this->entity
                      ->userByAuth()
                      ->with('product.files', 'user');

        // Aplicar filtro por status
        if ($status) {
            $statusEnum = SaleEnum::tryFrom($status);

            if ($statusEnum) {
                $query->where('sales.status', $statusEnum->name);
            }
        }

        // Aplicar filtro por status
        if ($channel) {
            $statusEnum = SalesChannelEnum::tryFrom($channel);

            if ($statusEnum) {
                $query->where('sales.sales_channel', $statusEnum->name);
            }
        }

        // Aplicar filtro por status
        if ($type) {
            $statusEnum = ProductTypeEnum::tryFrom($type);

            if ($statusEnum) {
                $query->where('sales.product_type', $statusEnum->name);
            }
        }

        // Filtro por intervalo de datas (se start_date e end_date forem fornecidos)
        if ($startDate && $endDate) {
            $query->whereBetween('sales.date_created', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('sales.date_created', '>=', $startDate);
        } elseif ($endDate) {
            $query->where('sales.date_created', '<=', $endDate);
        }

        // Filtro pelo nome do usuário
        if ($filter) {
            $query->whereHas('user', function ($query) use ($filter) {
                $query->where('users.name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function findById(string $id): ?object
    {
        return $this->entity->with('user', 'producer')->find($id);
    }

    // public function createNewSale(CreateNewSaleDTO $dto)
    // {
    //     $product = $this->courseRepository->getCourseById($dto->product_id);
    //     $authUser = $this->userRepository->findByAuth();
    //     $bankUsers = $this->bankRepository->findBankByUserId($authUser->first()->id);
    //     $member = $this->userRepository->findByEmail($dto->email_member);

    //     $currentPrice = $product->price - ($product->price * ($product->discount / 100));

    //     $password = null;
    //     if ($member === null) {
    //         $password = generatePassword();
    //         $userDto = new CreateUserDTO(
    //             $dto->name,
    //             $dto->email_member,
    //             bcrypt($password),
    //             'default_device' // ou alguma lógica para definir o device_name
    //         );

    //         $member = $this->userRepository->create($userDto);
    //     }

    //     $newSale = Sale::create([
    //         'product_id' => $product->id,
    //         'user_id' => $member->id,
    //         'producer_id' => $authUser->first()->id,
    //         'email_member' => $dto->email_member,
    //         'transaction' => $dto->transaction,
    //         'date_expired' => $dto->date_expired,
    //         'status' => $dto->status,
    //         'discount' => $product->discount,
    //         'sale_price' => $currentPrice,
    //         'sales_channel' => 'VP',
    //         'payment_mode' => 'Banco',
    //         'date_created' => $dto->date_created,
    //         'product_type' => $dto->product_type
    //         ]);

    //     event(new SaleToNewAndOldMembers($member, $product, $password, $bankUsers));

    //     return $newSale;
    // }

    public function csvImportMember(ImportCsvDTO $dto)
    {
        $course = $this->courseRepository->getCourseById($dto->course_id);
        $authUser = $this->userRepository->findByAuth();
        $bankUsers = $this->bankRepository->findBankByUserId($authUser->first()->id);
        $member = $this->userRepository->findByEmail($dto->email_student);

        $password = null;
        if ($member === null) {
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
            'product_id' => $course->id,
            'user_id' => $member->id,
            'instrutor_id' => $authUser->first()->id,
            'email_student' => $dto->email_student,
            'transaction' => $dto->transaction,
            'date_expired' => $dto->date_expired,
            'status' => $dto->status,
            'blocked' => $dto->blocked,
            'payment_mode' => 'Banco',
            'date_created' => $dto->date_created,
            'product_type' => $dto->product_type
            ]);

        event(new SaleToNewAndOldMembers($member, $course, $password, $bankUsers));

        return $newSale;
    }

    public function updateSale(UpdateNewSaleDTO $dto): ?Sale
    {
        $sale = $this->entity->find($dto->id);
        Gate::authorize('owner-sale', $sale);

        if ($sale) {
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
