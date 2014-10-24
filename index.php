<?php
/**
 * Default script.
 */

/**
 * Get all required libraries.
 */
require_once 'libraries/common.inc.php';

$response = XT_Response::getInstance();
$header = $response->getHeader();
$header->setTitle('Home');
$html_output = '';

$response->addHTML($html_output);
$response->response();
?>