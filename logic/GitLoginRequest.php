<?php
/**
 * @file
 * Wrapper for the request params.
 */

class GitLoginRequest {
  private $email;
  private $password;
  private $domainFederated;
  private $account;

  /**
   * construct
   */
  public function __construct($email, $password) {
    $this->email = $email;
    $this->password = $password;
  }

  /**
   * get email
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * get password
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * set account
   */
  public function setAccount($account) {
    $this->account = $account;
  }

  /**
   * get account
   */
  public function getAccount() {
    return $this->account;
  }

  /**
   * set Domain federated
   */
  public function setDomainFederated($email_federated) {
    $this->domainFederated = $email_federated;
  }

  /**
   * get domain federated
   */
  public function getDomainFederated() {
    return $this->domainFederated;
  }

  /**
   * get account type
   */
  public function getAccountType() {
    if (!empty($this->account)) {
      return $this->getAccount()->getAccountType();
    }
    else {
      return $this->domainFederated ? GitAccount::FEDERATED : GitAccount::LEGACY;
    }
  }
}
