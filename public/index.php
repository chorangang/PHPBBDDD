<?php declare(strict_types=1);

use Dotenv\Dotenv;
use Framework\Kernel;
use Framework\Request;

define("LOADED", true);
define("BASE_PATH", dirname(__DIR__));

require_once dirname(__DIR__) . "/vendor/autoload.php";

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$request = Request::createFromGlobals();

$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();