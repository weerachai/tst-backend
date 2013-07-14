<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity
{
  private $_id;
  public function authenticate()
  {
    $hash = new myMD5();
    $record=User::model()->findByAttributes(array('username'=>$this->username));
    if($record===null)
      $this->errorCode=self::ERROR_USERNAME_INVALID;
    else if($record->password!==$hash->hash($this->password))
      $this->errorCode=self::ERROR_PASSWORD_INVALID;
    else
      {
        $this->_id=$record->id;
        $this->setState('name', $record->name);
        $this->errorCode=self::ERROR_NONE;
      }
    return !$this->errorCode;
  }
  
  public function getId()
  {
    return $this->_id;
  }
}
