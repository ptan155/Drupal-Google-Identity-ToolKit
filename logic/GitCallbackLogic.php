<?php
/**
 * @file
 * The callback logic to handle the various cases.
 */

class GitCallbackLogic {
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
    $assertion = $request->getAssertion();
    if (empty($assertion)) {
      $this->action->sendErrorServer($request, $response);
      return;
    }
    elseif ($assertion->getIdentifier() == '') {
      $this->action->sendErrorUserCancel($request, $response);
      return;
    }
    elseif ($assertion->getVerifiedEmail() == '') {
      $this->action->sendErrorNoVerifiedEmail($request, $response);
      return;
    }

    $purpose = $request->getPurpose();
    if (!empty($purpose) && $purpose != 'signin' && $purpose != 'upgrade') {
      $response->setError('Invalid param rp_purpose.');
      return;
    }

    $input_email = $request->getInputEmail();
    $verified_email = $assertion->getVerifiedEmail();
    if (empty($purpose) || $purpose == 'signin') {
      if (!empty($input_email) && ($input_email != $verified_email)) {
        $this->action->saveAssertion($request, $response);
        $this->action->sendErrorMismatch($request, $response);
      }
      else {
        // Check whether the email already exists.
        $account = GitContext::getAccountService()->getAccountByEmail($verified_email);
        $this->mergeAccountInfo($account, $assertion);
        $request->setAccount($account);
        if (empty($account)) {
          $this->action->saveAssertion($request, $response);
          $this->action->showNewAccountPage($request, $response);
        }
        else {
          if ($account->getAccountType() != GitAccount::FEDERATED) {
            $this->action->upgrade($request, $response);
            $account->setAccountType(GitAccount::FEDERATED);
            $request->setAccount($account);
          }
          $this->action->login($request, $response);
          $this->action->showHomePage($request, $response);
        }
      }
    }
    elseif ($purpose == 'upgrade') {
      $account = GitContext::getSessionManager()->getSessionAccount($verified_email);
      if (empty($account)) {
        $response->setError(sprintf('The email: %s has not logged in.', $verified_email));
      }
      elseif ($account->getEmail() != $verified_email) {
        $this->action->sendErrorMismatch($request, $response);
      }
      else {
        $this->action->upgrade($request, $response);
        $this->action->showHomePage($request, $response);
      }
    }
  }

  /**
   * Merges the account properties in the assertion to the account.
   * So that if the RP doesn't store
   * the profile picture the widget can display the picture on the IDP.
   */
  protected function mergeAccountInfo($account, $assertion) {
    if (!$account || !$assertion) {
      return;
    }
    if ($account->getDisplayName() == "") {
      $account->setDisplayName($assertion->getDisplayName());
    }
    if ($assertion->getPhotoUrl() != "" && $account->getPhotoUrl() == "") {
      $account->setPhotoUrl($assertion->getPhotoUrl());
    }
  }
}
