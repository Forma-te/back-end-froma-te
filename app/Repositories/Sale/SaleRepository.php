<?php

namespace App\Repositories\Sale;

use App\DTO\Sale\CreateNewSaleDTO;
use App\DTO\Sale\UpdateNewSaleDTO;
use App\DTO\User\CreateUserDTO;
use App\Models\Sale;
use App\Models\User;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Course\CourseRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Mail;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(
        protected CourseRepository $courseRepository,
        protected UserRepository $userRepository,
        protected BankRepository $bankRepository,
    ) {
    }

    public function createNewSale(CreateNewSaleDTO $dto)
    {
        $course = $this->courseRepository->getCourseById($dto->course_id);

        $authUser = $this->userRepository->findByAuth();

        $member =  User::where('email', $dto->email_student)->first();
        //$member = $this->userRepository->getAll($dto->email_student);

        if($member === null) {
            $password = generatePassword();
            $userDto = new CreateUserDTO(
                $dto->name,
                $dto->email_student,
                bcrypt($password),
                'default_device' // ou alguma lógica para definir o device_name
            );

            $member = $this->userRepository->create($userDto);

            Mail::to($dto->email_student);
        } else {
            Mail::to($dto->email_student);
        }

        $userId = $member['id'];

        $newSale = Sale::create([
            'course_id' => $course->first()->id,
            'user_id' => $userId,
            'instrutor_id' => $authUser->first()->id,
            'email_student' => $dto->email_student,
            'transaction' => $dto->transaction,
            'date_expired' => $dto->date_expired,
            'status' => 'approved',
            'blocked' => $dto->blocked,
            'payment_mode' => 'banco',
            'date_created' => $dto->date_created

            ]);

        return $newSale;
    }

    public function updateNewSale(UpdateNewSaleDTO $dto)
    {
    }
}
