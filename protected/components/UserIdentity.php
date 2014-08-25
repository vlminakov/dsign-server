<?php
class UserIdentity extends CUserIdentity
{
  private $_id;
  public $email;
  public $password;

  public function __construct($email, $pass){
    $this->email = $email;
    $this->password = $pass;
  }

  public function authenticate(){
    $user = Users::model()->findByAttributes(array('email'=>$this->email));
    if ($user === null)
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    else if ($user->password !== $this->password) //md5($this->password))
      $this->errorCode = self::ERROR_PASSWORD_INVALID;
    else {
      $this->_id=$user->id;
      $this->setState('uuid', $user->uuid);
      $this->setState('name', $user->name);
      $this->setState('id', $user->id);
      $this->setState('surname', $user->surname);
      $this->setState('phone', $user->phone);
      $this->setState('email', $user->email);
      $this->setState('company', $user->comany_name);
      $role = $user->is_admin > 0 ? 'admin' : 'user';
      $this->setState('role', $role);

      $this->errorCode=self::ERROR_NONE;
    }

    return !$this->errorCode;
  }

  public function getId(){
    return $this->_id;
  }
}