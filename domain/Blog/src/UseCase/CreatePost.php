<?php

namespace Domain\Blog\UseCase;

use DateTimeInterface;
use function Assert\lazy;
use Domain\Blog\Entity\Post;
use Assert\LazyAssertionException;

use Domain\Blog\Port\PostRepositoryInterface;
use Domain\Blog\Exception\InvalidPostDataException;

class CreatePost
{
    protected PostRepositoryInterface $postRepository;


    public function __construct(PostRepositoryInterface $repository)
    {
        $this->postRepository = $repository;
    }

    public function execute(array $postData): ?Post
    {
        $post = new Post(
            $postData['title'] ?? '',
            $postData['content'] ?? '',
            $postData['publishedAt'] ?? null
        );

        try {
            $this->validate($post);

            $this->postRepository->save($post);

            return $post;
        } catch (LazyAssertionException $e) {
            throw new InvalidPostDataException($e->getMessage());
        }
    }

    protected function validate(Post $post)
    {
        lazy()->that($post->title)->notBlank()->minLength(3)
            ->that($post->content)->notBlank()->minLength(10)
            ->that($post->publishedAt)->nullOr()->isInstanceOf(DateTimeInterface::class)
            ->verifyNow();
    }
}
