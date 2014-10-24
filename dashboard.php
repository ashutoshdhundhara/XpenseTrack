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
    $sql_query = 'INSERT INTO `' . dbName . '`.`' . tblUserExpenses . '`'
        . ' (`username`, `expense_type`, `expense_amount` ,`expense_date`) '
        . 'VALUES (:login_id'
        . ', :expense_type'
        . ', :expense_amount'
        . ', :expense_date'
        .')';
    
    $params[':login_id'] = $_SESSION['login_id'];
    $params[':expense_type'] = $_REQUEST['expense_type'];
    $params[':expense_amount'] = $_REQUEST['expense_amount'];
    $params[':expense_date'] = $_REQUEST['expense_date'];
    
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);
    
    $sql_query = 'UPDATE `' . dbName . '`.`' . tblUser . '`'
        . ' SET total_expenses = total_expenses + ' . $_REQUEST['expense_amount'] .
        ' , total_balance = total_balance - ' . $_REQUEST['expense_amount'] 
        . ' WHERE username = \'' . $_SESSION['login_id']
        . '\'';
    
    $params = array();
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);

    $msg = 'Successfully added expense.';
}

// Request for deletion.
if (isset($_REQUEST['delete_expense'])) {
    $sql_query = 'UPDATE `' . dbName . '`.`' . tblUser . '`'
        . ' SET total_expenses = total_expenses - ' . $_REQUEST['expense_amount'] .
        ' , total_balance = total_balance + ' . $_REQUEST['expense_amount'] 
        . ' WHERE username = \'' . $_SESSION['login_id']
        . '\'';
    
    $params = array();
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);
    
    $sql_query = 'DELETE FROM `' . dbName . '`.`' . tblUserExpenses . '`'
        . ' WHERE expense_id = :expense_id';
    
    $params[':expense_id']=$_REQUEST['expense_id'];
    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);
    $msg = 'Successfully deleted the expense.';
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