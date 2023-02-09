<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class ArticleController extends AbstractController
{
    private ArticleRepository $repository;
    private FormFactoryInterface $factory;
    private const SERIALIZATION_GROUP = ['groups' => 'article_show'];

    public function __construct(ArticleRepository $repository, FormFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    #[Route('/api/v1.0/article', name: 'api_article', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user, Request $request, SerializerInterface $serializer): Response
    {
        $form = $this->factory->create(ArticleType::class, new Article());
        $form->submit(json_decode($request->getContent(), true));

        if (!$form->isSubmitted() || !$form->isValid()) {
            return new Response(
                $serializer->serialize($form->getErrors(), 'json'),
                Response::HTTP_BAD_REQUEST
            );
        }

        /** @var Article $entity */
        $entity = $form->getData();
        $entity->setAuthor($user);
        $this->repository->save($entity, true);

        return new Response(
            $serializer->serialize($form->getData(), 'json', self::SERIALIZATION_GROUP),
            Response::HTTP_OK
        );
    }
}
