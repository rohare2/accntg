<?php
// db_functions.php

// Database connection settings
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'rich');
define('DB_PASSWORD', 'Wc6rcyecJwRMKy');
define('DB_NAME', 'accntg');

// Function to establish a database connection
function db_connect() {
    // Try to connect using mysqli
    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check if connection was successful
    if ($connection->connect_error) {
        die("Database connection failed: " . $connection->connect_error);
    }

    return $connection;
}

// Function to close the database connection
function db_close($connection) {
    if (isset($connection)) {
        $connection->close();
    }
}
?>

