<?php

namespace App\Domain\DomainServices;

use App\Repositories\CommentRepository;


class CommentDomainService
{
    public function exists(int $id): bool
    {
        return (new CommentRepository)->find($id) === null;
    }
}