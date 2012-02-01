<?php

/**
 * @file
 * callback
 */

require_once 'handler/gitCallbackHandler.php';

$input_email = isset($_GET['rp_input_email']) ? $_GET['rp_input_email'] : '';
$purpose = isset($_GET['rp_purpose']) ? $_GET['rp_purpose'] : '';
$url = GitUtil::getCurrentUrl();
$idp_response = @file_get_contents('php://input');

$handler = new GitCallbackHandler($input_email, $purpose, $url, $idp_response);
$handler->execute();
