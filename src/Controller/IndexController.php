<?php

namespace App\Controller;
use App\Repository\UserRepository;

class IndexController
{

    public function __construct(
      private UserRepository $userRepository
    )
    {}

    public function index()
    {
        $users = $this->userRepository->getUsers();
        /*if (empty($user)) {
            throw new \Exception('Пользователь не найден!');
        }*/
        return $users;
    }

}