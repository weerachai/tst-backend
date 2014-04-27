<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

class UserIdentity extends CUserIdentity
{
  private $_id;
  private $_eid;
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
        if ($this->isOperator($record->employee))
          $this->setState('userType', 'operator');
        elseif ($this->isSuper($record->employee))
          $this->setState('userType', 'supervisor');
        elseif ($this->isSale($record->employee))
          $this->setState('userType', 'salesman');
        else
          $this->setState('userType', 'none');
        $this->errorCode=self::ERROR_NONE;
      }
    return !$this->errorCode;
  }
  
  public function getId()
  {
    return $this->_id;
  }
  public function isOperator($id) {
    return (empty($id) || is_null($id));
  }
  public function isSuper($id)
  {
    if (empty($id) || is_null($id))
      return false;
    $model = SaleArea::model()->find("SupervisorId = ?", array($id));
    return !is_null($model);
  }
  public function isSale($id)
  {
    if (empty($id) || is_null($id))
      return false;
    $model = SaleUnit::model()->find("EmployeeId = ?", array($id));
    return !is_null($model);
  }
}
