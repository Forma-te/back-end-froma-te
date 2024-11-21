<?php

namespace App\Services;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateBibliographyUserDTO;
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

    public function getAllProducers(
        string $filter = null,
        int $page = 1,
        int $totalPerPage  = 15
    ) {
        return $this->repository->getAllProducers(
            filter: $filter,
            page: $page,
            totalPerPage: $totalPerPage,
        );
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

        $dto->profile_photo_path = $this->processFileUpload(
            $dto->profile_photo_path,
            $user?->profile_photo_path,
            'usersImage',
            $dto->name
        );

        $dto->proof_path = $this->processFileUpload(
            $dto->proof_path,
            $user?->proof_path,
            'usersFile',
            $dto->name
        );

        return $this->repository->update($dto);
    }

    private function processFileUpload(?UploadedFile $file, ?string $existingFilePath, string $folder, string $name): ?string
    {
        if ($file) {
            if ($existingFilePath) {
                $this->uploadFile->removeFile($existingFilePath);
            }

            $customFileName = Str::of($name)->slug('-') . '.' . $file->getClientOriginalExtension();
            return $this->uploadFile->storeAs($file, $folder, $customFileName);
        }

        return $existingFilePath;
    }

    public function updateBibliographyUser(UpdateBibliographyUserDTO $dto): ?User
    {
        return $this->repository->updateBibliographyUser($dto);
    }

    public function delete(string $id): bool
    {
        return $this->repository->delete($id);
    }

}
