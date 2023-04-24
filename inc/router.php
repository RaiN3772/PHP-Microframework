<?php
class Router
{
    const DEFAULT_REGEX = "@((?<!/)/[^/?#]+)|/@";
    private $_vars = array();
    private $path = false;

    // Method to parse a given route into an array of route data
    public function parse($route) {
         // If $path is set, remove it from the start of $route
        if ($this->path) {
            $pos = strpos($route, $this->path);
            if ($pos === 0) {
                $route = str_replace($this->path, "", $route);
            }
        }
        
        // Use regex to match route segments and create routeData array
        if (!preg_match_all(self::DEFAULT_REGEX, $route, $matches)) {
            return $route;
        }

        $routeData = array();
        foreach ($matches[0] as $match) {
            $routeData[] = array(
                "type"  => ($this->isVariable($match) ? "var" : "cons"),
                "value" => $match
            );
        }

        return $routeData;
    }
    // Method to set the path
    function setPath($path) {
        $this->path = $path;
    }
    // Method to check if a route segment is a variable
    function isVariable($match) {
        return preg_match('|^/{.*}|', $match);
    }
    // Method to handle GET requests
    function get($pattern, $function) {
        return $this->resolve($pattern, $function, "get");
    }
    // Method to handle POST requests
    function post($pattern, $function) {
        return $this->resolve($pattern, $function, "post");
    }
    // Method to handle PUT requests
    function put($pattern, $function) {
        return $this->resolve($pattern, $function, "put");
    }
    // Method to handle DELETE requests
    function delete($pattern, $function) {
        return $this->resolve($pattern, $function, "delete");
    }
    // Method to handle any type of request
    function any($pattern, $function) {
        return $this->resolve($pattern, $function, "any");
    }
    // Method to resolve a request to a given pattern and function
    function resolve($pattern, $function, $method) {
        // Check if the request method is valid
        if (!$this->isMethod($method))
            return false;
        // Parse the pattern into an array of route data
        $parsed_route = $this->parse($pattern);
        // Get the request URI
        $URI          = $_SERVER['REQUEST_URI'];
        // Check if the parsed route matches the URI and call the function with any variables passed as arguments
        if ($this->checkRoute($parsed_route)) {
            return call_user_func_array($function, array_merge($this->_vars));
        }

    }
    // Method to check if a parsed route matches the request URI
    function checkRoute($routeData) {
        $URI       = $_SERVER['REQUEST_URI'];
        $URIParsed = $this->parse($URI);
        // If the count of segments in the URI and the parsed route don't match, the route is not valid
        if (count($URIParsed) != count($routeData))
            return false;
        $vars = array();
        // Check each segment of the parsed route
        for ($i = 0; $i < count($URIParsed); $i++) {
            if ($routeData[$i]["type"] == "cons" && $routeData[$i]["value"] != $URIParsed[$i]["value"])
                return false;
            if ($routeData[$i]["type"] == "var") {
                $vars[] = substr($URIParsed[$i]["value"], 1);
            }
        }
        $this->_vars = $vars;
        return true;
    }

    function isMethod($method) {
        if ($method == "any") {
            return true;
        }
        else {
            return ((strtoupper($_SERVER["REQUEST_METHOD"]) == strtoupper($method)) || (strtoupper($_SERVER["REQUEST_METHOD"]) == "POST" && array_key_exists("_method", $_POST) && strtoupper($_POST["_method"]) == strtoupper($method)));
        }
    }

}
$route = new Router();
require 'routes.php';
