<?php if (!LOADED) exit;

use App\Controllers\AuthController;
use App\Controllers\CommentsController;
use App\Controllers\ThreadsController;

return [
    // Authentication
    ["POST", "/api/register", [AuthController::class, "register"]],
    ["POST", "/api/login",    [AuthController::class, "login"]],
    ["POST", "/api/logout",   [AuthController::class, "logout"]],
    ["GET",  "/api/user",     [AuthController::class, "user"]],

    // User
    // ["GET", "/api/users", [UserController::class, "index"]],
    // ["PUT", "/api/user/{id}", [UserController::class, "update"]],
    // ["DELETE", "/api/user/{id}", [UserController::class, "delete"]],

    // Threads
    ["GET",    "/api/threads",      [ThreadsController::class, "index"]],
    ["GET",    "/api/threads/{id}", [ThreadsController::class, "show"]],
    ["POST",   "/api/threads",      [ThreadsController::class, "store"]],
    ["PUT",  "/api/threads/{id}", [ThreadsController::class, "update"]],
    ["DELETE", "/api/threads/{id}", [ThreadsController::class, "destroy"]],

    // Comments
    ["GET", "/api/threads/{thread_id}/comments", [CommentsController::class, "index"]],
    ["GET", "/api/comments/{id}",                [CommentsController::class, "show"]],
    ["POST", "/api/comments",                    [CommentsController::class, "store"]],
    ["PATCH", "/api/comments/{id}",              [CommentsController::class, "update"]],
    ["DELETE", "/api/comments/{id}",             [CommentsController::class, "destroy"]],
];
