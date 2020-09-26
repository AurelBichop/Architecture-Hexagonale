<?php

use App\Controller\CreatePostController;
use Domain\Blog\Test\Adapters\InMemoryPostRepository;
use Domain\Blog\UseCase\CreatePost;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$repo = new InMemoryPostRepository;

$useCase = new CreatePost($repo);

$controller = new CreatePostController($useCase);

$response = $controller->handleRequest($request);

$response->send();
