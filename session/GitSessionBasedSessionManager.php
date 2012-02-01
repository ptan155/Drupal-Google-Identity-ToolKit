<?php
/**
 * @file
 * A simple implementation for the SessionManager.
 */

class GitSessionBasedSessionManager implements GitSessionManager {
  private $config;
  private $accountService;

  /**
   * construct
   */
  public function __construct(GitConfig $config, GitAccountService $account_service) {
    $this->config = $config;
    $this->accountService = $account_service;
  }

  /**
   * get session account
   */
  public function getSessionAccount() {
    if (isset($this->config->sessionUserKey) && isset($_SESSION[$this->config->sessionUserKey])) {
      return $this->accountService->getAccountByEmail($_SESSION[$this->config->sessionUserKey]);
    }
    return NULL;
  }

  /**
   * set session account
   */
  public function setSessionAccount($account) {
    $_SESSION[$this->config->sessionUserKey] = $account->getEmail();
  }

  /**
   * get assertion
   */
  public function getAssertion() {
    if (isset($this->config->idpAssertionKey) && isset($_SESSION[$this->config->idpAssertionKey])) {
      return GitAssertion::fromString($_SESSION[$this->config->idpAssertionKey]);
    }
    return NULL;
  }

  /**
   * set assertion
   */
  public function setAssertion($assertion) {
    $_SESSION[$this->config->idpAssertionKey] = (string) $assertion;
  }
}
