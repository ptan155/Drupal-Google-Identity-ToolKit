<?php
/**
 * @file
 * The federated login callback page.
 * The IDP will redirect the user to this page after
 * authenticating the user.
 */

class GitCallbackHandler {
  private $email;
  private $purpose;
  private $url;
  private $idpResponse;

  /**
   * construct
   */
  public function __construct($email, $purpose, $url, $idp_response) {
    $this->email = $email;
    $this->purpose = $purpose;
    $this->url = $url;
    $this->idpResponse = $idp_response;
  }

  /**
   * execute
   */
  public function execute() {
    $api_client = GitContext::getApiClient();
    $assertion = $api_client->verify($this->url, $this->idpResponse);

    $request = new GitCallbackRequest($this->email, $this->purpose, $assertion);
    $response = new GitCallbackResponse();
    $action = new GitCallbackAction();
    $logic = new GitCallbackLogic($action);
    $logic->run($request, $response);
    $error = $response->getError();
    if (!empty($error)) {
      watchdog('user', $error, NULL, WATCHDOG_ERROR);
      GitUtil::sendError($error);
    }
    else {
      header(sprintf('Content-type: %s', $response->getContentType()));
      echo $response->getOutput();
    }
  }
}
