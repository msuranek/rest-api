<?php
namespace Router;

use ReflectionClass;
use ReflectionMethod;

#[\Attribute]
class Route
{
    public string $path;
    public string $method;

    public function __construct(string $path, string $method = 'GET')
    {
        $this->path = $path;
        $this->method = strtoupper($method);
    }
}

class Router
{
    /** @var array<string, array{object, ReflectionMethod, Route}> */
    private array $routes = [];

    /**
     * Registruje všechny metody kontroleru, které mají atribut Route
     *
     * @param object $controller
     */
    public function registerController(object $controller): void
    {
        $rc = new ReflectionClass($controller);

        foreach ($rc->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
            $attrs = $method->getAttributes(Route::class);
            if (count($attrs) === 0) {
                continue;
            }
            /** @var Route $route */
            $route = $attrs[0]->newInstance();

            // Klíč pro rychlé hledání: metoda + path
            $key = $route->method . ' ' . $route->path;

            $this->routes[$key] = [$controller, $method, $route];
        }
    }

    /**
     * Dispatch request: najde a zavolá správnou metodu kontroleru
     *
     * @param string $uri URI požadavku (např. "/api/user?foo=bar")
     * @param string $httpMethod HTTP metoda ("GET", "POST", ...)
     */
    public function dispatch(string $uri, string $httpMethod): void
    {
        // Odebereme query string
        $path = parse_url($uri, PHP_URL_PATH);

        $key = strtoupper($httpMethod) . ' ' . $path;

        if (!isset($this->routes[$key])) {
            http_response_code(404);
            header('Content-Type: text/plain; charset=utf-8');
            echo "404 Not Found";
            return;
        }

        [$controller, $method, $route] = $this->routes[$key];

        // Připravíme parametry (z URL query)
        $params = $_GET;

        $rm = $method;
        $args = [];

        // Zkusíme naplnit parametry metody podle jména (typování není zde automaticky řešeno)
        foreach ($rm->getParameters() as $param) {
            $name = $param->getName();
            if (array_key_exists($name, $params)) {
                $args[] = $params[$name];
            } elseif ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            } else {
                // Pokud nemáme parametr, a není default, předáme null
                $args[] = null;
            }
        }

        // Zavoláme metodu s parametry
        $rm->invokeArgs($controller, $args);
    }
}
