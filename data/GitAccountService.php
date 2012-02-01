<?php
/**
 * @file
 * The account related operations that the relying party
 * site needs to implement.
 */

interface GitAccountService {

  /**
   * get account by email
   */
  function getAccountByEmail($email);

  /**
   * check password
   */
  function checkPassword($email, $password);

  /**
   * to federated
   */
  function toFederated($email);
}
