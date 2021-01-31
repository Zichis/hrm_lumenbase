<?php

namespace App\Service;

/**
 * @author Ezichi Ebere
 */
class UserService
{
  public function responseMessage(string $message = null, array $data = [])
  {
    return array(
      'message' => $message,
      'data' => $data
    );
  }
}
