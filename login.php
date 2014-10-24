<?php
/**
 * Login process script.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

// Start a secure session.
XT_secureSession();

// Check if all request parameters set.
if (
    isset($_POST['XT_username'])
    && isset($_POST['XT_password'])
) {
    $username = $_POST['XT_username'];
    $password = $_POST['XT_password'];
    // Validate credentials.
    if (XT_secureLogin($username, $password)) {
        XT_redirectTo('dashboard.php');
    } else {
        XT_redirectTo('index.php?login_error=true');
    }
} else {
    XT_redirectTo('index.php');
}
?>