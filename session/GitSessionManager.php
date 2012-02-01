<?php
/**
 * @file
 * Manages data in the session. The relying party site
 * may save session data in server side (in
 * memory or persistent storage) or in the client side (cookie).
 */

interface GitSessionManager {

  /**
   * Gets the logged in account in the current session.
   * logged in.
   */
  function getSessionAccount();

  /**
   * Saves the logged account information to the session and logs
   *  the user *  in. If parameter is NULL,
   * the account in the session should be removed.
   */
  function setSessionAccount($account);

  /**
   * Gets the IDP assertion for the request.
   */
  function getAssertion();

  /**
   * Saves the IDP assertion information to the session.
   * If parameter * is NULL, the data in the
   * session should be cleared.
   */
  function setAssertion($assertion);
}
