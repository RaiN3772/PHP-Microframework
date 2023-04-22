# microframework
 fast, secure, and efficient PHP framework. Flexible yet pragmatic.
 
 ![Microframework](https://i.imgur.com/pLpdKCS.png)

## Description
PHP micro framework a lightweight and efficient tool for building web applications. It focuses on providing essential features and functionality without the added complexity and overhead of larger frameworks. It follows the Model-View-Controller (MVC) pattern, allowing for a clear separation of concerns and easy maintenance. developers can quickly develop and deploy web applications, without sacrificing performance or scalability.

## File Structure
* index.php: the main entry point of the application
* inc/routes.php: a routing file to create routes and urls
* inc/functions.php: user defined functions file that are initiated with every route you create
* inc/core.php: the core file of the application
* inc/config.php: a configuration file for the entire application
* inc/bootstrap.php: the bootstraper file, you can customize things suchs as links and menues
* inc/views: the templates for the application
* inc/init: a folder to store the files for each route
* inc/classes: a folder to store all your classes

## Routing
the routing class allows you to create new pages/urls as you define it;

`
$route->get($uri, $callback)
`
This method registers a route for GET requests. When a GET request is made to the specified URI, the callback function is executed. The $uri parameter should be a string representing the URI of the route. The $callback parameter should be a function that is executed when the route is accessed. The example below demonstrates how to register a route for the home page:
```
$route->get("/new_page", function () {
    $page['title'] = 'My New Page';
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

## Classes
The framework comes with an autoloading feature that automatically loads classes as they are used, without the need for explicit include or require statements. To create a new class, all you have to do is create a new file in the `inc/classes/` folder with the same name as the class, and define the class within that file. The autoloading feature will then automatically load the file and make the class available for use.

For example, suppose you want to create a class called MyClass. You would create a file called MyClass.php in the `inc/classes/` folder and define the class within that file. You can then create an instance of the class using the standard syntax:
```
$MyObject = new MyClass();
```


## Database
Dealing with database was never an easy job, so i created a php class for interacting with databases using the PDO (PHP Data Objects) library. This class allows you to easily connect to a database, execute SQL queries, and perform common database operations like SELECT, INSERT, UPDATE, and DELETE.

### Select Statement
```
$result = $database->select('my_table', '*', 'id = :id', ['id' => 1]);
$rows = $result->fetchAll();
```
### Insert Statement
```
$data = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'phone' => '555-1234'
];
$result = $database->insert('my_table', $data);
$id = $database->lastInsertId();

```
### Update Statement
```
$data = [
    'name' => 'Jane Doe',
    'email' => 'jane@example.com',
    'phone' => '555-4321'
];
$where = ['id' => 1];
$result = $database->update('my_table', $data, $where);
```
### Delete Statement
```
$where = 'id = :id';
$bind = ['id' => 1];
$result = $database->delete('my_table', $where, $bind);
```
### Query
if you have a complex query that you want to perform you can use the `query` method instead of the mentioned ones
```
// Define the SQL query
$sql = "SELECT * FROM `users` LEFT JOIN `posts` ON posts.user_id = users.user_id WHERE id = :id ";

// Define the parameter values
$parameters = [':id' => 123];

// Execute the query and fetch the results
$result = $database->query($sql, $parameters)->fetch();
```

## User Defined Functions
### Security
the framwork comes with security features that enables you to secure your application for both front-end and back-end.
* to prevent SQL Injection, you must always use the database class that provided in the previous example
* to prevent Cross-Site Scripting (XSS) when always use the `user defined function` that provided
```
$secure($username);
OR
$secure_output($username);
```
### Formating
Formatting refers to the process of converting data from one form to another, often to make it more easily readable or understandable by humans. In programming, formatting functions are often used to convert raw data into a more user-friendly format.

we have two formatting functions: `format_date` and `format_size`. format_date accepts a datetime value and returns it in a specified format, while format_size accepts a size value (such as a file size) and converts it to a human-readable format (such as "1.5 MB").

### Others
* The `redirect()` function is used to redirect the user to a different URL. It sends an HTTP header to the client to instruct the browser to request the specified URL.
* `get_ip()` function retrieves the client's IP address, even if they are behind a proxy.
* `generate_random_string() a function that generate random letters and numbers, it takes one parameter which is the lenght of the generated string; default 16
* toastr() function is a front-end redirection with a message, its a jQuery library for non-blocking notification, it takes 2 required parameters and 1 optional, first parameter is the type of the notification you would like to send, for example 'info`, `success`, `error`, and `warning`, the second paramter is the message you want to display, the third paramter is optional, the default value is the last page that the user visited, you can write the targeted url you want the user to be redirected to. example: `toastr('success', 'You have succesfully created a new user');`

## Boostrapper
in the bootstrapper file you can create menus as manage them as arrays, for exampel if you would like to create footer links you can use.

### Footer Links

```
$FooterItems = [
    // Item Name    => Link
    'Link #1' => 'https://example.com',
];
```

### Aside Menu
In aside menu you can create menu items, it supports font awesome icon library, with linking, and permission system
for example; a simple menu item
```
$MenuItems = [
    'About' => [
        'icon'       => 'fa-solid fa-info',
        'link'      => '/about',
    ],
];
```
for a more complex menu with sub items
```
$MenuItems = [
    'Admin Panel' => [
        'icon'       => 'fa-solid fa-lock',
        'permission' => 'admin_panel',
        'route'      => '/admin/',
        'sub'        => [
            'Home'        => [
                'link' => '/admin',
                'icon' => 'fa-solid fa-unlock-keyhole',
            ],
            'Settings'    => [
                'link'       => '/admin/settings',
                'icon'       => 'fa-solid fa-cog',
                'permission' => 'manage_settings',
            ],
            'Roles'       => [
                'link'       => '/admin/roles',
                'icon'       => 'fa-solid fa-user-tag',
                'permission' => 'manage_roles',
            ],
            'Permissions' => [
                'link'       => '/admin/permissions',
                'icon'       => 'fa-solid fa-user-lock',
                'permission' => 'manage_permissions',
            ],
            'Users'       => [
                'link'       => '/admin/users',
                'icon'       => 'fa-solid fa-users',
                'permission' => 'manage_users',
            ],
            'Logs'        => [
                'link'       => '/admin/logs',
                'icon'       => 'fa-solid fa-clipboard-list',
                'permission' => 'manage_logs',
            ],
        ],
    ],
];
```

## Permissions & Roles
this framework supports permissions system and roles; follows RBAC (Role-based access control) methodology
you can create permission variables via the front-end admin routes and use them directly into the application code

to check if user has a permission you can use this method
```
$user->hasPermission('permission_name')
$user->hasPermission('manage_users')
$database->hasPermission('manage_roles')
if (!$user->hasPermission('manage_roles')) redirect('/');
if ($user->hasPermission('manage_roles')) echo 'User has permission';
```

- Permissions are assigned to roles
- Roles are assigned to users
- Roles are created via the front-end and can be assigned to users

