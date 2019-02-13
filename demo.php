<?php
    error_reporting(E_ALL);
    ini_set("display_errors", "On");
  require_once __DIR__ . '/vendor/autoload.php';  
  use InnovateMR\InnovateApi; 
  use InnovateMR\DbConnection; 
class demo {
  
  private $options;
  public $connectionOptions;
  private $InnovatemrAPI;

  public function __construct()
  {
   $optionsArray['api_mode']    = "sandbox";
   $optionsArray['api_token']    = "";

   $optionsArray['dbhost']     = 'localhost';
   $optionsArray['dbuser']     = 'root';
   $optionsArray['dbpassword'] = 'root';
   $optionsArray['dbname']     = 'yousafdb';

   $this->options              = $optionsArray;
   $this->InnovatemrAPI        = new InnovateApi($this->options);
   $this->connectionOptions    = new DbConnection($this->options);

  }
    
    public function get($api_service){

      if(isset($api_service) && !empty($api_service))
          { 
                $result   = $this->InnovatemrAPI->APIcallGet($api_service);
            }
            else {
               $result   = $this->InnovatemrAPI->APIcallGet('getQuestionsByCategory/US/ENGLISH');  
          }

          return $result;
    }

  
}
    $api_service = @$_REQUEST['method'];
    $obj         = new demo;
    $result       = $obj->get($api_service);
    $questionsArray = array();
      foreach($result as $question)
            {
               $values = array( $question->QuestionId,
                                $question->QuestionKey,
                             addslashes($question->QuestionText),
                             $question->QuestionType,
                             $question->Category[0],
                             date("y-m-d H:i:s")
                                       );
               $questionsArray [] = $obj->connectionOptions->createColumnValues($values); 
            }// END FOREACH. 
 // ksort($questionsArray);
  $questionsArray = array_chunk($questionsArray,400);
  $columns        = array( 
                  'questionId' ,
                  'questionKey',
                  'questionText',
                  'questionType',
                  'questionCategory',
                  'created_at'
              ); 
foreach($questionsArray as $values){
   $val = implode(",",$values);  
    $res = $obj->connectionOptions->bulkInsert('nl_inovate_survey_questions', $columns, $val); 
}


