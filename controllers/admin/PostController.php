<?php

declare(strict_types=1);

namespace App\controllers\admin;

use App\core\Application;
use App\core\Controller;
use App\core\exception\ValidationException;
use App\core\repositories\CategoryPostRepository;
use App\core\repositories\CategoryRepository;
use App\core\repositories\PostRepository;
use App\core\Request;
use App\core\traits\ValidationTrait;
use App\models\Post;

class PostController extends Controller
{
    use ValidationTrait;

    public function __construct(
        protected PostRepository $postRepository,
        protected CategoryRepository $categoryRepository,
        protected CategoryPostRepository $categoryPostRepository,
        protected Post $model
    ) {
        $this->layout = "admin/app";
    }

    public function index(): string
    {
        $posts = $this->postRepository->listPosts();
        return $this->render("admin/post/index", ["posts" => $posts]);
    }

    public function create(): string
    {
        $categories = $this->categoryRepository->listCategories();
        return $this->render("admin/post/create", [
            "categories" => $categories
        ]);
    }

    public function store(Request $request): void
    {
        $data = $request->getBody();
        $ids["category_id"] = (int) array_shift($data);

        if ($this->model->loadData($data)) {
            if (!$this->validate([
                "name" => ["required", "string", "unique"],
                "status" => ["required"],
            ])) {
                throw new ValidationException($this->errors);
            }
        }

        try {
            Application::$app->db->pdo->beginTransaction();

            $this->model->loadData($data);
            $ids["post_id"] = (int) $this->postRepository->createPost($data);
            $this->categoryPostRepository->createCategoryPost($ids);

            Application::$app->db->pdo->commit();
        } catch (\Throwable $e) {
            if (Application::$app->db->pdo->inTransaction()) {
                Application::$app->db->pdo->rollBack();
            }
            throw new ValidationException(["wrong data given, no records were persisted"]);
        }

        // Application::$app->session->setFlash("Success", "Product Added");
        Application::$app->response->redirect("/admin/posts");
    }

    public function update(Request $request): string
    {
        $data = $request->getBody();
        $id = (int) array_pop($data);

        $this->postRepository->updatePost($data, $id);
        return $this->index();

        $post = $this->postRepository->findPostById($id);
        return $this->render("admin/post/update", ["post" => $post]);
    }

    public function delete(Request $request): string
    {
        $id = (int) $request->getBody()["id"];
        $this->postRepository->deletePost($id);
        return $this->index();
    }
}
