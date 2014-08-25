<?php
/**
 * Created by PhpStorm.
 * User: vminakov
 * Date: 8/17/14
 * Time: 3:26 AM
 */

class Statistic {
  public $id;
  public $filename;
  public $date;
  public $time;
  public $upid;
  public $pname;
  public $pdescription;
  public $uid;

  public function __construct($obj = null){
    if ($obj !== null){
      $this->id = $obj->id;
      $this->filename = $obj->filename;
      $this->date = $obj->date;
      $this->time = $obj->time;
      $this->upid = $obj->upid;
      $this->pname = $obj->pname;
      $this->pdescription = $obj->pdescription;
      $this->uid = $obj->uid;
    }
  }
} 