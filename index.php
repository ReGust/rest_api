<?php
require __DIR__ . "/config/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

cors();

if ((isset($uri[2]) && !in_array($uri[2], array('index', 'api'))) ||
    (isset($uri[3]) && $uri[3] != 'property')) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

if (isset($uri[5])) {
    $propertyName = urldecode($uri[5]);
}
if (isset($uri[2]) && $uri[2] == 'index') {
    $actionName = $uri[2];
} else {
    $actionName = $uri[4] ?? 'list';
}    header("HTTP/1.1 404 Not Found");


require PROJECT_ROOT_PATH . "/controller/ApiController.php";

$objFeedController = new ApiController();
$strMethodName = $actionName . 'Action';
$objFeedController->{$strMethodName}($propertyName ?? null);

function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }
}


?>