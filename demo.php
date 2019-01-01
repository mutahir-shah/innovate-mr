<?php
error_reporting(E_ALL);
    ini_set("display_errors", "On");
  require_once __DIR__ . '/vendor/autoload.php';  
  use InnovateMR\InnovateApi; 
  use InnovateMR\DbConnection; 
class demo {
  
  private $options;
  private $connectionOptions;
  private $InnovatemrAPI;

  public function __construct()
  {
    $optionsArray['api_mode']     = "sandbox";
   $optionsArray['api_token']    = "";
   $this->options = $optionsArray;

   $this->InnovatemrAPI = new InnovateApi($this->options);

  }
    
    public function get($api_service){

      if(isset($api_service) && !empty($api_service))
          { 
                $result   = $this->InnovatemrAPI->APIcallGet($api_service);
            }
            else {
               $result   = $this->InnovatemrAPI->APIcallGet('getQuestionsByCategory/NETHERLANDS/DUTCH');  
          }
      echo '<pre>';
      var_export($result);
    }
  
}
$api_service = @$_REQUEST['method'];
$obj = new demo;
$obj->get($api_service);
