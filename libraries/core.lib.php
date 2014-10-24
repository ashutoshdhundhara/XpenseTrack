<?php
/**
 * Contains functions which are common to all php scripts.
 */

if (! defined('XpenseTrack')) {
    exit;
}
/**
 * Adds error message to $GLOBALS['error'].
 *
 * @param string $message Error message
 *
 * @return void
 */
function XT_gotError($message)
{
    array_push($GLOBALS['error'],
        $message
    );
}

/**
 * Create error message to be sent via Ajax.
 *
 * @param array Array containing error messages.
 *
 * @return string $retval String with formatted error messages.
 */
function XT_generateErrorMessage($messages)
{
    $retval = '<div class="error">';
    $retval .= '<h1>ERROR</h1>';
    $retval .= '<strong>Following error(s) occurred : </strong>';
    $retval .= '<ul>';
    foreach ($messages as $message) {
        $retval .= '<li>' . $message . '</li>';
    }
    $retval .= '</ul></div>';

    return $retval;
}
/**
 * Redirects to a page.
 *
 * @param string $location Location
 */
function XT_redirectTo($location)
{
    // List of valid pages.
    $page_whitelist = array(
        'dashboard.php'
        , 'index.php'
    );
    // Get page name.
    $page = explode('?', $location);
    if (is_array($page)) {
        $page = $page[0];
    }
    // If page is valid.
    if (in_array($page, $page_whitelist)) {
        // Redirect to page.
        header('Location: ' . $location);
        exit;
    }
}

function XT_getExpenses($username, $year, $month, $type)
{
    $sql_query = 'SELECT `expense_id`, `expense_amount`, `expense_type`, `expense_date` FROM ' . tblUserExpenses .' ';
    $where_clause = '';

    $params[':username'] = $username;

    if ($year != '---') {
        $where_clause .= 'AND EXTRACT(YEAR FROM `expense_date`) = :year ';
        $params[':year'] = $year;
    }
    if ($month != '---') {
        $where_clause .= 'AND EXTRACT(MONTH FROM `expense_date`) = :month ';
        $params[':month'] = $month;
    }
    if ($type != '---') {
        $where_clause .= 'AND `expense_type` = :type';
        $params[':type'] = $type;
    }

    if (empty($where_clause)) {
        $where_clause = 'WHERE `username` = :username ';
    } else {
        $where_clause = ' WHERE `username` = :username ' . $where_clause;
    }
    $sql_query .= $where_clause;

    $result = $GLOBALS['dbi']->executeQuery($sql_query, $params);

    return $result;
}

function XT_getCurrentBalance($username)
{
    $sql_query = 'SELECT `total_balance` FROM ' . tblUser . ' '
        . 'WHERE `username` = :username';
    $result = $GLOBALS['dbi']->executeQuery($sql_query, array(':username' => $username));

    if ($result->rowCount() == 0) {
        return 0;
    } else {
        $row = $result->fetch();
        return $row['total_balance'];
    }
}

function XT_exportExpenses($username)
{
    $expenses = XT_getExpenses($username, '---', '---', '---');
    $filename = $_SESSION['login_id'] . '.csv';
    header('Content-Type: application/csv; charset=UTF-8');
    header('Content-Disposition: attachement; filename="' . $filename . '";');

    // open the "output" stream
    $fp = fopen('php://output', 'w');
    fputcsv($fp, array('Expense ID', 'Amount', 'Expense Type', 'Expense Date'), ';');
    while ($row = $expenses->fetch(PDO::FETCH_NUM)) {
        fputcsv($fp, $row, ';');
    }
}

?>