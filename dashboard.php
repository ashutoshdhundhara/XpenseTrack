<?php
/**
 * User's dashboard.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

// Start a secure session.
XT_secureSession();
// Check if user is logged in or not.
if (! XT_checkLoginStatus()) {
    XT_redirectTo('index.php');
}

$response = XT_Response::getInstance();
$header = $response->getHeader();
$header->setTitle('Dashboard');
$html_output = '';

$response->addHTML($html_output);
$response->response();
?>