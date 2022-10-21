<?php

declare (strict_types=1);

namespace app\controllers\admin;

use app\core\Application;
use app\core\contracts\CategoryContract;
use app\core\Controller;
use app\core\exception\CommonException;
use app\core\exception\ValidationException;
use app\core\repositories\PostRepository;
use app\core\Request;
use app\core\Response;
use app\core\traits\ValidationTrait;
use app\models\Category;

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
                    "name" => ["required","string","unique"],
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
