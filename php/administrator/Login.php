<?php
   /*
    * File with the methods and commands to check it the user can administrates 
    * the web
    */

   // Set the directory to be used in the includes if it is necesary
   if (! strpos ( get_include_path (), $_SERVER['DOCUMENT_ROOT'].'/php/')) {
      set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT'].
         '/php/');
   }
   
   if (! strpos ( get_include_path (), dirname ( __FILE__ ) )) {
      set_include_path ( get_include_path () . PATH_SEPARATOR . dirname ( __FILE__ ) );
   }
  
   //Declare the includes and
   include_once 'LoggerMgr/LoggerMgr.php';
   
   include_once 'php/Database/Tables/TB_User.php';
    
   //Constants definition
   const RESULT_CODE_OK = 0;
   const RESULT_CODE_ERROR = 1;
   const RESULT_USER_NO_EXITS = 2;
   const RESULT_PWD_NO_MATCH = 3;
   const RESULT_ERROR_DESCRYPT = 4;
   const RESULT_CODE_C = "Result_Code";
   const MESSAGE_ERROR_C = "Message_Error";
   
   
   const PARAM_USER_C = "user";
   const PARAM_PWD_C = "pwd";
   
   //Constants definition for connecto with the database
   //const HOST_C = "localhost";
   //const DDBB_C = "Legafitness";
   
   const NAME_KEY_FILE_C = '/privateKey_1024.pem';
      
   $logger = LoggerMgr::Instance()->getLogger(basename(__FILE__));
   $logger->trace("Enter");
   $logger->debug("A request from web has been received");
   $resultArray = array();
   if (!isset($_POST[PARAM_USER_C]) || ! isset($_POST[PARAM_PWD_C])){
      $logger->error("In the request ausence of any parameter");
      $logger->trace("Exit");
      $resultArray[RESULT_CODE_C] = RESULT_CODE_ERROR;
      $resultArray[MESSAGE_ERROR_C] ="Ausence a parameter";
      $error = true;
   }else{
      $user = $_POST[PARAM_USER_C];
      $encryptedPwd = $_POST[PARAM_PWD_C];
      $logger->debug("The user is [ $user ] and the encrypted password is [ $encryptedPwd ]");
      $pwd = "";
    
      $pathKeyFile = dirname(__FILE__).'/'.NAME_KEY_FILE_C;
      
      if ( !openssl_private_decrypt(base64_decode($encryptedPwd),$pwd, 
                           openssl_pkey_get_private('file://'.$pathKeyFile)) ){
         $logger->error("An error has ocurred in the descrypt process");
         $resultArray[RESULT_CODE_C] = RESULT_ERROR_DESCRYPT;
         $resultArray[MESSAGE_ERROR_C] = "The password has not been descrypted";
         $error = true;
      }else{
         $logger->debug("Encrypted pwd [ $encryptedPwd ] -> descrypted -> [ $pwd ]");
         $logger->debug("Accessing to the database and check if the user and password exist");
         $tbUser = new TB_User();
         $tbUser->open();
         if ($tbUser->searchByKey($user)){
            $logger->trace("The user [ $user ] exists");
            if ($pwd != $tbUser->getPassword()){
               $logger->warn("The password [ $pwd ] doesn't match");
               $resultArray[RESULT_CODE_C] = RESULT_PWD_NO_MATCH;
               $resultArray[MESSAGE_ERROR_C] = "The password doesn't match";
               $error = true;
            }else{
               $logger->debug("The access is correct");
               $resultArray[RESULT_CODE_C] = RESULT_CODE_OK;
            }
         }else{
            $logger->warn("The user [ $user ] doesn't in the database");
            $resultArray[RESULT_CODE_C] = RESULT_USER_NO_EXITS;
            $resultArray[MESSAGE_ERROR_C] = "The user doesn't exist in the database";
            $error = true;
         }
         
      }
   }
   
   //print (json_encode($resultArray));
   $logger->trace("Exit");
   
?>