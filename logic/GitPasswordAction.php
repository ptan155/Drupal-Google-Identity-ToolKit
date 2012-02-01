<?php
/**
 * @file
 * The action class to set the legacy password JSON responses.
 * The responses will be sent back to
 * the identity toolkit widget.
 */

class GitPasswordAction {
  /**
   * set respose
   */
  protected function setResponse($request, $response, $status) {
    $response->setStatus($status);
    $account = $request->getAccount();
    if (!empty($account)) {
      $display_name = $account->getDisplayName();
      if (!empty($display_name)) {
        $response->setDisplayName($display_name);
      }
      $photo_url = $account->getPhotoUrl();
      if (!empty($photo_url)) {
        $response->setPhotoUrl($photo_url);
      }
    }
    $response->setOutput($response->toJson(), 'application/json');
  }

  /**
   * send email not exists
   */
  public function sendEmailNotExist($request, $response) {
    $this->setResponse($request, $response, GitPasswordResponse::STATUS_EMAIL_NOT_EXIST);
  }

  /**
   * send federated
   */
  public function sendFederated($request, $response) {
    $this->setResponse($request, $response, GitPasswordResponse::STATUS_FEDERATED);
  }

  /**
   * send ok
   */
  public function sendOk($request, $response) {
    $this->setResponse($request, $response, GitPasswordResponse::STATUS_OK);
  }

  /**
   * send password error
   */
  public function sendPasswordError($request, $response) {
    $this->setResponse($request, $response, GitPasswordResponse::STATUS_PASSWORD_ERROR);
  }

  /**
   * login
   */
  public function login($request, $response) {
    gitContext::getSessionManager()->setSessionAccount($request->getAccount());
  }
}
