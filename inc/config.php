<?php

/**
 * Configuration for: Database Connection
 * This is the place where your database login constants are saved
 *
 *
 * db_server: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * db_name: name of the database. please note: database and database table are not the same thing
 * db_username: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 *          by the way, it's bad style to use "root", but for development it will work.
 * db_password: the password of the above user
 * db_engine: the engine of your sql server; e.g mysql for MySQL, sqlsr for MS SQL Server, sqlite for SQLite, oci for Oracle, pgsql for PostgreSQL
 * for MongoDB; you have to use this class https://www.mongodb.com/docs/drivers/php/
 */

define("db_server", "127.0.0.1");
define("db_name", "");
define("db_username", "");
define("db_password", "");

define("db_engine", "mysql");

/**
 * Configuration for: Cookies
 * Please note: The COOKIE_DOMAIN needs the domain where your app is,
 * in a format like this: .mydomain.com
 * Note the . in front of the domain. No www, no http, no slash here!
 * For local development .127.0.0.1 or .localhost is fine, but when deploying you should
 * change this to your real domain, like '.mydomain.com' ! The leading dot makes the cookie available for
 * sub-domains too.
 *
 * COOKIE_RUNTIME: How long should a cookie be valid ? 1209600 seconds = 2 weeks
 * COOKIE_DOMAIN: The domain where the cookie is valid for, like '.mydomain.com'
 * COOKIE_SECRET_KEY: Put a random value here to make your app more secure. When changed, all cookies are reset.
 **/


define("cookie_domain", ".localhost");
define("cookie_runtime", 1209600);
define("cookie_secret_key", "c6QOZ##H9y@SZJo$9");


/**
 * Configuration for: Login System
 * 600 seconds = 10 mins
 * PHP only uses seconds in time() function
 **/

define("locked_out_time", 600);

/**
 * Configuration for: Redirection System
 **/

define("base_url", (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]");

/**
 * The friendly version number we're running.
 */

define('version', 0.2);

