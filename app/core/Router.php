<?php

class Router {
    private array $routes = [];

    public function add(string $method, string $url, string $controller, string $action): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'url' => $url,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function get(string $url, string $controller, string $action): void 
    {
        $this->add('GET', $url, $controller, $action);
    }

    public function post(string $url, string $controller, string $action): void
    {
        $this->add('POST', $url, $controller, $action);
    }

    public function dispatch(): void
    {
        $url = $this->getUrl();
        $method = $_SERVER['REQUEST_METHOD'];

        foreach($this->routes as $route) {
            if ($route['url'] == $url && $route['method'] === $method) {
                $this->load($route['controller'], $route['action']);
                return;
            }
        }

        $this->notFound();

    }

    public function load(string $controller, string $action): void
    {
        $file = __DIR__ . '/../controllers/' . $controller . '.php';

        if (file_exists($file)) {
            require_once $file;
            $ctrl = new $controller();
            $ctrl->$action();
        } else {
            $this->notFound();
        }
    }

    public function getUrl(): string 
    {
        $url = $_SERVER['REQUEST_URI'] ?? '/';

        $basePath = parse_url(BASE_URL, PHP_URL_PATH);
        if ($basePath && str_starts_with($url, $basePath)) {
            $url = substr($url, strlen($basePath));
        }

        $url = strtok($url, '?');

        return '/' . trim($url, '/');
    }


    public function notFound(): void
    {
        http_response_code(404);
        require_once __DIR__ . '/../views/errors/404.php';
        exit;
    }
}