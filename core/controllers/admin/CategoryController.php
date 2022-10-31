<?php

declare(strict_types=1);

namespace App\core\controllers\admin;

use App\core\Application;
use App\core\contracts\CategoryContract;
use App\core\Controller;
use App\core\exception\CommonException;
use App\core\exception\ValidationException;
use App\core\repositories\PostRepository;
use App\core\Request;
use App\core\Response;
use App\models\Category;

class CategoryController extends Controller
{
    protected Category $model;

    public function __construct(protected CategoryContract $categoryRepository, protected PostRepository $postRepository)
    {
        $this->layout = "admin/app";
        $this->model = new Category();
    }

    public function index(): string
    {
        $categories = $this->categoryRepository->listCategories();
        return $this->render("admin/categories/index", [
            "categories" => $categories
        ]);
    }

    public function create(): string
    {
        return $this->render("admin/categories/create");
    }

    public function store(Request $request, Response $response): void
    {
        if ($this->model->loadData($request->getBody())) {
            if (
                $this->validate([
                    "name" => ["required", "string", "unique"],
                    "description" => ["required"]
                ]) && $this->categoryRepository->createCategory($request->getBody())
            ) {
                // Application::$app->session->setFlash("Success", "Category Added");
                $response->redirect("/admin/category");
                exit;
            }
            throw new ValidationException($this->errors);
        }
        throw new ValidationException(["Failed to load data beacause of wrong data types"]);
    }

    public function update(Request $request): string
    {
        $data = $request->getBody();
        $id = (int) array_pop($data);
        if ($request->method() === "post") {
            $this->categoryRepository->updateCategory($data, $id);
            return $this->index();
        }

        $category = $this->categoryRepository->findCategoryById($id);
        return $this->render("admin/categories/update", ["category" => $category]);
    }

    public function delete(Request $request): string
    {
        $id = (int) $request->getBody()["id"];
        $app = Application::$app->db->pdo;
        try {
            $app->beginTransaction();
            $posts = $this->postRepository->findPostsByCategory($id);
            foreach ($posts as $post) {
                $this->postRepository->deletePost($post["id"]);
            }

            $this->categoryRepository->deleteCategory($id);
            $app->commit();
        } catch (CommonException $e) {
            if ($app->inTransaction()) {
                $app->rollBack();
            }
            return $e->dump();
        }

        return $this->index();
    }
}
