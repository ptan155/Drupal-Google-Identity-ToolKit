<?php
/**
 * @file
 * Base class for the responses.
 */

abstract class GitAbstractResponse {
  private $output;
  private $error;
  private $contentType;

  /**
   * get out put
   */
  public function getOutput() {
    return $this->output;
  }

  /**
   * set out put
   */
  public function setOutput($output, $content_type = 'text/html') {
    $this->output = $output;
    $this->contentType = $content_type;
  }

  /**
   * get content type
   */
  public function getContentType() {
    return $this->contentType;
  }

  /**
   * get Error
   */
  public function getError() {
    return $this->error;
  }

  /**
   * set Error
   */
  public function setError($error) {
    $this->error = $error;
  }
}
