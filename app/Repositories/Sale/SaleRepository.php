<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\ImportCsvDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\DTO\User\CreateUserDTO;
use App\Enum\SaleEnum;
use App\Events\SaleToNewAndOldMembers;
use App\Models\Sale;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\PaginationInterface;
use App\Repositories\PaginationPresenter;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(
        protected CourseRepository $courseRepository,
        protected UserRepository $userRepository,
        protected BankRepository $bankRepository,
        protected Sale $entity
    ) {
    }

    public function getMyStudents(int $page = 1, int $totalPerPage  = 10, string $status = '', string $filter = null): PaginationInterface
    {
        $query = $this->entity
                      ->newQuery()
                      ->with('product.files')
                      ->join('products', 'products.id', '=', 'sales.product_id')
                      ->join('users', 'users.id', '=', 'sales.user_id')
                      ->select(
                          'sales.transaction',
                          'sales.payment_mode',
                          'sales.status',
                          'sales.date_created',
                          'sales.date_expired',
                          'sales.product_type as type',
                          'sales.id as sale_id',
                          'products.name as course_name',
                          'products.price',
                          'products.id as product_id',
                          'products.url',
                          DB::raw("CONCAT('https://forma-te-ebooks-bucket.s3.amazonaws.com/', products.image) as image_url"),
                          'users.name as user_name',
                          'users.phone_number',
                          'users.id as user_id',
                          'users.email as member_email',
                          DB::raw("CONCAT('https://forma-te-ebooks-bucket.s3.amazonaws.com/', users.image) as student_image_url")
                      )
                      ->where('products.user_id', Auth::user()->id)
                      ->where('sales.status', 'A');

        // Aplicar filtro por status
        if ($status) {
            $statusEnum = SaleEnum::tryFrom($status);
            if ($statusEnum) {
                $query->where('sales.status', $statusEnum->name);
            }
        }

        // Aplicar o filtro se fornecido
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('users.name', 'like', "%{$filter}%")
                  ->orWhere('users.name', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);
        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result);
    }

    public function getMembersByStatus(int $page = 1, int $totalPerPage  = 10, string $status = '', string $filter = null): PaginationInterface
    {
        $query = $this->entity
                    ->newQuery()
                    ->with(['product.files'])
                    ->join('products', 'products.id', '=', 'sales.product_id')
                    ->join('users', 'users.id', '=', 'sales.user_id')
                    ->select(
                        'sales.transaction',
                        'sales.payment_mode',
                        'sales.status',
                        'sales.date_created',
                        'sales.date_expired',
                        'sales.product_type as type',
                        'sales.id as sale_id',
                        'products.name as course_name',
                        'products.price',
                        'sales.sale_price',
                        'products.id as course_id',
                        'products.url',
                        'users.name as user_name',
                        'users.phone_number',
                        'users.id as user_id',
                        'users.email as member_email',
                        DB::raw("CONCAT('https://forma-te-ebooks-bucket.s3.amazonaws.com/', users.image) as student_image_url")
                    )
                    ->where('products.user_id', Auth::user()->id);

        // Aplicar filtro por status
        if ($status) {
            $statusEnum = SaleEnum::tryFrom($status);
            if ($statusEnum) {
                $query->where('sales.status', $statusEnum->name);
            }
        }

        // Aplicar filtro por e-mail do estudante
        if ($filter) {
            $query->where(function ($query) use ($filter) {
                $query->where('users.name', 'like', "%{$filter}%")
                  ->orWhere('users.email', 'like', "%{$filter}%");
            });
        }

        // Paginar os resultados
        $result = $query->paginate($totalPerPage, ['*'], 'page', $page);

        // Retornar os resultados paginados usando o PaginationPresenter
        return new PaginationPresenter($result); // Passando o objeto paginado diretamente
    }

    public function findById(string $id): ?object
    {
        return $this->entity->with('member', 'producer')->find($id);
    }

    public function createNewSale(CreateNewSaleDTO $dto)
    {
        $product = $this->courseRepository->getCourseById($dto->product_id);
        $authUser = $this->userRepository->findByAuth();
        $bankUsers = $this->bankRepository->findBankByUserId($authUser->first()->id);
        $member = $this->userRepository->findByEmail($dto->email_member);

        $currentPrice = $product->price - ($product->price * ($product->discount / 100));

        $password = null;
        if ($member === null) {
            $password = generatePassword();
            $userDto = new CreateUserDTO(
                $dto->name,
                $dto->email_member,
                bcrypt($password),
                'default_device' // ou alguma lógica para definir o device_name
            );

            $member = $this->userRepository->create($userDto);
        }

        $newSale = Sale::create([
            'product_id' => $product->id,
            'user_id' => $member->id,
            'producer_id' => $authUser->first()->id,
            'email_member' => $dto->email_member,
            'transaction' => $dto->transaction,
            'date_expired' => $dto->date_expired,
            'status' => $dto->status,
            'discount' => $product->discount,
            'sale_price' => $currentPrice,
            'sales_channel' => 'VP',
            'payment_mode' => 'Banco',
            'date_created' => $dto->date_created,
            'product_type' => $dto->product_type
            ]);

        event(new SaleToNewAndOldMembers($member, $product, $password, $bankUsers));

        return $newSale;
    }

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
