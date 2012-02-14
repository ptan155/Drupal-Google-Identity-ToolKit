<?php
/**
 * @file
 * drupal account service
 */
require_once dirname(__FILE__) . '/data/GitAccountService.php';
require_once dirname(__FILE__) . '/data/GitAccount.php';

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
// require_once DRUPAL_ROOT . '/includes/password.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

class DrupalAccountService implements GitAccountService {
  /**
   * get account by email
   */
  function getAccountByEmail($email) {
    $email = drupal_strtolower($email);
    $ret = NULL;

    $cache = NULL;
    $cache = db_fetch_object(db_query("SELECT * FROM {users} WHERE mail = '%s'", $email));
    if (empty($cache->mail)) {
      $cache = db_fetch_object(db_query("SELECT * FROM {users} WHERE name = '%s'", $email));
    }

    if (isset($cache->mail)) {
      if (isset($cache->type) && $cache->type == 1) {
        $ret = new GitAccount($cache->mail, GitAccount::FEDERATED);
        $ret->setLocalId($cache->uid);
        $ret->setDisplayName($cache->name);
      }
      else {
        $ret = new GitAccount($cache->mail, GitAccount::LEGACY);
        $ret->setLocalId($cache->uid);
        $ret->setDisplayName($cache->name);
      }

    }
    else {
      $ret = NULL;
    }
    return $ret;
  }

  /**
   * check password
   */
  function checkPassword($email, $password) {
    $email = drupal_strtolower($email);
    $account = db_fetch_object(db_query("SELECT * FROM {users} WHERE mail = '%s'", $email));

    if (empty($account)) {
      $account = db_fetch_object(db_query("SELECT * FROM {users} WHERE name = '%s'", $email));
      if (empty($account)) {
        return FALSE;
      }
    }

    $account = user_load(array('name' => $account->name, 'pass' => trim($password), 'status' => 1));
    if ($account && !drupal_is_denied('mail', $account->mail) && !empty($password)) {
      return TRUE;
    }
    else {
      return FALSE;
    }

  }

  /**
   * to federated
   */
  function toFederated($email) {
    $email = drupal_strtolower($email);
    db_query("UPDATE {users} SET type = 1 WHERE mail = '%s'", $email);
    return TRUE;
  }
}
