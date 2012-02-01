<?php
/**
 * @file
 * Helper class to check whether a domain is a Google apps domain.
 */

class GitDasherDomainChecker {
  const DASHER_XRDS_URL_PREFIX = "https://www.google.com/accounts/o8/site-xrds?hd=";
  const XRDS_MIME_TYPE = "application/xrds+xml";
  /**
   * is dasher domain
   */
  public function isDasherDomain($domain) {
    return $this->checkDasherDomain($domain);
  }
  /**
   * check dasher domain
   */
  protected function checkDasherDomain($domain) {
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => self::DASHER_XRDS_URL_PREFIX . $domain,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_SSL_VERIFYPEER => FALSE,
        CURLOPT_SSL_VERIFYHOST => FALSE,)
    );

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $mime_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    curl_close($ch);
    return ($http_code == '200' && stripos($mime_type, self::XRDS_MIME_TYPE) !== FALSE && !empty($response));
  }
}
