<?php
/**
 * @file
 * The page to handle the user login requests.
 * The identity toolkit widget posts requests to this
 * page.
 */

class GitLoginHandler {
  private $target;
  private $email;
  private $password;

  /**
   * construct
   */
  public function __construct($target, $email, $password) {
    $this->target = $target;
    $this->email = $email;
    $this->password = $password;
  }

  /**
   * execute
   */
  public function execute() {
    if (empty($this->target)) {
      GitUtil::sendError('Param rp_target can not be empty.');
    }
    else {
      $target = drupal_strtolower($this->target);
      if ($target == 'userstatus') {
        $this->handleUserStatus();
      }
      elseif ($target == 'login') {
        $this->handleLogin();
      }
      else {
        watchdog('user', 'Invalid param rp_target: %s', array('%s', $this->target), WATCHDOG_ERROR);
        GitUtil::sendError(sprintf('Invalid param rp_target: %s', $this->target));
      }
    }
  }

  /**
   * handle login
   */
  protected function handleLogin() {
    $action = new GitPasswordAction();
    $request = new GitLoginRequest($this->email, $this->password);
    $response = new GitPasswordResponse();
    $logic = new GitPasswordLogic($action);

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

  /**
   * handle user status
   */
  protected function handleUserStatus() {
    $action = new GitAccountStatusAction();
    $request = new GitLoginRequest($this->email, NULL);
    $response = new GitAccountStatusResponse();
    $logic = new GitAccountStatusLogic($action);
    $logic->run($request, $response);
    $error = $response->getError();
    if (!empty($error)) {
      watchdog('user', $error, NULL, WATCHDOG_ERROR);
      GitUtil::sendError($error);
    }
    else {
      header(sprintf('Content-type: %s', $response->getContentType()));
      echo $response->getOutput();
      exit;
    }
  }
}
