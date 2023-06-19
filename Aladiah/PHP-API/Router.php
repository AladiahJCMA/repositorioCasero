<?php
declare(strict_types=1);

require_once 'controller/UsersController.php';
require_once 'controller/PostsController.php';
require_once 'controller/ThemesController.php';
require_once 'controller/SubthemesController.php';
require_once 'controller/PostTypesController.php';
require_once 'tools/ConnectionDB.php';

class Router {
    private $routes = [];

    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
    }

    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
    }

    public function put($path, $handler) {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete($path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute($method, $path, $handler) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function dispatch() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestPath = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route) {
            if ($route['method'] === $requestMethod && $this->matchPath($route['path'], $requestPath)) {
                $handlerParts = explode('@', $route['handler']);
                $controllerName = $handlerParts[0];
                $methodName = $handlerParts[1];
                $controller = new $controllerName();
                $controller->$methodName();
                return;
            }
        }

        // Handle 404 - Route not found
        header('HTTP/1.1 404 Not Found');
        echo '404 Not Found Router.php';
    }

    private function matchPath($routePath, $requestPath) {
        // Remove query string from the request path
        $requestPath = strtok($requestPath, '?');
    
        // Split the route and request paths into segments
        $routeSegments = explode('/', trim($routePath, '/'));
        $requestSegments = explode('/', trim($requestPath, '/'));
    
        $i = 0;
        $flag = true;

        // Check if the number of segments is the same
        if (count($routeSegments) !== count($requestSegments)) {
            $flag = false;
            $i = count($routeSegments) + 1;
        }

        // Iterate over each segment and check for parameter or exact match
        for (; $i < count($routeSegments); $i++) {
            $routeSegment = $routeSegments[$i];
            $requestSegment = $requestSegments[$i];
    
            if ((strpos($routeSegment, '{') === 0) && 
            (strpos($routeSegment, '}') === strlen($routeSegment) - 1)) {
                // This segment is a parameter
                file_put_contents(substr($routeSegment, 1, -1), $requestSegment);
            } else if ($routeSegment !== $requestSegment) {
                // Exact match required
                $flag = false;
                $i = count($routeSegments) + 1;
            }
        }
    
        return $flag;
    }
}
