<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getAllusers();
    public function getUserById(int $id);
    public function createUser(array $user);
    public function updateUser(object $user, array $userData);
    public function destroyUser(object $user);

}
