<?php
/**
 * @file
 * The logic to handle the email and password post request..
 * It collects the input params and the
 * current account status then make decision to call the action
 * class to generate the response.
 */

class GitPasswordLogic {
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
    $password = $request->getPassword();

    if (empty($email)) {
      $this->action->sendEmailNotExist($request, $response);
    }

    $account = GitContext::getAccountService()->getAccountByEmail($email);

    if (empty($account)) {
      $this->action->sendEmailNotExist($request, $response);
    }
    else {
      $email = $account->getEmail();
      $request = new GitLoginRequest($email, $password);
      $request->setAccount($account);

      if (GitUtil::isValidEmail()) {
        if ($account->getAccountType() == GitAccount::FEDERATED) {
          $this->action->sendFederated($request, $response);
        }
        else {
          if (GitContext::getAccountService()->checkPassword($email, $password)) {
            $this->action->login($request, $response);
            $this->action->sendOk($request, $response);
          }
          else {
            $this->action->sendPasswordError($request, $response);
          }
        }
      }
      else {
        if ($account->getAccountType() == GitAccount::FEDERATED) {
          $this->action->sendPasswordError($request, $response);
        }
        else {
          if (GitContext::getAccountService()->checkPassword($email, $password)) {
            $this->action->login($request, $response);
            $this->action->sendOk($request, $response);
          }
          else {
            $this->action->sendPasswordError($request, $response);
          }
        }
      }
    }
  }

}
