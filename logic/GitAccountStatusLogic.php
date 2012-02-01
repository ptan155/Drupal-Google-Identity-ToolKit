<?php
/**
 * @file
 * The logic to handle the account status checking request.
 * It collects the input params and the
 * current account status then make decision to call the
 * action class to generate the response.
 */

class GitAccountStatusLogic {
  private $action;
  /**
   * construct
   */
  public function __construct($action) {
    $this->action = $action;
  }

  /**
   * run
   */
  public function run($request, $response) {
    $email = $request->getEmail();
    if (empty($email)) {
      $this->action->sendError($request, $response);
    }
    $account = GitContext::getAccountService()->getAccountByEmail($email);

    if (empty($account)) {
      $can_federate = GitUtil::isFederatedDomain(GitUtil::getEmailDomain($email));
      if ($can_federate) {
        $this->action->sendUnRegisteredFederated($request, $response);
      }
      else {
        $this->action->sendUnRegisteredLegacy($request, $response);
      }
    }
    else {
      $email = $account->getEmail();
      $request = new GitLoginRequest($email, NULL);
      $request->setAccount($account);
      $can_federate = GitUtil::isFederatedDomain(GitUtil::getEmailDomain($email));
      if ($account->getAccountType() == GitAccount::FEDERATED || $can_federate) {
        $this->action->sendRegisteredFederated($request, $response);
      }
      else {
        $this->action->sendRegisteredLegacy($request, $response);
      }
    }
  }
}
