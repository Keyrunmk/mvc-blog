<?php

declare(strict_types=1);

namespace App\core\controllers\admin;

use App\core\Application;
use App\core\contracts\AdminContract;
use App\core\Controller;
use App\core\middlewares\RoleMiddleware;
use App\core\Request;
use App\core\Response;
use App\models\Admin;
use Exception;
use Throwable;

class AdminController extends Controller
{
    protected Admin $model;

    protected AdminContract $adminRepository;

    public function __construct(AdminContract $adminRepository)
    {
        $this->layout = "admin/app";
        $this->model = Application::$app->admin;
        $this->adminRepository = $adminRepository;
        $this->registerMiddleware(new RoleMiddleware($this->model, ["page-admin", "page-manager"]));
    }

    public function dashboard(): string
    {
        return $this->render("admin/dashboard/dashboard");
    }

    public function create(): string
    {
        $currentRoles = $this->model->roles();
        $roles = $this->model->getAllRoles();
        if (in_array("page-admin", $currentRoles)) {
            $roles = $roles;
        } elseif (in_array("page-manager", $currentRoles)) {
            $roles = [$roles[0]];
        }
        return $this->render("admin/users/create", ["roles" => $roles]);
    }

    public function store(Request $request)
    {
        $data = $request->getBody();
        $role_id = (int) array_shift($data);

        if ($this->model->loadData($data)) {
            $validate = $this->validate([
                "name" => ["required"],
                "password" => ["required", ["min" => 8]],
            ]);

            if ($validate) {
                try {
                    Application::$app->db->pdo->beginTransaction();

                    $adminId = $this->adminRepository->createAdmin($data);
                    $this->adminRepository->addAdminRole($adminId, $role_id);

                    Application::$app->db->pdo->commit();
                } catch (Exception | Throwable $e) {
                    if (Application::$app->db->pdo->inTransaction()) {
                        Application::$app->db->pdo->rollBack();
                    }
                    throw $e;
                }
            }
        }
        return Response::redirect("/admin");
    }

    public function update(): string
    {
        return $this->render("admin/users/update");
    }

    public function delete()
    {
        return "delete admin users";
    }

    public function index(): string
    {
        return $this->render("admin/dashboard/index");
    }

    public function settings(): void
    {
        echo ("hello from settings");
    }
}
