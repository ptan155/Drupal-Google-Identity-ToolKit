<?php
/**
 * @file
 * Wrapper for the legacy password checking responses.
 * It builds the JSON response which is sent
 * back to the identity toolkit widget.
 */

class GitPasswordResponse extends GitAbstractResponse {
  const STATUS_OK = 'ok';
  const STATUS_PASSWORD_ERROR = 'passwordError';
  const STATUS_FEDERATED = 'federated';
  const STATUS_EMAIL_NOT_EXIST = 'emailNotExist';

  private $status;
  private $displayName;
  private $photoUrl;

  /**
   * set status
   */
  public function setStatus($status) {
    if (in_array($status, array(GitPasswordResponse::STATUS_OK,
      GitPasswordResponse::STATUS_PASSWORD_ERROR, GitPasswordResponse::STATUS_FEDERATED,
      GitPasswordResponse::STATUS_EMAIL_NOT_EXIST,))) {
      $this->status = $status;
    }
  }

  /**
   * set display name
   */
  public function setDisplayName($display_name) {
    $this->displayName = $display_name;
  }

  /**
   * set photo url
   */
  public function setPhotoUrl($photo_url) {
    $this->photoUrl = $photo_url;
  }

  /**
   * to json
   */
  public function toJson() {
    $json = array();
    $json['status'] = $this->status;
    if (!empty($this->displayName)) {
      $json['displayName'] = $this->displayName;
    }
    if (!empty($this->photoUrl)) {
      $json['photoUrl'] = $this->photoUrl;
    }
    return json_encode($json);
  }
}
