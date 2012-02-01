<?php
/**
 * @file
 * The action class to generate the responses.
 */

class GitCallbackAction {
  /**
   * save Assertion
   */
  public function saveAssertion($request, $response) {
    GitContext::getSessionManager()->setAssertion($request->getAssertion());
  }

  /**
   * set success
   */
  protected function setSuccess($response, $account, $result) {
    $HTML = array();
    $HTML[] = '<html><head>';
    $HTML[] = '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>';
    $HTML[] = '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js"></script>';
    $HTML[] = '<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/googleapis/0.0.4/googleapis.min.js"></script>';
    $HTML[] = '<script type=text/javascript src="https://ajax.googleapis.com/jsapi"></script>';
    $HTML[] = '<script type="text/javascript">';
    $HTML[] = 'google.load("identitytoolkit", "1.0", {packages: ["ac", "notify"]});';
    $HTML[] = '</script>';
    $HTML[] = '<script type="text/javascript">';
    $HTML[] = 'google.identitytoolkit.updateSavedAccount(%s);';
    $HTML[] = 'google.identitytoolkit.notifyFederatedSuccess(%s);';
    $HTML[] = '</script>';
    $HTML[] = '</head><body></body></html>';

    $json_account = json_encode($account);
    $json_result = json_encode($result);
    $str_html = implode('', $HTML);
    $output = sprintf($str_html, $json_account, $json_result);
    $response->setOutput($output);
  }

  /**
   * set Error
   */
  protected function setError($response, $code, $param) {
    $HTML = array();
    $HTML[] = '<html><head>';
    $HTML[] = '<script type=text/javascript src="https://ajax.googleapis.com/jsapi"></script>';
    $HTML[] = '<script type="text/javascript">';
    $HTML[] = 'google.load("identitytoolkit", "1.0", {packages: ["notify"]});';
    $HTML[] = '</script>';
    $HTML[] = '<script type="text/javascript">';
    $HTML[] = 'google.identitytoolkit.notifyFederatedError("%s", %s);';
    $HTML[] = '</script>';
    $HTML[] = '</head><body></body></html>';

    $json = json_encode($param);
    $str_html = implode('', $HTML);
    $output = sprintf($str_html, $code, $json);
    $response->setOutput($output);
  }

  /**
   * send error misatch
   */
  public function sendErrorMismatch($request, $response) {
    $result = array();
    $result['validatedEmail'] = $request->getAssertion()->getVerifiedEmail();
    $result['inputEmail'] = $request->getInputEmail();
    $result['purpose'] = $request->getPurpose();
    $this->setError($response, 'accountMismatch', $result);
  }

  /**
   * send error no verified email
   */
  public function sendErrorNoVerifiedEmail($request, $response) {
    $this->setError($response, 'invalidAssertionEmail', NULL);
  }

  /**
   * send error server
   */
  public function sendErrorServer($request, $response) {
    $this->setError($response, 'invalidAssertion', NULL);
  }

  /**
   * send error user cancel
   */
  public function sendErrorUserCancel($request, $response) {
    $this->setError($response, 'invalidAssertion', NULL);
  }

  /**
   * show home page
   */
  public function showHomePage($request, $response) {
    $result = array();
    $result['email'] = $request->getAccount()->getEmail();
    $result['registered'] = TRUE;

    $account = array();
    $account['email'] = $request->getAccount()->getEmail();
    $account['displayName'] = $request->getAccount()->getDisplayName();
    $account['photoUrl'] = $request->getAccount()->getPhotoUrl();

    $this->setSuccess($response, $account, $result);
  }

  /**
   * show new account page
   */
  public function showNewAccountPage($request, $response) {
    $assertion = $request->getAssertion();
    $result = array();

    $result['email'] = $assertion->getVerifiedEmail();
    $result['registered'] = FALSE;

    $account = array();
    $account['email'] = $assertion->getVerifiedEmail();
    $account['displayName'] = $assertion->getDisplayName();
    $account['photoUrl'] = $assertion->getPhotoUrl();

    $this->setSuccess($response, $account, $result);
  }

  /**
   * upgrade
   */
  public function upgrade($request, $response) {
    $verified_email = $request->getAssertion()->getVerifiedEmail();
    GitContext::getAccountService()->toFederated($verified_email);
    $account = GitContext::getAccountService()->getAccountByEmail($verified_email);
    if (!empty($account)) {
      GitContext::getSessionManager()->setSessionAccount($account);
    }
  }

  /**
   * login
   */
  public function login($request, $response) {
    GitContext::getSessionManager()->setSessionAccount($request->getAccount());
  }
}
