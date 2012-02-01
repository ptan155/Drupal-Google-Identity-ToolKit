<?php
/**
 * @file
 * Wrapper for the account status checking responses.
 * It builds the JSON response which is sent
 * back to the identity toolkit widget.
 */

class GitAccountStatusResponse extends gitAbstractResponse {

  private $registered;
  private $legacy;
  private $displayName;
  private $photoUrl;

  /**
   * set display name
   */
  public function setDisplayName($display_name) {
    $this->displayName = $display_name;
  }

  /**
   * set photo url
   */
  public function setPhotoUrl($display_name) {
    $this->photoUrl = $display_name;
  }

  /**
   * set legacy
   */
  public function setLegacy($legacy) {
    $this->legacy = $legacy;
  }

  /**
   * set registered
   */
  public function setRegistered($registered) {
    $this->registered = $registered;
  }

  /**
   * set to json
   */
  public function toJson() {
    $json = array();
    if (!empty($this->displayName)) {
      $json['displayName'] = $this->displayName;
    }
    if (!empty($this->photoUrl)) {
      $json['photoUrl'] = $this->photoUrl;
    }
    $json['registered'] = $this->registered;
    $json['legacy'] = $this->legacy;
    return json_encode($json);
  }
}
