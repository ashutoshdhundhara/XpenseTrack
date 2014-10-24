<?php
/**
 * Register page.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';
require_once 'libraries/dashboard.lib.php';

$html_output = '';
if (isset($_REQUEST['register'])) {
    $sql_query = 'INSERT INTO ' . tblUser . '(`username`, `password`, `full_name`, `total_balance`) VALUES ('
        . ':username,'
        . ':password,'
        . ':full_name,'
        . ':total_balance)';
    $params = array(
        ':username' => $_REQUEST['username'],
        ':password' => hash('sha512', $_REQUEST['password']),
        ':full_name' => $_REQUEST['full_name'],
        ':total_balance' => $_REQUEST['balance']
    );

    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);

    if ($result) {
        $msg = 'Registration Successful!';
    } else {
        $msg = 'Registration failed!';
    }

    $html_output .= '<div class="message_box">'
        . XT_getHtmlMessageBox($msg)
        . '</div>';
}

$response = XT_Response::getInstance();
$header = $response->getHeader();
$header->setTitle('Register');

$html_output .= '<form action="" method="POST">'
    .'<input type="hidden" name="register" value="1">'
    . '<table class="register_form">'
    . '<caption>REGISTER</caption>'
    . '<tr>'
    . '<td>'
    . 'Full Name : '
    . '</td>'
    . '<td>'
    . '<input type="text" name="full_name">'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td>'
    . 'Username : '
    . '</td>'
    . '<td>'
    . '<input type="text" name="username">'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td>'
    . 'Password : '
    . '</td>'
    . '<td>'
    . '<input type="password" name="password">'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td>'
    . 'Monthly Budget : '
    . '</td>'
    . '<td>'
    . '<input type="text" name="balance">'
    . '</td>'
    . '</tr>'
    . '<tr>'
    . '<td colspan="2" style="text-align: center;">'
    . '<button>Register</button>'
    . '</td>'
    . '</tr>'
    . '</table>'
    . '<form>';

$response->addHTML($html_output);
$response->response();

?>