<?php
session_start();

// Debug information
error_log("Index.php accessed - REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'Not set'));
error_log("GET parameters: " . print_r($_GET, true));

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/models/' . $class . '.php',
        __DIR__ . '/config/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Redirect to coursera index page if no controller specified
if (empty($_GET['controller'])) {
    header('Location: views/coursera/index.php');
    exit;
}

$controllerName = ucfirst($_GET['controller']) . 'Controller';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

if (!class_exists($controllerName)) {
    http_response_code(404);
    echo "Controller not found";
    exit;
}

$controller = new $controllerName();

if (!method_exists($controller, $actionName)) {
    http_response_code(404);
    echo "Action not found";
    exit;
}

$controller->{$actionName}();
