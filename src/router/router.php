<?php

use agregalel\router_php\Route;

// define("__DIR_PATH__", dirname(__DIR__, 2));
define("__DIR_PATH__", $_SERVER["DOCUMENT_ROOT"]);

chdir(__DIR_PATH__);

$filePath = realpath(ltrim($_SERVER["REQUEST_URI"], '/'));
if ($filePath && is_dir($filePath)){
    // attempt to find an index file
    foreach (['index.php', 'index.html'] as $indexFile){
        if ($filePath = realpath($filePath . DIRECTORY_SEPARATOR . $indexFile)){
            break;
        }
    }
}
if ($filePath && is_file($filePath)) {
    if (strpos($filePath, __DIR_PATH__ . DIRECTORY_SEPARATOR) === 0 &&
        $filePath != __DIR_PATH__ . DIRECTORY_SEPARATOR . 'router.php' &&
        substr(basename($filePath), 0, 1) != '.'
    ) {
        if (strtolower(substr($filePath, -4)) == '.php') {
            // index
            $routes = new Route();
            $routes->proccessRequest(substr($_SERVER["REQUEST_URI"], 1, strlen($_SERVER["REQUEST_URI"])), $routes->getRoutes());
        } else {
            return false;
        }
    } else {
        // disallowed file
        header("HTTP/1.1 404 Not Found");
        echo "404 Not Found";
    }
} else {
    // redirect to page
    $routes = new Route();
    $routes->proccessRequest(substr($_SERVER["REQUEST_URI"], 1, strlen($_SERVER["REQUEST_URI"])), $routes->getRoutes());
}