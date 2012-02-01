<?php
/**
 * @file
 * Configuration class. It reads the key/value pair
 * from the config/config.php file.
 */

class GitConfig {
  private $config;

  /**
   * load config file
   */
  protected function loadConfigFile() {
    global $_google_identity_toolkit_config;
    require_once dirname(__FILE__) . '/../config/config.php';
    foreach ($_google_identity_toolkit_config as $key => $value) {
      $this->config[$key] = $value;
    }
  }
  /**
   * construct
   */
  public function __construct($load_config_file = FALSE) {
    $this->config = array();
    if ($load_config_file) {
      $this->loadConfigFile();
    }
  }

  /**
   * get
   */
  protected function get($key) {
    if (isset($this->config[$key])) {
      return $this->config[$key];
    }
    else {
      return NULL;
    }
  }

  /**
   * set
   */
  protected function set($key, $value) {
    $this->config[$key] = $value;
  }

  /**
   * set home url
   */
  public function setHomeUrl($value) {
    return $this->set('homeUrl', $value);
  }

  /**
   * get home url
   */
  public function getHomeUrl() {
    return $this->get('homeUrl');
  }
  /**
   * set signup url
   */
  public function setSignupUrl($value) {
    return $this->set('signupUrl', $value);
  }

  /**
   * get signup url
   */
  public function getSignupUrl() {
    return $this->get('signupUrl');
  }

  /**
   * set Api Key
   */
  public function setApiKey($value) {
    return $this->set('apiKey', $value);
  }

  /**
   * get api key
   */
  public function getApiKey() {
    return $this->get('apiKey');
  }

  /**
   * get extesion class paths
   */
  public function getExtensionClassPaths() {
    return $this->get('externalClassPaths');
  }

  /**
   * get account service name
   */
  public function getAccountServiceName() {
    return $this->get('accountService');
  }

  /**
   * et session manage name
   */
  public function getSessionManagerName() {
    return $this->get('sessionManager');
  }

  /**
   * get pluginName
   */
  public function getPluginName() {
    return $this->get('pluginName');
  }
}
