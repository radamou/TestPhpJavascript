<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    private const SERIALIZATION_GROUP = ['groups' => 'show_user'];

    #[Route('/profile', name: 'user_profile', methods: ['GET'])]
    public function index(#[CurrentUser] ?User $user, SerializerInterface $serializer): Response
    {
        return new Response(
            $serializer->serialize($user, 'json', self::SERIALIZATION_GROUP),
            Response::HTTP_OK
        );
    }
}
