<?php

namespace App\Controllers;

use App\ApplicationServices\ThreadApplicationService;
use Framework\Request;
use Framework\Response;


class ThreadsController
{
    public function index(Request $request)
    {
        $params = $request->getParams();

        $res = (new ThreadApplicationService)->getThreads($params);

        return new Response($res);
    }

    public function show(Request $request, int $id)
    {
        $res = (new ThreadApplicationService)->getThread($id);

        return new Response($res);
    }

    public function store(Request $request)
    {
        $params = $request->getPostParams();

        $res = (new ThreadApplicationService)->createThread($params['userId'], $params['title'], $params['body']);

        return new Response($res);
    }

    public function update(Request $request, int $id)
    {
        $params = $request->getPostParams();

        $res = (new ThreadApplicationService)->updateThread($id, $params['title'], $params['body']);

        return new Response($res);
    }

    public function destroy(Request $request, int $id)
    {
        $res = (new ThreadApplicationService)->deleteThread($id);

        return new Response($res);
    }
}
