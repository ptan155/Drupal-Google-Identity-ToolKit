<?php
/**
 * @file
 * The relying party account data model.
 */

class GitAccount {
  const FEDERATED = 'FEDERATED';
  const LEGACY = 'LEGACY';
  private $email;
  private $accountType;
  private $localId;
  private $displayName;
  private $photoUrl = '';

  /**
   * construct
   */
  public function __construct($email, $account_type) {
    $this->email = $email;
    $this->accountType = self::LEGACY;
    if ($account_type == self::FEDERATED) {
      $this->accountType = self::FEDERATED;
    }
  }

  /**
   * get email
   */
  public function getEmail() {
    return $this->email;
  }

  /**
   * set email
   */
  public function setEmail($email) {
    $this->email = $email;
  }

  /**
   * get account
   */
  public function getAccountType() {
    return $this->accountType;
  }

  /**
   * set account type
   */
  public function setAccountType($account_type) {
    if ($account_type == self::FEDERATED) {
      $this->accountType = self::FEDERATED;
    }
    elseif ($account_type == self::LEGACY) {
      $this->accountType = self::LEGACY;
    }
  }

  /**
   * get local id
   */
  public function getLocalId() {
    return $this->localId;
  }

  /**
   * set local id
   */
  public function setLocalId($value) {
    $this->localId = $value;
  }

  /**
   * get dispaly name
   */
  public function getDisplayName() {
    return $this->displayName;

  }

  /**
   * set display name
   */
  public function setDisplayName($value) {
    $this->displayName = $value;
  }

  /**
   * get phto url
   */
  public function getPhotoUrl() {
    return $this->photoUrl;
  }

  /**
   * set photo url
   */
  public function setPhotoUrl($value) {
    $this->photoUrl = $value;
  }
}
