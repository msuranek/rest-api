<?php
namespace Controllers;

use Framework\JsonResponse;
use Models\User;
use Router\Route;

class ApiController
{
    #[Route(path: '/api/user', method: 'GET')]
    public function getUser(): void
    {
        $user = new User(1, 'Jan Novak', 'jan.novak@example.com', 30);

        $response = new JsonResponse([
            'status' => 'success',
            'data'   => $user,
        ]);

        $response->send();
    }
}
