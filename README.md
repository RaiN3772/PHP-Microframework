# microframework
 fast, secure, and efficient PHP framework. Flexible yet pragmatic.

## Description
PHP micro framework a lightweight and efficient tool for building web applications. It focuses on providing essential features and functionality without the added complexity and overhead of larger frameworks. It follows the Model-View-Controller (MVC) pattern, allowing for a clear separation of concerns and easy maintenance. developers can quickly develop and deploy web applications, without sacrificing performance or scalability.

## File Structure
* index.php: the main entry point of the application
* inc/routes.php: a routing file to creare routes and urls
* inc/functions.php: user defined functions file that are initiated with every route you create
* inc/core.php: the core file of the application
* inc/config.php: a configuration file for the entire application
* inc/views: the templates for the application
* inc/translations: the messages that should be displayed to the client
* inc/init: a folder to store the files for each route
* inc/classes: a folder to store all your classes

## Routing
the routing class allows you to create new pages/urls as you define it;

`
$route->get($uri, $callback)
`
This method registers a route for GET requests. When a GET request is made to the specified URI, the callback function is executed. The $uri parameter should be a string representing the URI of the route. The $callback parameter should be a function that is executed when the route is accessed. The example below demonstrates how to register a route for the home page:
```
$route->get("/", function () {
    $page_title = $language['home_page'];
    require_once ('inc/init/index.php');
});
```
`$route->post($uri, $callback)`
This method registers a route for POST requests. When a POST request is made to the specified URI, the callback function is executed. The $uri parameter should be a string representing the URI of the route. The `$callback` parameter should be a function that is executed when the route is accessed. The example below demonstrates how to register a route for the authentication page:
```
$route->post("/auth", function () {
    require_once('core.php');
    $username = $_POST['username'];
});
```
`$route->any($uri, $callback)`
This method registers a route for any HTTP request method (GET, POST, PUT, DELETE, etc.). When a request is made to the specified URI, the callback function is executed. The $uri parameter should be a string representing the URI of the route. The $callback parameter should be a function that is executed when the route is accessed. The example below demonstrates how to register a route for an API endpoint:
```
$route->any("/api/{api_key}", function ($api_key) {
    echo 'My API Key: ' . $api_key;
});
```
