<?php
/**
 * @file
 * The action class to handle the get user status query.
 */

class GitAccountStatusAction {

  /**
   * set Respose
   */
  protected function setResponse($request, $response, $registered, $legacy) {
    $response->setRegistered($registered);
    $response->setLegacy($legacy);
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
   * send registerd federated
   */
  public function sendRegisteredFederated($request, $response) {
    $this->setResponse($request, $response, TRUE, FALSE);
  }

  /**
   * send unregistered federated
   */
  public function sendUnRegisteredFederated($request, $response) {
    $this->setResponse($request, $response, FALSE, FALSE);
  }

  /**
   * send reister Legacy
   */
  public function sendRegisteredLegacy($request, $response) {
    $this->setResponse($request, $response, TRUE, TRUE);
  }

  /**
   * send unregistered legycy
   */
  public function sendUnRegisteredLegacy($request, $response) {
    $this->setResponse($request, $response, FALSE, TRUE);
  }

  /**
   * send error
   */
  public function sendError($request, $response) {
    $this->setResponse($request, $response, NULL, NULL);
  }
}
