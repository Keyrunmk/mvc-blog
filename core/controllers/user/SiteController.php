<?php

declare(strict_types=1);

namespace App\core\controllers\user;

use App\core\contracts\CategoryContract;
use App\core\contracts\PostContract;
use App\core\Controller;
use App\core\middlewares\UserAuthenticationMiddleware;
use App\core\repositories\CategoryRepository;
use App\core\repositories\PostRepository;
use App\core\Request;

class SiteController extends Controller
{
    protected PostRepository $postRepository;
    protected CategoryRepository $categoryRepository;

    public function __construct(PostContract $postRepository, CategoryContract $categoryRepository)
    {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function home(): string
    {
        $categories = $this->categoryRepository->listCategories();;

        $params = [
            "name" => "Blog",
            "categories" => $categories,
        ];

        return $this->render("home", $params);
    }

    public function showPosts(Request $request): string
    {
        $category_id = (int) $request->getBody()['category_id'];
        $posts = $this->postRepository->findPostsByCategory($category_id);
        $params = [
            "name" => "Posts",
            "posts" => $posts,
        ];
        return $this->render("posts", $params);
    }
}
