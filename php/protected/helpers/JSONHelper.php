<?php
class JSONHelper {
  private $params;
  private $response = array();
  
  public function __construct($request) {
    $this->params = $request;
  }

  private function setError($message) {
    $this->response["success"] = 0;
    $this->response["message"] = $message;
    header('Content-type: application/json');
    echo $this->getJson();
    Yii::app()->end();
  }  

  public function end($message) {
    $this->response["success"] = 1;
    $this->response["message"] = $message;
    header('Content-type: application/json');
    echo $this->getJson();
    Yii::app()->end();    
  }

  public function login() {
    $device = Device::model()->findByAttributes(array('Username'=>$this->params['Username']));
    $this->assertTrue($device!=null,"Incorrect Username.");
    $this->assertTrue(!empty($device->SaleId),"No SaleId");
    $this->assertTrue($this->params['Password']==$device->Password,"Incorrect Password.");
    return $device;
  }

  public function setValue($key, $val) {
    $this->response[$key] = $val;
  }

  public function setDataRow($table, $rows) {
    $this->response["data"][$table] = $rows;
  }

  public function assertTrue($val, $message) {
    if (!$val) $this->setError($message);
  }

  public function assertRequiredParams($args) {
    $args = array_merge(array("Username","Password","DeviceKey"), $args);
    foreach ($args as $arg) {
      $this->assertTrue(isset($this->params[$arg]),
          "Missing paramter: '$arg'.");
    }
    return true;
  }

  private function getJson() {
    return json_encode($this->response);
  }
}

?>