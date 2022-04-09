<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     *
     */
    public function getAllUsers()
    {
        return $this->userRepository->getAllusers();
    }

    /**
     *
     */
    public function getUserById(int $id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            throw new Exception('Usuário não encontrado!', -404);
        }

        return $user;
    }

    /**
     *
     */
    public function makeUser(array $user)
    {
        $user['password'] = bcrypt($user['password']);

        $data =  $this->userRepository->createUser($user);
        return $data;
    }

    /**
     *
     */
    public function updateUser(int $id, array $userData)
    {
        $user = $this->userRepository->getUserById($id);


        if (!$user) {
            throw new Exception('Usuário não encontrado!', -404);
        }

        if (!empty($userData['password']))
            $userData['password'] = bcrypt($userData['password']);


        $data = $this->userRepository->updateUser($user, $userData);
        return $data;
    }

    /**
     *
     */
    public function destroyUser(int $id)
    {
        $user = $this->userRepository->getUserById($id);

        if (!$user) {
            throw new Exception('Usuário não encontrado!', -404);
        }
        $this->userRepository->destroyUser($user);

        return $user;
    }
}
