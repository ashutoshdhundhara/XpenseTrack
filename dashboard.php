<?php
/**
 * User's dashboard.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/dashboard.lib.php';

// Start a secure session.
XT_secureSession();
// Check if user is logged in or not.
if (! XT_checkLoginStatus()) {
    XT_redirectTo('index.php');
}

// Request for export.
if (isset($_REQUEST['export_expenses'])) {
    XT_exportExpenses($_SESSION['login_id']);
    exit;
}

$msg = '';

// Request for addition.
if (isset($_REQUEST['add_expense'])) {

    $msg = 'Successfully added expense.';
}

// Request for deletion.
if (isset($_REQUEST['delete_expense'])) {

}

$response = XT_Response::getInstance();
$header = $response->getHeader();
$header->setTitle('Dashboard');
$html_output = '';

$html_output = '<div class="message_box">'
    . XT_getHtmlMessageBox($msg)
    . '</div>'
    . XT_getHtmlDashboardContent();

$response->addHTML($html_output);
$response->response();
?>