<?php
    error_reporting(E_ALL);
    ini_set("display_errors", "On");
  require_once __DIR__ . '/vendor/autoload.php';  
  use InnovateMR\InnovateApi; 
  use InnovateMR\DbConnection; 
class demo {
  
  private $options;
  public $connectionOptions;
  public $InnovatemrAPI;

  public function __construct()
  {
   $optionsArray['api_mode']    = "sandbox";
   $optionsArray['api_token']    = " ";

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
    $api_service    = @$_REQUEST['method'];
    $obj            = new demo;
    //$result         = $obj->get($api_service);
    $result = '{
  "apiStatus": "success",
  "msg": " All live groups are successfully searched",
  "result": [
    {
      "surveyId": 12632,
      "surveyName": "Basic Demo With Beverage survey",
      "N": 100,
      "isRevShr": true,
      "supCmps": 3,
      "remainingN": 97,
      "LOI": 15,
      "IR": 10,
      "Country": "United States",
      "Language": "ENGLISH",
      "groupType": "Consumer",
      "deviceType": "All",
      "createdDate": "09/11/2017, 11:03:50 pm PST",
      "modifiedDate": "09/11/2017, 11:50:27 pm PST",
      "reContact": false,
      "entryLink": "http://innovate-stage-209385288.us-east-1.elb.amazonaws.com/startSurvey?survNum=86NMz1YX&supCode=225&PID=[%%pid%%]",
      "testEntryLink": "",
      "targeting": [
        {
          "QuestionId": 11,
          "QuestionKey": "ZIPCODES",
          "QuestionText": "What is your zipcode?",
          "QuestionType": "Numeric Open Ended",
          "QuestionCategory":"Demographic",
          "Options": [
            {
              "OptionId": 1,
              "OptionText": "800235"
            }
          ]
        },
       {
          "QuestionId": 1,
          "QuestionKey":"AGE",
          "QuestionText":"What is your age?",
          "QuestionType":"Numeric Open Ended",
          "QuestionCategory":"Demographic",
           "Options":[
              {
                 "OptionId":1,
                 "ageStart":15,
                 "ageEnd":30
              }
           ]
         },
          {
             "QuestionId": 2,
             "QuestionKey":"GENDER",
             "QuestionText":"What is your gender?",
             "QuestionType":"Single Punch",
             "QuestionCategory":"Demographic",
             "Options":[
                {
                   "OptionId":1,
                   "OptionText":"Male"
                },
                {
                   "OptionId":2,
                   "OptionText":"Female"
                }
             ]
          }
      ],
      "CPI": "4.50",
      "isQuota": true,
      "jobCategory": "Beauty/Cosmetics",
      "isPIIRequired": false,
      "JobId": 9175,
      "expected_end_date": "09/21/2018"

    },
    {
      "surveyId": 12631,
      "surveyName": "Basic Demo With Miscellaneous",
      "N": 100,
      "isRevShr": true,
      "supCmps": 0,
      "remainingN": 100,
      "LOI": 15,
      "IR": 10,
      "Country": "United States",
      "Language": "ENGLISH",
      "groupType": "Consumer",
      "deviceType": "All",
      "createdDate": "09/11/2017, 11:03:50 pm PST",
      "modifiedDate": "10/09/2017, 9:26:27 am PST",
      "reContact": false,
      "entryLink": "http://innovate-stage-209385288.us-east-1.elb.amazonaws.com/startSurvey?survNum=M6wXK8P8&supCode=225&PID=[%%pid%%]",
      "testEntryLink": "",
      "targeting": [ 
      {
        "QuestionId": 801,
        "QuestionText": "ma hi easimat alhind?",
        "QuestionKey": "TESTING_A_8012",
        "QuestionType": "Single Punch", 
        "QuestionCategory": "Testing_A",
          "Options":[
              {
                 "OptionId":1,
                 "ageStart":15,
                 "ageEnd":30
              }
           ]
      },
      {
        "QuestionId": 804,
        "QuestionText": "\'ayn taeish?",
        "QuestionKey": "TESTING_AB_804",
        "QuestionType": "Single Punch", 
        "QuestionCategory":"TESTING_KASH",
         "Options": [
      {
        "OptionText": "Male",
        "id": 1
      },
      {
        "OptionText": "Female",
        "id": 2
      }
    ]
      }],
      "CPI": "0.30",
      "isQuota": false,
      "jobCategory": "Beauty/Cosmetics"
    }
  ]
}'; 
    $jasonDecoded = json_decode($result);
    $resultArray = $jasonDecoded->result; 

    $questionsArray = array();
    $columns        = array( 
                            'surveyId'         ,
                            'surveyName'       ,
                            'isRevShr'         ,
                            'supCmps'          ,
                            'remainingN'       ,
                            'lOi'              ,
                            'iR'               ,
                            'country'          ,
                            'culture'          ,
                            'site_ids'         ,
                            'groupType'        ,
                            'deviceType'       ,
                            'createdDate'      ,
                            'modifiedDate'     ,
                            'reContact'        ,
                            'entryLink'        ,
                            'testEntryLink'    ,
                            'cPI'              ,
                            'isQuota'          ,
                            'jobCategory'      ,
                            'isPIIRequired'    ,
                            'jobId'            ,
                            'expected_end_date',
                            'status'           ,
                            'created_at'
                          );
    $surveyColumns = ['surveyId','questionId'];
    $surveyToQuestionsEntryArray = array();
      $countryData = $obj->InnovatemrAPI->getCultures();
      foreach($resultArray as $res)
            {
            if(isset($res->JobId)){      
            $jobId = $res->JobId;
          }
          if(isset($res->isPIIRequired)){        
          $isPIIRequired = $res->isPIIRequired;
          }
          if(isset($res->expected_end_date)){        
             $expected_end_date = $res->expected_end_date;
          }
              if(!empty($res->targeting)){      
            foreach($res->targeting as $question)
            {
               $surveyToQuestionsEntryArray[] = $obj->connectionOptions->createColumnValues(array($res->surveyId,$question->QuestionId));  
            }// END FOREACH.

        }// END IF CHECKING QUESTIONS.

          

              $values = array(
                             $res->surveyId,
                             addslashes($res->surveyName), 
                             $res->isRevShr,
                             $res->supCmps,
                             $res->remainingN,
                             $res->LOI,
                             $res->IR,
                             $res->Country,
                             $countryData['culture'],
                             json_encode($countryData['site_ids']),
                             $res->groupType,
                             $res->deviceType,
                             $res->createdDate,
                             $res->modifiedDate,
                             'false',
                             $res->entryLink,
                             $res->testEntryLink,
                             $res->CPI,
                             $res->isQuota,
                             $res->jobCategory,
                             $isPIIRequired,
                             $jobId,
                             $expected_end_date,
                             'Pending',
                             date("y-m-d H:i:s")
                              );
               $questionsArray [] = $obj->connectionOptions->createColumnValues($values); 
            }// END FOREACH. 


      $surveyQuestionsArray = array_chunk($surveyToQuestionsEntryArray,400);
   
      foreach($surveyQuestionsArray as $quest)
      {
         $obj->connectionOptions->bulkInsert('inovate_survey_to_questions', $surveyColumns, implode(",",$quest));
      }exit;
  
      $questionsArray = array_chunk($questionsArray,400);
      foreach($questionsArray as $values) {
          $val = implode(",",$values);  
          $res = $obj->connectionOptions->bulkInsert('nl_innovate_survey', $columns, $val); 
  }


