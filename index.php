<?php
/**
 * Default script.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

// Start a secure session.
XT_secureSession();
// Redirect user to his/her dashboard if he/she is logged in.
if (XT_checkLoginStatus()) {
    XT_redirectTo('dashboard.php');
}

$response = XT_Response::getInstance();
$header = $response->getHeader();
$header->setTitle('Login');
$login_error = '';
$html_output = '';

// If to show login error message.
if (isset($_GET['login_error']) && $_GET['login_error'] == true) {
    $login_error = '<tr>'
        . '<td colspan="2" class="red">'
        . 'Invalid Username or Password.'
        . '</td>'
        . '</tr>';
}

// Create Login form.
$html_output .= '<form id="login_form" class="login_form"'
    . ' action="login.php" method="POST">'
    . '<table>'
    . '<caption>LOGIN</caption>'
    . '<tbody>'
    . $login_error
    . '<tr><td><label for="input_username">Username:</label></td>'
    . '<td>'
    . '<input type="text" name="XT_username" id="input_username"'
    . ' title="Please provide your Username.">'
    . '</td></tr>'
    . '<tr><td><label for="input_password">Password:</label></td>'
    . '<td>'
    . '<input type="password" name="XT_password" id="input_password"'
    . ' title="Please provide your password.">'
    . '</td></tr>'
    . '<tr><td colspan="2">'
    . '<button>LOGIN</button>'
    . '</td></tr>'
    . '<tr><td colspan="2"><a href="register.php">Register</a></td></tr>'
    . '</tbody>'
    . '</table>'
    . '</form>';

$response->addHTML($html_output);
$response->response();
?>