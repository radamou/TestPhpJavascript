<?php

namespace App\Controller;

use App\Services\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CommentController extends AbstractController
{
    private const SERIALIZATION_GROUP = ['groups' => 'comment_show'];


    #[Route('/api/v1.0/comment', name: 'api_comment', methods: ['POST'])]
    public function create(
        Request $request,
        SerializerInterface $serializer,
        CommentService $commentService
    ): Response
    {
        $res = $commentService->upsert(json_decode($request->getContent(), true));

        return new Response(
            $serializer->serialize($res, 'json', self::SERIALIZATION_GROUP),
            Response::HTTP_OK
        );
    }

    #[Route('/api/v1.0/comments', name: 'api_comments', methods: ['GET'])]
    public function list(SerializerInterface $serializer, CommentService $commentService): Response
    {
        $res = $commentService->fetchComments();

        return new Response(
            $serializer->serialize($res, 'json', self::SERIALIZATION_GROUP),
            Response::HTTP_OK
        );
    }

    #[Route('/api/v1.0/comments/{uuid}', name: 'api_comment_detail', methods: ['GET'])]
    public function detail(string $uuid, SerializerInterface $serializer, CommentService $commentService): Response
    {
        $res = $commentService->fetchComment($uuid);

        return new Response(
            $serializer->serialize($res, 'json', self::SERIALIZATION_GROUP),
            Response::HTTP_OK
        );
    }

    #[Route('/api/v1.0/comments/{uuid}', name: 'api_comment_edit', methods: ['POST'])]
    public function edit(
        string $uuid,
        SerializerInterface $serializer,
        CommentService $commentService,
        Request $request
    ): Response
    {
        $res = $commentService->upsert(
            json_decode($request->getContent(), true),
            $uuid
        );

        return new Response(
            $serializer->serialize($res, 'json', self::SERIALIZATION_GROUP),
            Response::HTTP_OK
        );
    }
}
