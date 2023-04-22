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
define("db_name", "portal");
define("db_username", "root");
define("db_password", "");

define("db_engine", "mysql");

/**
 * Configuration for: Cookies
 *
 * COOKIE_RUNTIME: How long should a cookie be valid ? 1209600 seconds = 2 weeks
 * COOKIE_SECRET_KEY: Put a random value here to make your app more secure. When changed, all cookies are reset.
 **/


define("cookie_runtime", 1209600);
define("cookie_secret_key", "c6QOZ##H9y@SZJo$9");


/**
 * The friendly version number we're running.
 */

define('version', `2.0.5`);

define ('superadmin', [1]);

