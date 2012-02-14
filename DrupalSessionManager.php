<?php

/**
 * @file
 * drupal session manage
 */
define('DRUPAL_ROOT', getcwd());
require_once dirname(__FILE__) . '/session/GitSessionManager.php';
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
// require_once DRUPAL_ROOT . '/includes/password.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

/**
 * A simple implementation for the SessionManager.
 */
class DrupalSessionManager implements GitSessionManager {
  /**
   * get session account
   */
  function getSessionAccount() {
    $account = db_fetch_object(db_query("SELECT * FROM {users} WHERE uid = %d", $_SESSION['customer_id']));

    if (isset($account->type) && $account->type == 1) {
      $ret = new GitAccount($account->mail, $account->type);
      $ret->setLocalId($account->uid);
      return $ret;
    }

    return NULL;
  }

  /**
   * set session account
   */
  function setSessionAccount($account) {
    if (empty($account)) {
      unset($_SESSION['customer_id']);
    }
    else {
      $_SESSION['customer_id'] = $account->getLocalId();
    }
  }

  /**
   * get Assertion
   */
  function getAssertion() {
    if (isset($_SESSION['idpAssertion'])) {
      return GitAssertion::fromString($_SESSION['idpAssertion']);
    }
    return NULL;
  }

  /**
   * set assertion
   */
  function setAssertion($assertion) {
    $_SESSION['idpAssertion'] = (string) $assertion;
  }
}
