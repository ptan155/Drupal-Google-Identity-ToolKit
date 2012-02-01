<?php
/**
 * @file
 * The factory class holds the handles of the classes.
 * The relying party site needs to call the
 * setter functions here to provide the interface implementation.
 */

class GitContext {
  private static $dasherDomainChecker = FALSE;
  private static $apiClient = FALSE;
  private static $config = FALSE;
  private static $accountService = FALSE;
  private static $sessionManager = FALSE;

  /**
   * load external
   */
  protected static function loadExternal($class_name) {
    $config = self::getConfig();
    $paths = explode(',', $config->getExtensionClassPaths());
    foreach ($paths as $path) {
      if (!empty($path) && $path[strlen($path) - 1] != '/') {
        $path .= '/';
      }
      $file_name = $path . $class_name . '.php';
      if (file_exists($file_name)) {
        require_once $file_name;
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * get Account service
   */
  public static function getAccountService() {
    if (!self::$accountService) {
      $class_name = self::getConfig()->getAccountServiceName();
      if (self::loadExternal($class_name)) {
        self::$accountService = new $class_name();
      }
    }
    return self::$accountService;
  }

  /**
   * Sets the account service.
   */
  public static function setAccountService($account_service) {
    self::$accountService = $account_service;
  }

  /**
   * get session manager
   */
  public static function getSessionManager() {
    if (!self::$sessionManager) {
      $class_name = self::getConfig()->getSessionManagerName();
      if (self::loadExternal($class_name)) {
        self::$sessionManager = new $class_name();
      }
    }
    return self::$sessionManager;
  }

  /**
   * Sets the session manager instance.
   */
  public static function setSessionManager($session_manager) {
    self::$sessionManager = $session_manager;
  }

  /**
   * get dasher domain checker
   */
  public static function getDasherDomainChecker() {
    if (empty(self::$dasherDomainChecker)) {
      self::$dasherDomainChecker = new GitDasherDomainChecker();
    }
    return self::$dasherDomainChecker;
  }

  /**
   * set dasher domain checker
   */
  public static function setDasherDomainChecker($dasher_domain_checker) {
    self::$dasherDomainChecker = $dasher_domain_checker;
  }

  /**
   * set config
   */
  public static function setConfig($config) {
    self::$config = $config;
  }

  /**
   * get config
   */
  public static function getConfig() {
    if (empty(self::$config)) {
      self::$config = new GitConfig(TRUE);
    }
    return self::$config;
  }

  /**
   * get api client
   */
  public static function getApiClient() {
    if (empty(self::$apiClient)) {
      self::$apiClient = new GitApiClient(self::getConfig()->getApiKey());
    }
    return self::$apiClient;
  }
}
