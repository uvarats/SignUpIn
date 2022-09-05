<?php

declare(strict_types=1);

namespace App\Controller;

use App\Crud\UserCrud;
use App\View;

class MainController
{
    private UserCrud $userCrud;

    public function __construct(UserCrud $userCrud)
    {
        $this->userCrud = $userCrud;
    }

    public function mainPage()
    {
        $params = [];
        if (isset($_SESSION['login'])) {
            $user = $this->userCrud->get(['login' => $_SESSION['login']])[0];
            if ($user) {
                $params['user'] = $user;
            }
        }
        echo View::getTwig()->render('index.html.twig', $params);
    }
}
