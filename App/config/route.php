<?php

class Routing
{
    public static function buildRoute()
    {
        $part = Routing::getPathParts();
        if ($part[1] != '') {
            $controllerName = ucfirst(str_replace('-', '', $part[1]) . "Controller");
        }
        require_once CONTROLLER_PATH . $controllerName . ".php";
        if (isset($part[2]) && $part[2] != '') {
            $action = $part[2] . "Action";
        }
        $controller = new $controllerName();
        $controller->$action();

    }

    public static function getPath()
    {
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return '/main/index';
        }
        return $_SERVER['REQUEST_URI'];
    }

    public static function getPathParts()
    {
        $path = Routing::getPath();
        return explode("/", $path);
    }

}
