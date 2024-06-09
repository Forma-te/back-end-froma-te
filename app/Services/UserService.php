<?php

namespace App\Services;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use stdClass;
use Illuminate\Support\Str;

class UserService
{
    private $repository;
    protected $uploadFile;

    public function __construct(UserRepositoryInterface $repository, UploadFile $uploadFile)
    {
        $this->repository = $repository;
        $this->uploadFile = $uploadFile;

    }

    public function getAll(string $filter = '')
    {
        return $this->repository->getAll($filter);

    }

    public function findById(string $id): object|null
    {
        return $this->repository->findById($id);
    }

    public function findByEmail(string $email)
    {
        return $this->repository->findByEmail($email);
    }

    public function create(CreateUserDTO $dto): object
    {
        // Criar o usuário no repositório
        $user = $this->repository->create($dto);

        // Gerar o token de autenticação
        $token = $user->createToken($dto->device_name)->plainTextToken;

        // Retornar o usuário e o token
        return (object) [
            'user' => $user,
            'token' => $token
        ];
    }

    public function update(UpdateUserDTO $dto): ?User
    {
        $user = $this->repository->findById($dto->id);

        if ($dto->image instanceof UploadedFile) {
            if ($user && $user->file) {
                $this->uploadFile->removeFile($user->image);
            }
            $image = $dto->image;
            $customImageName = Str::of($dto->id)->slug('-') . '.' . $image->getClientOriginalExtension();
            $uploadedFilePath = $this->uploadFile->storeAs($dto->image, 'usersImage', $customImageName);

            $dto->image = $uploadedFilePath;
        } else {
            unset($dto->image);
        }
        return $this->repository->update($dto);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }
}
