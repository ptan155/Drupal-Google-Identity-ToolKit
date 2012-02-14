<?php
/**
 * @file
 * The assertion returned by the IDP.
 */

class GitAssertion {
  private $firstName;
  private $lastName;
  private $verifiedEmail;
  private $identifier;
  private $photoUrl;
  private $nickName;
  private $fullName;

  /**
   * construct
   */
  public function __construct($identifier, $verified_email) {
    $this->identifier = $identifier;
    if (!empty($verified_email)) {
      $this->verifiedEmail = drupal_strtolower($verified_email);
    }
  }

  /**
   * getIdentifier
   */
  public function getIdentifier() {
    return $this->identifier;
  }

  /**
   * getVerifiedEmail
   */
  public function getVerifiedEmail() {
    return $this->verifiedEmail;
  }

  /**
   * get first name
   */
  public function getFirstName() {
    return $this->firstName;
  }

  /**
   * set first name
   */
  public function setFirstName($first_name) {
    $this->firstName = $first_name;
  }

  /**
   * get last name
   */
  public function getLastName() {
    return $this->lastName;
  }

  /**
   * set last name
   */
  public function setLastName($last_name) {
    $this->lastName = $last_name;
  }

  /**
   * get photo url
   */
  public function getPhotoUrl() {
    return $this->photoUrl;
  }

  /**
   * set photo url
   */
  public function setPhotoUrl($photo_url) {
    $this->photoUrl = $photo_url;
  }

  /**
   * get nick name
   */
  public function getNickName() {
    return $this->nickName;
  }

  /**
   * set nick name
   */
  public function setNickName($nick_name) {
    $this->nickName = $nick_name;
  }

  /**
   * get full name
   */
  public function getFullName() {
    return $this->fullName;
  }

  /**
   * set full name
   */
  public function setFullName($full_name) {
    $this->fullName = $full_name;
  }

  /**
   * get display name
   */
  public function getDisplayName() {
    if ($this->nickName != '') {
      return $this->nickName;
    }
    elseif ($this->fullName != '') {
      return $this->fullName;
    }
    elseif ($this->firstName != '') {
      return $this->firstName;
    }
    elseif ($this->lastName != '') {
      return $this->lastName;
    }
    return '';
  }

  /**
   * to string
   */
  public function __toString() {
    $obj = array(
                 'verifiedEmail' => $this->verifiedEmail,
                 'firstName' => $this->firstName,
                 'lastName' => $this->lastName,
                 'fullName' => $this->fullName,
                 'nickName' => $this->nickName,
                 'identifier' => $this->identifier,
                 'photoUrl' => $this->photoUrl);
    return json_encode($obj);
  }

  /**
   * from string
   */
  public static function fromString($json) {
    $obj = json_decode($json);
    if (!empty($obj) && !empty($obj->identifier)) {
      $ret = new GitAssertion($obj->identifier, $obj->verifiedEmail);
      if (!empty($obj->firstName)) {
        $ret->setFirstName($obj->firstName);
      }
      if (!empty($obj->lastName)) {
        $ret->setLastName($obj->lastName);
      }
      if (!empty($obj->photoUrl)) {
        $ret->setPhotoUrl($obj->photoUrl);
      }
      if (!empty($obj->nickName)) {
        $ret->setNickName($obj->nickName);
      }
      if (!empty($obj->fullName)) {
        $ret->setFullName($obj->fullName);
      }
      return $ret;
    }
    return NULL;
  }
}
