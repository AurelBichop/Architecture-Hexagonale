<?php

namespace Domain\Blog\Test\Adapters;

use Domain\Blog\Entity\Post;
use Domain\Blog\Port\PostRepositoryInterface;

class InMemoryPostRepository implements PostRepositoryInterface
{
    public array $posts = [];

    public function save(Post $post)
    {
        $this->posts[$post->uuid] = $post;
    }

    public function findOne(string $uuid): ?Post
    {
        return $this->posts[$uuid] ?? null;
    }
}
