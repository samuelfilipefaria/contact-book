<?php
  /**
   * Builds a feedback JSON message
   *
   * @param string $msg Message description
   * @param int $code Sucessfull message if code equals 1, 0 otherwise
   * @return string JSON string format
   */
  class Utils {
    public static function buildJSONMessage($msg, $code, $responseInfo = '') {
      return json_encode(array('message' => $msg, 'status_code' => $code, 'response_info' => $responseInfo));
    }
  }
?>