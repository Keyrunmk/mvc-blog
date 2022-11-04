<?php

declare(strict_types=1);

use App\core\contracts\CategoryContract;
use App\core\contracts\CategoryPostContract;
use App\core\contracts\PostContract;
use App\core\middlewares\AdminAuthenticationMiddleware;
use App\core\middlewares\UserAuthenticationMiddleware;
use App\core\repositories\CategoryPostRepository;
use App\core\repositories\CategoryRepository;
use App\core\repositories\PostRepository;
use App\core\singletons\Dependency;

/**
 *  DI Container Instance
 */
$dependency = Dependency::getInstance();

/**
 * Define here the required dependencies for your Applications
 */

//Repository Binding
$dependency->set(CategoryContract::class, CategoryRepository::class);
$dependency->set(PostContract::class, PostRepository::class);
$dependency->set(CategoryPostContract::class, CategoryPostRepository::class);

//Middleware Binding
$dependency->set("authUser", UserAuthenticationMiddleware::class);
$dependency->set("authAdmin", AdminAuthenticationMiddleware::class);