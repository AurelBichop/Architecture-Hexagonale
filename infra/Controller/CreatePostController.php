<?php

namespace App\Controller;

use DateTime;
use Domain\Blog\UseCase\CreatePost;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreatePostController
{
    protected CreatePost $action;

    public function __construct(CreatePost $action)
    {
        $this->action = $action;
    }

    public function handleRequest(Request $request)
    {
        if ($request->isMethod('GET')) {
            //Montrer le formulaire
            ob_start();
            include __DIR__ . '/../templates/form.html.php';
            return new Response(ob_get_clean());
        }

        //sinon traiter le formulaire en appelant le useCase
        $post = $this->action->execute([
            'title' => $request->request->get('title',''),
            'content' => $request->request->get('content', ''),
            'publishedAt' => $request->request->has('published') ?
            new DateTime() :
            null 
        ]);

        return new Response("<h1>$post->title</h1>");
    }
}
