<?php
/**
 * @file
 * Wrapper for the request params.
 */

class GitCallbackRequest {
  private $assertion;
  private $purpose;
  private $inputEmail;
  private $account;

  /**
   * construct
   */
  public function __construct($input_email, $purpose, $assertion) {
    $this->assertion = $assertion;
    $this->purpose = $purpose;
    $this->inputEmail = $input_email;
  }

  /**
   * get Assertion
   */
  public function getAssertion() {
    return $this->assertion;
  }

  /**
   * get input Email
   */
  public function getInputEmail() {
    return $this->inputEmail;
  }

  /**
   * get purpose
   */
  public function getPurpose() {
    return $this->purpose;
  }

  /**
   * set Account
   */
  public function setAccount($account) {
    $this->account = $account;
  }

  /**
   * get Account
   */
  public function getAccount() {
    return $this->account;
  }
}
