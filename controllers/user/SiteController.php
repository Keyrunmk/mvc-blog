<?php

declare(strict_types=1);

namespace App\controllers\user;

use App\core\Controller;
use App\core\middlewares\UserAuthenticationMiddleware;
use App\core\repositories\CategoryRepository;
use App\core\repositories\PostRepository;
use App\core\Request;

class SiteController extends Controller
{
    public function __construct(protected PostRepository $postRepository, protected CategoryRepository $categoryRepository)
    {
        $this->registerMiddleware(new UserAuthenticationMiddleware("user", [""]));
    }

    /**
     * Load home page
     */
    public function home(): string
    {
        $categories = $this->categoryRepository->listCategories();;
        $posts = $this->postRepository->findPostsByCategory(10);
        $notices = $this->postRepository->findPostsByCategory(9);

        $params = [
            "name" => "Blog",
            "categories" => $categories,
            "posts" => $posts,
            "notices" => $notices,
        ];

        return $this->render("home", $params);
    }

    public function showPosts(Request $request)
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
