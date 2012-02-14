<?php
/**
 * @file
 * git util
 */
require_once dirname(__FILE__) . '/GitContext.php';

class GitUtil {
  private static $emailPattern = '/\w+(\.\w+)*@(\w+(\.\w+)+)/';

  private static $federatedDomains = array(
    'gmail.com', 'googlemail.com',
    'aol.com', 'aim.com', 'netscape.net', 'cs.com',
    'ygm.com', 'games.com', 'love.com', 'wow.com',
    'yahoo.com', 'rocketmail.com', 'ymail.com', 'y7mail.com',
    'yahoo.com.au', 'yahoo.com.cn', 'yahoo.cn', 'yahoo.com.hk',
    'yahoo.co.nz', 'yahoo.com.pk', 'yahoo.com.tw', 'kimo.com',
    'bellsouth.net', 'ameritech.net', 'att.net', 'attworld.com',
    'flash.net', 'nvbell.net', 'pacbell.net', 'prodigy.net',
    'sbcglobal.net', 'snet.net', 'swbell.net', 'wans.net',
    'btinternet.com', 'btopenworld.com', 'talk21.com', 'rogers.com',
    'nl.rogers.com', 'demobroadband.com', 'xtra.co.nz', 'verizon.net',
    'hotmail.com', 'hotmail.co.uk', 'hotmail.fr',
    'hotmail.it', 'live.com', 'msn.com', );


  /**
   * get current url
   */
  public static function getCurrentUrl() {
    $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
    $url .= $_SERVER['SERVER_NAME'];
    if ($_SERVER['SERVER_PORT'] != '80') {
      $url .= $_SERVER['SERVER_PORT'];
    }
    $url .= request_uri();
    return $url;
  }

  /**
   * send error
   */
  public static function sendError($message) {
    exit('Error: ' . $message);
  }

  /**
   * is Valid Eamil
   */
  public static function isValidEmail($email) {
    return preg_match(GitUtil::$emailPattern, $email);
  }

  /**
   * get Email domain
   */
  public static function getEmailDomain($email) {
    $email = drupal_strtolower(trim($email));
    $parts = explode('@', $email);
    if (count($parts) > 1) {
      return $parts[1];
    }
    return $parts[0];
  }

  /**
   * is federated domain
   */
  public static function isFederatedDomain($domain) {
    if (in_array($domain, GitUtil::$federatedDomains)) {
      return TRUE;
    }
    return GitContext::getDasherDomainChecker()->isDasherDomain($domain);
  }
}
