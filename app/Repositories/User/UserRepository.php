<?php

namespace App\Repositories\User;

use App\DTO\User\CreateCustomerDetailsDTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateBibliographyUserDTO;
use App\DTO\User\UpdatePasswordUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll(string $filter = '')
    {
        $users = $this->model
                    ->where(function ($query) use ($filter) {
                        if ($filter) {
                            $query->where('email', $filter);
                            $query->orWhere('name', 'LIKE', "%{$filter}%");
                        }
                    })
                    ->get();
        return $users;
    }

    public function getAllProducers(string $filter = null, int $page = 1, int $totalPerPage = 10)
    {
        $producers = $this->model
                ->with('coursesProducer', 'student')
                ->whereHas('sales', function ($query) {
                    $query->where('status', 'A');
                })
                ->where(function ($query) use ($filter) {
                    if ($filter) {
                        $query->where('name', 'like', "%{$filter}%");
                    }
                })
                ->paginate($totalPerPage, ['*'], 'page', $page);

        return $producers;
    }

    public function findById(string $id): object|null
    {
        return $this->model
                    ->find($id);
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByAuth()
    {
        return $this->model->UserByAuth()->get();
    }

    public function create(CreateUserDTO $dto): object
    {
        return $this->model->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    }

    public function createCustomerDetails(CreateCustomerDetailsDTO $dto): object
    {
        return $this->model->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'phone_number' => $dto->phone_number,
            'password' => $dto->password,
        ]);
    }

    public function updateCustomerDetails(int $userId, array $data): ?User
    {
        try {
            // Encontra o utilizador pelo ID
            $user = $this->model->find($userId);

            if (!$user) {
                Log::warning("Utilizador com ID $userId não encontrado para atualização.");
                return null;
            }

            // Atualiza os dados do utilizador
            $user->update($data);

            return $user;
        } catch (\Exception $e) {
            // Regista o erro e retorna null
            Log::error("Erro ao atualizar detalhes do utilizador", ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function update(UpdateUserDTO $dto): ?User
    {
        $user = $this->model->find($dto->id);

        if ($user) {
            $user->update((array) $dto);
            return $user;
        }

        return null;
    }

    public function updateBibliographyUser(UpdateBibliographyUserDTO $dto): ?User
    {
        $bibliography = $this->model->find($dto->id);

        if ($bibliography) {
            $bibliography->update((array) $dto);
            return $bibliography;
        }

        return null;

    }

    public function UpdatePasswordUser(UpdatePasswordUserDTO $dto): ?User
    {
        $passwordUser = $this->model->find($dto->id);

        if ($passwordUser) {
            $passwordUser->update((array) $dto);
            return $passwordUser;
        }

        return null;
    }

    public function delete(string $id): bool
    {
        if (!$user = $this->findById($id)) {
            return false;
        }

        return $user->delete();
    }
}
