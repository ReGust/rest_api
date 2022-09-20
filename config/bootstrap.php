<?php

define("PROJECT_ROOT_PATH", __DIR__ . "/../");

// include main configuration file
require_once PROJECT_ROOT_PATH . "/config/config.php";

// include the base controller file
require_once PROJECT_ROOT_PATH . "/controller/BaseController.php";

// include the use Service file
require_once PROJECT_ROOT_PATH . "libs/rest/Service.php";

// include the use Database file
require_once PROJECT_ROOT_PATH . "model/Database.php";

// include the use model file
require_once PROJECT_ROOT_PATH . "/model/Entity.php";

// include the use model file
require_once PROJECT_ROOT_PATH . "/model/Property.php";


