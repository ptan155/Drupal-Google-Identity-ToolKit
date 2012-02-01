<?php

/**
 * @file
 * drupal context loader
 */

require_once dirname(__FILE__) . '/handler/GitLoginHandler.php';
require_once dirname(__FILE__) . '/util/GitConfig.php';
require_once dirname(__FILE__) . '/util/GitApiClient.php';
require_once dirname(__FILE__) . '/util/GitContext.php';
require_once dirname(__FILE__) . '/DrupalAccountService.php';
require_once dirname(__FILE__) . '/DrupalSessionManager.php';

class DrupalContextLoader {
  /**
   * load
   */
  public static function load() {
    global $base_url;
    $config = new GitConfig(TRUE);
    GitContext::setConfig($config);
    GitContext::setAccountService(new DrupalAccountService());
    GitContext::setSessionManager(new DrupalSessionManager());
  }
}
