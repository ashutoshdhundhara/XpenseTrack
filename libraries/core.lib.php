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
?>