<?php
/**
 * @file
 * Communicates with the identity toolkit API.
 */

class GitApiClient {
  private static $verifyUrl = 'https://www.googleapis.com/identitytoolkit/v1/relyingparty/verifyAssertion?key=';
  private $apiKey = 'your_api_key';

  /**
   * construct
   */
  public function __construct($api_key) {
    $this->apiKey = $api_key;
  }

  /**
   * post data
   */
  protected function post($post_data) {
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => GitApiClient::$verifyUrl . $this->apiKey,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        CURLOPT_POSTFIELDS => json_encode($post_data),
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($http_code == '200' && !empty($response)) {
      return json_decode($response, TRUE);
    }
    else {
      return NULL;
    }
  }


  /**
   * verify
   */
  public function verify($url, $post_body) {
    $request = array();
    $request['requestUri'] = $url;
    $request['postBody'] = $post_body;
    $request['p'] = GitContext::getConfig()->getPluginName();

    $response = $this->post($request);
    if (!empty($response)) {
      $identifier = NULL;
      if (isset($response['identifier'])) {
        $identifier = $response['identifier'];
      }
      // e.g. Google as an IDP to assert Yahoo email address.
      $verified_email = NULL;
      if (isset($response['verifiedEmail'])) {
        $verified_email = $response['verifiedEmail'];
      }
      $assertion = new GitAssertion($identifier, $verified_email);
      if (!empty($response['firstName'])) {
        $assertion->setFirstName($response['firstName']);
      }
      if (!empty($response['lastName'])) {
        $assertion->setLastName($response['lastName']);
      }
      if (!empty($response['profilePicture'])) {
        $assertion->setPhotoUrl($response['profilePicture']);
      }
      if (!empty($response['fullName'])) {
        $assertion->setFullName($response['fullName']);
      }
      if (!empty($response['nickName'])) {
        $assertion->setNickName($response['nickName']);
      }
      return $assertion;
    }
    return NULL;
  }
}
