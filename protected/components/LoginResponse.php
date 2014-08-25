<?php
/**
 * Created by PhpStorm.
 * User: vminakov
 * Date: 8/6/14
 * Time: 1:20 PM
 */

class LoginResponse {
  public $status;
  public $uuid;

  public function __construct(){
    $this->status = 0;
    $this->uuid = 0;
  }
} 