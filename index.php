<?php

    error_reporting(E_ALL);
    ini_set("display_errors", "On");
// autoload.php @generated by Composer

require_once __DIR__ . '/vendor/autoload.php'; // Autoload files using Composer autoload
use InnovateMR\InnovateApi; 

use InnovateMR\DbConnection; 

 $options['api_mode']     = "sandbox";
 $options['api_token']    = "";

 $dbCredentials = ['dbhost'=>'localhost','dbname'=>'yousafdb','dbuser'=>'root','dbpassword'=>'root'];
 $dbCredentials['sql_mode'] = true;

 $InnovatemrAPI = new InnovateApi($options);
 $dbConnection  = new DbConnection($dbCredentials); 

$result        = $InnovatemrAPI->APIcallGet($api_service);  
var_export($result);exit;
$culture =  $InnovatemrAPI->getCultures('Netherlands'); 
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
      "targeting": [],
      "CPI": "0.30",
      "isQuota": false,
      "jobCategory": "Beauty/Cosmetics"
    }
  ]
}'; 
    $jasonDecoded = json_decode($result);
    //print_r($jasonDecoded);
    $resultArray = $jasonDecoded->result; 
    $savedSurveyIds = getSurveyIdsInDb($resultArray); 
     
    if(1)
    {

      foreach($resultArray as $res)
      {
        if(!in_array($res->surveyId,$savedSurveyIds)){

          $countryData = $InnovatemrAPI->getCultures();
            $questions = $res->targeting;
          if(isset($res->JobId)){      
            $survey['jobId'] = $res->JobId;
          }
          if(isset($res->isPIIRequired)){        
          $survey['isPIIRequired'] = $res->isPIIRequired;
          }
          if(isset($res->expected_end_date)){        
             $survey['expected_end_date'] = $res->expected_end_date;
          }

          $survey['site_ids'] =  json_encode($countryData['site_ids']);
          $survey['surveyId'] = $res->surveyId;
          $survey['surveyName'] = $res->surveyName;
          $survey['isRevShr'] = $res->isRevShr;
          $survey['supCmps'] = $res->supCmps;
          $survey['remainingN'] = $res->remainingN;
          $survey['lOi'] = $res->LOI;
          $survey['iR'] = $res->IR;
          $survey['country'] = $res->Country;
          $survey['culture'] = $countryData['culture'];
          $survey['groupType'] = $res->groupType;
          $survey['deviceType'] = $res->deviceType;
          $survey['createdDate'] = $res->createdDate;
          $survey['modifiedDate'] = $res->modifiedDate;
          $survey['reContact'] = 'false';
          $survey['entryLink'] = $res->entryLink;
          $survey['testEntryLink'] = $res->testEntryLink;
          $survey['cPI'] = $res->CPI;
          $survey['isQuota'] = $res->isQuota;
          $survey['jobCategory'] = $res->jobCategory;
          $survey['status'] = $res->surveyId;
          $survey['created_at'] =  date("y-m-d H:i:s");
     
          $result = $dbConnection->insert('nl_innovate_survey',$survey); 
          $questionsArray = array();
          if(!empty($res->targeting) && $result['status'] !='fail'){      
            foreach($res->targeting as $question)
            {
              $questionsArray['questionId']       = $question->QuestionId;
              $questionsArray['questionKey']      = $question->QuestionKey;
              $questionsArray['surveyId']         = $res->surveyId;
              $questionsArray['questionText']     = $question->QuestionText;
              $questionsArray['questionType']     = $question->QuestionType;
              $questionsArray['questionCategory'] = $question->QuestionCategory;
              $questionsArray['options']          = json_encode($question->Options);
              $questionsArray['created_at']       =  date("y-m-d H:i:s");
              $result = $dbConnection->insert('nl_inovate_survey_questions',$questionsArray);  
              $questionsArray = array();
            }// END FOREACH.

        }// END IF CHECKING QUESTIONS.
          
            $survey = array();
        }// end of for loop for surveys.

      }// END IF

    }// END IF CONDITION FOR CHECKING THE SURVERYS.

    exit;
     if( count($result) > 0)
     {
     foreach($result as $obj){

        print_r($obj->QuestionText).'</br>';

     }
}//end for each.


function getSurveyIdsInDb($apiResult)
{
  $surveyIDs = array();
  global $dbConnection;
  foreach($apiResult as $res)
    {
        $surveyIDs[] .= $res->surveyId;
    }// END FOREACH.
    $surveyId = implode(",",$surveyIDs);
    $where    = "WHERE surveyId IN ($surveyId) ";
    $reasult  = $dbConnection->select('nl_innovate_survey', 'surveyId',$where, 2);
    $dbSurveys = array();
    if($reasult != 0)  
      { 
        foreach($reasult as $values)
          {
            $dbSurveys[] = $values['surveyId'];
          }// END foreach
      }
 
      return $dbSurveys;

}


function getQuestionsIdsInDb($surveyQuestionIds)
{
  $QuestionIds = array();
  global $dbConnection;
  foreach($surveyQuestionIds as $res)
    {
        $QuestionIds[] .= $res->QuestionId;
    }// END FOREACH.
    $QuestionIDs = implode(",",$QuestionIds);
    $where    = "WHERE surveyId IN ($QuestionIDs) ";
    $reasult  = $dbConnection->select('nl_inovate_survey_questions', 'questionId',$where, 2);
    $dbQuestions = array();
    if($reasult != 0)  
      { 
        foreach($reasult as $values)
          {
            $dbQuestions[] = $values['surveyId'];
          }// END foreach
      }
 
      return $dbQuestions;

}