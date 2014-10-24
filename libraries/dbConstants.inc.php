<?php
/**
 * Contains constants required for DB interactions.
 */

/**
 * Define global constants for database connection.
 */
// Define DB server.
define('dbHost', 'localhost');
// Define DB Username.
define('dbUser', 'root');
// Define DB Password.
define('dbPass', 'logMein');
// Define DB Name.
define('dbName', 'XpenseTrack');

/**
 * Define constants for databse tables.
 */
define('tblUser', 'user_details');
define('tblUserExpenses', 'user_expenses');
define('tblExpenses', 'expense_details');
define('tblCategory', 'category_details');
?>