<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{
    private const SERIALIZATION_GROUP = ['groups' => 'comment_show'];

    private CommentRepository $commentRepository;
    private FormFactoryInterface $factory;
    public function __construct(CommentRepository $commentRepository, FormFactoryInterface $factory)
    {
        $this->commentRepository = $commentRepository;
        $this->factory = $factory;
    }

    #[Route('/api/v1.0/comment', name: 'api_comment', methods: ['POST'])]
    public function create(#[CurrentUser] ?User $user, Request $request, SerializerInterface $serializer): Response
    {
        $form = $this->factory->create(CommentType::class, new Comment());
        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new JsonResponse($form->getErrors());
        }

        /** @var Comment $entity */
        $entity = $form->getData();
        $entity->setCreatedBy($user);

        $this->commentRepository->save($entity, true);

        return new Response(
            $serializer->serialize($form->getData(), 'json', self::SERIALIZATION_GROUP),
            Response::HTTP_OK
        );
    }
}
