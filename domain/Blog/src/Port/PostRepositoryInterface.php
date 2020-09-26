<?php

namespace Domain\Blog\Port;

use Domain\Blog\Entity\Post;

interface PostRepositoryInterface
{
    public function save(Post $post);
    public function findOne(string $uuid): ?Post;
}
