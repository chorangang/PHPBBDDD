<?php

namespace App\Controllers;

use App\ApplicationServices\CommentApplicationService;
use Framework\Request;
use Framework\Response;

class CommentsController
{
    public function index(Request $request, int $thread_id): Response
    {
        $res = (new CommentApplicationService)->getComments($thread_id);

        return new Response($res);
    }
    
    public function show(Request $request, int $id): Response
    {
        $res = (new CommentApplicationService)->getComment($id);

        return new Response($res);
    }

    public function store(Request $request): Response
    {
        $params = $request->getPostParams();

        $res = (new CommentApplicationService)->createComment($params);

        return new Response($res);
    }

    public function update(Request $request, int $id): Response
    {
        $params = $request->getPostParams();

        $res = (new CommentApplicationService)->updateComment($params, $id);

        return new Response($res);
    }

    public function destroy(Request $request, int $id): Response
    {
        $res = (new CommentApplicationService)->deleteComment($id);

        return new Response($res);
    }
}
