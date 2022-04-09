<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;


class UserRepository implements UserRepositoryInterface
{

    protected $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    /**
     * Pegar todos usuários
     * @return array
     */
    public function getAllusers()
    {
        return $this->entity->paginate();
    }

    /**
     * Seleciona usuário por ID
     * @param int $id
     * @return object
     */
    public function getUserById(int $id)
    {
        return $this->entity->where('id', $id)->first();
    }

    /**
     * Cria um novo usuário
     * @param array $user
     * @return object
     */
    public function createUser(array $user)
    {
        $user = $this->entity->create($user);
        return $user;
    }

    /**
     * Atualiza os dados do usuário
     * @param object $user
     * @param array $userData
     * @return object
     */
    public function updateUser(object $user, array $userData)
    {
        $user->update($userData);
        return $user;
    }

    /**
     * Deleta um usuário
     * @param object $user
     */
    public function destroyUser(object $user)
    {
        $user->delete();
        return $user;
    }
}
