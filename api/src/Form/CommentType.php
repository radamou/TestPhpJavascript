<?php

namespace App\Form;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    private CommentRepository $commentRepository;
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('target', TextType::class)
            ->add('notation', TextType::class)
        ;

        $builder
            ->addEventListener(FormEvents::SUBMIT, [$this, 'onPostSubmit']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'csrf_protection' => false
        ]);
    }

    #[NoReturn] public function onPostSubmit(FormEvent $event) {
          $data = $event->getData();

          if ($data->getTarget()) {
              $target = $this->commentRepository->find($data->getTarget());

              if (!$target) {
                $event->getForm()->addError(new FormError("The target comment does not exist"));
              }
          }
    }
}
