<?php

namespace app\controllers\user;

use app\core\Controller;
use app\core\middlewares\UserAuthenticationMiddleware;
use app\core\repositories\AdminRepository;
use app\core\repositories\PostRepository;

class SiteController extends Controller
{
    public function __construct(protected PostRepository $postRepository)
    {
        $this->registerMiddleware(new UserAuthenticationMiddleware("user", [""]));
    }

    /**
     * Load home page
     */
    public function home(): string
    {
        $posts = $this->postRepository->findPostsByCategory(10);
        $notices = $this->postRepository->findPostsByCategory(9);

        $params = [
            "name" => "Blog",
            "posts" => $posts,
            "notices" => $notices,
        ];

        return $this->render("home", $params);
    }
}
