<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\contracts\CategoryContract;
use app\core\Controller;
use app\core\db\DBModel;
use app\core\repositories\CategoryRepository;
use app\core\Request;
use app\core\traits\ValidationTrait;
use app\models\Category;

class CategoryController extends Controller
{
    use ValidationTrait;

    protected Category $model;

    public function __construct(protected CategoryContract $categoryRepository)
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

    public function store(Request $request): void
    {
        if ($this->model->loadData($request->getBody())) {
            if (
                $this->validate([
                    "name" => ["required"],
                    "description" => ["required"]
                ]) && $this->categoryRepository->createCategory($request->getBody())
            ) {
                // Application::$app->session->setFlash("Success", "Category Added");
                Application::$app->response->redirect("/admin/category");
            }
        }
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
        $this->categoryRepository->deleteCategory($id);

        return $this->index();
    }
}
