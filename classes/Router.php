<?php


class Router
{
    /**
     * The url request
     *
     * @var string
     */
    public $url;

    /**
     * The routes array
     *
     * @var array
     */
    public $routes = [];

    /**
     * The current route
     *
     * @var \Classes\Route|null
     */
    public $currentRoute = null;

    /**
     * Current HTTP method
     *
     * @var string
     */
    public $currentMethod;

    /**
     * The parameters
     *
     * @var array
     */
    public $params = [];

    /**
     * All of the verbs supported by the router.
     *
     * @var array
     */
    public static $verbs = ['GET', 'POST', 'PUT', 'DELETE'];

    /**
     * Router constructor
     *
     * @param  string  $url
     * @param  string  $method
     */
    public function __construct(string $url, string $method)
    {
        $this->url           = $url;
        $this->currentMethod = $method;

        // Remove sub folder
        $this->removeSubFolder();

        // Check if url is index
        if (strtoupper($this->url) == '/INDEX') {
            // Redirect to home
            $this->redirect();
        }
    }

    /**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @param  string|callable|null  $action
     */
    public function get($uri, $action = null)
    {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @param  string|callable|null  $action
     */
    public function post($uri, $action = null)
    {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @param  string|callable|null  $action
     */
    public function put($uri, $action = null)
    {
        $this->addRoute('PUT', $uri, $action);
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param  string  $uri
     * @param  string|callable|null  $action
     */
    public function delete($uri, $action = null)
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    /**
     * Register a new route responding to all verbs.
     *
     * @param  string $uri
     * @param  array|string|callable|null $action
     */
    public function any($uri, $action = null)
    {
        $this->addRoute(self::$verbs, $uri, $action);
    }

    /**
     * Add a route to the underlying route collection.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     */
    public function addRoute($methods, $uri, $action)
    {
        array_push($this->routes, new Route($methods, $uri, $action));
    }

    /**
     * Get the pure url request without sub folder
     */
    public function removeSubFolder()
    {
        // Check if site sub folder is not empty
        if (!empty(OPTIONS['SITE_SUB_FOLDER'])) {
            // Is not empty
            $trimmedSubFolder = trim(OPTIONS['SITE_SUB_FOLDER'], '/');

            // Check if request begins with the sub folder
            if (strpos($this->url, $trimmedSubFolder) === 0) {
                // Begins with sub folder
                // Remove it to not be interpreted as a controller and get 404
                $this->url = ltrim($this->url, $trimmedSubFolder);
            }
        }
    }

    /**
     * Redirect home
     *
     * @param  string  $where
     */
    public function redirect(string $where = '')
    {
        // Check if where has value
        if ($where != '') {
            $where =  '/' . $where;
        }

        // Check if localhost
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            // Localhost redirect
            header('location: http://localhost' . OPTIONS['SITE_SUB_FOLDER'] . $where);
            exit();
        } else {
            // Check if HTTPS is set
            if (isset($_SERVER['HTTPS'])) {
                // Check if HTTPs is on
                if ($_SERVER['HTTPS'] == 'on') {
                    // HTTPS redirect
                    header('location: https://www.' . $_SERVER['HTTP_HOST'] . OPTIONS['SITE_SUB_FOLDER'] . $where);
                    exit();
                } else {
                    // HTTP redirect
                    header('location: http://www.' . $_SERVER['HTTP_HOST'] . OPTIONS['SITE_SUB_FOLDER'] . $where);
                    exit();
                }
            } else {
                // HTTP redirect
                header('location: http://www.' . $_SERVER['HTTP_HOST'] . OPTIONS['SITE_SUB_FOLDER'] . $where);
                exit();
            }
        }
    }

    /**
     * Run application
     */
    public function run()
    {
        // Check if there are no routes
        if (!is_array($this->routes) || empty($this->routes)) {
            echo 'No routes found';
        }

        // Get route match
        $this->getRouteMatch();

        // Check if the route was not found
        if ($this->currentRoute == null) {
            $this->redirect('404');
        }

        // Check if action is callable
        if (is_callable($this->currentRoute->action)) {
            call_user_func($this->currentRoute->action, $this->params);
        } else {
            $this->runController($this->currentRoute->action, $this->params);
        }
    }

    /**
     * Run controller
     *
     * @param  string  $controller
     * @param  array  $params
     *
     * @return \App\Controllers\
     */
    public function runController(string $controller, array $params)
    {
        // Check if doesn't have controller and method
        if (strpos($controller, '@') === false) {
            echo 'Missing controller or method for route: <b>' . $controller . '</b>';
            exit();
        }

        // Get route controller and method
        $routeExplode    = explode('@', $controller);
        $routeController = $routeExplode[0];
        $routeMethod     = $routeExplode[1];

        // Get controller path
        $controllerPath = CONTROLLERS . $routeController . '.php';

        // Check if controller doesn't exists
        if (!file_exists($controllerPath)) {
            $this->redirect('404');
        }

        // Check if controller class exists
        if (class_exists($routeController)) {
            $controller = new $routeController();
        } else {
            $this->redirect('404');
        }

        // Check if the controller method doesn't exists
        if (!method_exists($controller, $routeMethod)) {
            $this->redirect('404');
        }

        // Check if the controller is callable
        if (is_callable([$controller, $routeMethod])) {
            return call_user_func([$controller, $routeMethod], $params);
        } else {
            $this->redirect('404');
        }
    }

    /**
     * Get route match
     */
    public function getRouteMatch()
    {
        foreach($this->routes as $route) {
            // Check if HTTP method match
            if (in_array($this->currentMethod, $route->methods)) {
                if ($this->dispatch(cleanUrl($this->url), $route->getUri())) {
                    $this->currentRoute = $route;
                }
            }
        }
    }

    /**
     * Dispatch url and uri
     *
     * @param string $url
     * @param string $pattern
     *
     * @return bool
     */
    public function dispatch(string $url, string $pattern)
    {
        preg_match_all('@:([\w]+)@', $pattern, $params, PREG_PATTERN_ORDER);

        $patternAsRegex = preg_replace_callback('@:([\w]+)@', [$this, 'convertPatternToRegex'], $pattern);

        if (substr($pattern, -1) === '/' ) {
            $patternAsRegex = $patternAsRegex . '?';
        }

        $patternAsRegex = '@^' . $patternAsRegex . '$@';

        // Check match request url
        if (preg_match($patternAsRegex, $url, $paramsValue)) {
            array_shift($paramsValue);

            foreach ($params[0] as $key => $value) {
                $val = substr($value, 1);

                if ($paramsValue[$val]) {
                    $this->setParams($val, urlencode($paramsValue[$val]));
                }
            }

            return true;
        }

        return false;
    }

    /**
     * Convert Pattern To Regex
     *
     * @param string $matches
     *
     * @return string
     */
    private function convertPatternToRegex($matches) {
        $key = str_replace(':', '', $matches[0]);
        return '(?P<' . $key . '>[a-zA-Z0-9_\-\.\!\~\*\\\'\(\)\:\@\&\=\$\+,%]+)';
    }

    /**
     * Set parameter
     *
     * @param string $key
     * @param string|int|bool $value
     */
    private function setParams(string $key, $value) {
        $this->params[$key] = $value;
    }
}