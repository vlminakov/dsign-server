<?php

class Timetable {
  public $id = 0;
  public $name = '';
  public $user_id = 0;
  public $content = '';

  public function __construct($data = null){
    if ($data == null){
      $this->id = 0;
      $this->name = '';
      $this->user_id = 0;
      $this->content = '';
    } else {
      $this->id = $data->id;
      $this->name = $data->name;
      $this->user_id = $data->user_id;
      $this->content = $data->content;
    }
  }
} 