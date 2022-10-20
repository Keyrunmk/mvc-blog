<?php

declare(strict_types=1);

use app\core\singletons\Container;
use app\core\contracts\CategoryContract;
use app\core\contracts\CategoryPostContract;
use app\core\contracts\PostContract;
use app\core\repositories\CategoryPostRepository;
use app\core\repositories\CategoryRepository;
use app\core\repositories\PostRepository;

$container = Container::getInstance();
$container->set(CategoryContract::class, CategoryRepository::class);
$container->set(PostContract::class, PostRepository::class);
$container->set(CategoryPostContract::class, CategoryPostRepository::class);