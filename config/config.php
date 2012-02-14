<?php
/**
 * @file
 * config google identity toolkit config
 */
$_google_identity_toolkit_config = array(
  'apiKey' => variable_get('google_identity_toolkit_apikey', ''),
  'homeUrl' => '',
  'signupUrl' => '',
  'externalClassPaths' => dirname(__FILE__) . '/../',
  'accountService' => 'DrupalAccountService',
  'sessionManager' => 'DrupalSessionManager',
  'customer_id' => 'customer_id',
  'idpAssertionKey' => 'idpAssertion',
  'pluginName' => 'D6',
);
