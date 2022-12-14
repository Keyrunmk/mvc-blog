<?php

namespace app\core;

class View
{
    public string $title = '';

    public function renderView(string $view, array $params = []): string
    {
        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Returns the contents of mentioned view file with the parameters and set the key of parameter as the varibale holding value
     * e.g. ['name' => 'kiran'] => $$key = $value => $(name) => 'kiran' => $name => 'kiran'
     */
    public function renderOnlyView(string $view, array $params): string
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        };
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    /**
     * Load layout file to output buffer
     */
    public function layoutContent(): string
    {
        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/$layout.php";
        return ob_get_clean();
    }


    public function renderContent(string $viewContent): string
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderSingleView(string $view, array $params): void
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        };
        include_once Application::$ROOT_DIR . "/views/$view.php";
    }
}
