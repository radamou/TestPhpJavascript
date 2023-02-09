<?php

namespace App\Services;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;

class CommentService
{
    private CommentRepository $commentRepository;
    private FormFactoryInterface $factory;
    private ArticleRepository $articleRepository;

    public function __construct(
        CommentRepository $commentRepository,
        FormFactoryInterface $factory,
        ArticleRepository $articleRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->factory = $factory;
        $this->articleRepository = $articleRepository;
    }
    public function upsert(array $data, ?string $uuid = null)
    {
        $comment = new Comment();

        if ($uuid) {
           $comment = $this->commentRepository->findOneByUuid($uuid);
        }

        $form = $this->factory->create(CommentType::class, $comment);

        if (!$uuid && !isset($data['article'])) {
            return [
                "message" => "Article is mandatory to save comment"
            ];
        }

        if (isset($data['article'])) {
          $article = $this->articleRepository->findOneByUuid($data['article']);
          unset($data['article']);
        }

        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $errors = $form->getErrors();

            /** @var FormError $error */
            foreach ($errors as $error) {
                $err[] = [$error->getMessage() => $error->getMessageParameters()];
            }

            return $err ?? [];
        }

        /** @var Comment $entity */
        $entity = $form->getData();

        if (isset($article)) {
            $entity->setArticle($article);
        }

        $this->commentRepository->save($entity, true);

        return $this->commentRepository->findOneByUuid($entity->getUuid());
    }

    public function fetchComments(): array
    {
        return $this->commentRepository->findAll();
    }

    public function fetchComment(string $uuid): Comment
    {
        return $this->commentRepository->findOneByUuid($uuid);
    }
}