<?php
/**
 * Created by PhpStorm.
 * User: vminakov
 * Date: 8/6/14
 * Time: 4:17 AM
 */

class Group {
  public $id;
  public $name;
  public $description;
  public $players;

  public function __construct(){
    $this->id = 0;
    $this->name = '';
    $this->description = '';
    $this->players = array();
  }

  public function addPlayer($player){
    if ($player === null)
      return;
    array_push($this->players, $player);
  }
} 