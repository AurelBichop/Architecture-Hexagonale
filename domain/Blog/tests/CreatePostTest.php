<?php

use Domain\Blog\Entity\Post;
use Domain\Blog\UseCase\CreatePost;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use Domain\Blog\Exception\InvalidPostDataException;
use Domain\Blog\Test\Adapters\InMemoryPostRepository;

it("should create a post", function () {
    $repository = new InMemoryPostRepository;

    $useCase = new CreatePost($repository);

    $post = $useCase->execute([
        'title'      => 'Mon titre',
        'content'    => 'Mon contenu',
        'publishedAt' => new DateTime('2020-01-01 14:30:00')
    ]);

    assertInstanceOf(Post::class, $post);
    assertEquals($post, $repository->findOne($post->uuid));
});

it("should throw a InvalidPostDataException if bad bad data is provided", function($postData){
    $repository = new InMemoryPostRepository;

    $useCase = new CreatePost($repository);

    $post = $useCase->execute($postData);

    assertInstanceOf(Post::class, $post);
    assertEquals($post, $repository->findOne($post->uuid));
})->with([
    [['title'=>'Mon titre', 'publishedAt'=> new DateTime('2020-01-01 14:30:00')]],
    [['publishedAt' => new DateTime('2020-01-01 14:30:00')]],
    [[]],
])->throws(InvalidPostDataException::class);