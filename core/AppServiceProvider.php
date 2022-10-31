<?php

declare(strict_types=1);

use App\core\singletons\Container;
use App\core\contracts\CategoryContract;
use App\core\contracts\CategoryPostContract;
use App\core\contracts\PostContract;
use App\core\middlewares\AdminAuthenticationMiddleware;
use App\core\middlewares\UserAuthenticationMiddleware;
use App\core\repositories\CategoryPostRepository;
use App\core\repositories\CategoryRepository;
use App\core\repositories\PostRepository;

/**
 *  DI Container Instance
 */
$container = Container::getInstance();

/**
 * Define here the required dependencies for your Applications
 */

//Repository Binding
$container->set(CategoryContract::class, CategoryRepository::class);
$container->set(PostContract::class, PostRepository::class);
$container->set(CategoryPostContract::class, CategoryPostRepository::class);

//Middleware Binding
$container->set("authUser", UserAuthenticationMiddleware::class);
$container->set("authAdmin", AdminAuthenticationMiddleware::class);