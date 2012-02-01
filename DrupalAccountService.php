<?php
/**
 * @file
 * drupal account service
 */

require_once dirname(__FILE__) . '/data/GitAccountService.php';
require_once dirname(__FILE__) . '/data/GitAccount.php';

require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
require_once DRUPAL_ROOT . '/includes/password.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

class DrupalAccountService implements GitAccountService {
  /**
   * get account by email
   */
  function getAccountByEmail($email) {
    $email = drupal_strtolower($email);
    $ret = NULL;

    $cache = NULL;
    $cache = db_query("SELECT * FROM {users} WHERE mail = :mail", array(':mail' => $email))->fetchObject();
    if (empty($cache->mail)) {
      $cache = db_query("SELECT * FROM {users} WHERE name = :name", array(':name' => $email))->fetchObject();
    }

    if (isset($cache->mail)) {
      if (!GitUtil::isValidEmail($email)){
        $cache->type = 0;
      }
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
    $account = db_query("SELECT * FROM {users} WHERE mail = :mail", array(':mail' => $email))->fetchObject();

    if (empty($account)) {
      $account = db_query("SELECT * FROM {users} WHERE name = :name", array(':name' => $email))->fetchObject();
      if (empty($account)) {
        return FALSE;
      }
    }
    return user_check_password($password, $account);
  }

  /**
   * to federated
   */
  function toFederated($email) {
    $email = drupal_strtolower($email);
    db_query("UPDATE {users} SET type = 1 WHERE mail = :mail", array(":mail" => $email));
    return TRUE;
  }
}
