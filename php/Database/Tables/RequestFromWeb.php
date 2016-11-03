<?php
   /**
    * File used for receive the request from the web and map the request params
    * in functions
    */

   /****************** INCLUDES ******************************/
   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
   require_once 'php/Database/Tables/RequestFromWebConstants.php';
   include_once 'php/LoggerMgr/LoggerMgr.php';
   include_once 'php/Database/Tables/TB_User.php';
   include_once 'php/Database/Tables/TB_Activity.php';
   include_once 'php/Database/Tables/TB_Timetable.php';
   include_once 'php/Database/Tables/TB_News.php';

   /*** Definition of the global variables and constants ***/
   /**
    * Object for write the log in a file
    */

   $logger = null;



   /****************** Functions *****************************/

   function getTable($theTableName){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Create object [ $theTableName ]");
      $returnedTable = null;

      if (strcmp($theTableName, TB_User::TB_UserTableC) == 0){
         $returnedTable = new TB_User();
      }

      if (strcmp($theTableName, TB_Activity::TB_ActivityTableC) == 0){
         $returnedTable = new TB_Activity();
      }

      if (strcmp($theTableName, TB_Timetable::TB_TimetableTableC) == 0){
         $returnedTable = new TB_Timetable();
      }

      if (strcmp($theTableName, TB_News::TB_NewsTableC) == 0){
         $returnedTable = new TB_News();
      }
      $logger->trace("Exit");
      return  $returnedTable;
   }

   function updateData($theTable, $theRows, &$theResult){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Rows: [ ".json_encode($theRows)." ]");
      $logger->trace("Update data of [ " . $theTable->getTableName() ." ]");
      foreach ( $theRows as $row){
         $key = $row[PARAM_KEY];
         $logger->trace("Search by [ $key ]");
         if ( $theTable->searchByKey($key)){
            $logger->trace("The Key has been found.");
            if (strcmp($theTable->getTableName(),TB_User::TB_UserTableC) == 0){
               if (isset($row[TB_User::PasswordColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_User::PasswordColumnC ." ] -> [ ".
                             $row[TB_User::PasswordColumnC] ." ]");
                  $theTable->setPassword($row[TB_User::PasswordColumnC ]);
                }
               if (isset($row[TB_User::NombreColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_User::NombreColumnC ." ] -> [ ".
                             $row[TB_User::NombreColumnC] ." ]");
                  $theTable->setNombre($row[TB_User::NombreColumnC ]);
                }
               if (isset($row[TB_User::ApellidosColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_User::ApellidosColumnC ." ] -> [ ".
                             $row[TB_User::ApellidosColumnC] ." ]");
                  $theTable->setApellidos($row[TB_User::ApellidosColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_Activity::TB_ActivityTableC) == 0){
               if (isset($row[TB_Activity::NombreColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Activity::NombreColumnC ." ] -> [ ".
                             $row[TB_Activity::NombreColumnC] ." ]");
                  $theTable->setNombre($row[TB_Activity::NombreColumnC ]);
                }
               if (isset($row[TB_Activity::ColorColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Activity::ColorColumnC ." ] -> [ ".
                             $row[TB_Activity::ColorColumnC] ." ]");
                  $theTable->setColor($row[TB_Activity::ColorColumnC ]);
                }
               if (isset($row[TB_Activity::ImageColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Activity::ImageColumnC ." ] -> [ ".
                             $row[TB_Activity::ImageColumnC] ." ]");
                  $theTable->setImage($row[TB_Activity::ImageColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_Timetable::TB_TimetableTableC) == 0){
               if (isset($row[TB_Timetable::NameColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Timetable::NameColumnC ." ] -> [ ".
                             $row[TB_Timetable::NameColumnC] ." ]");
                  $theTable->setName($row[TB_Timetable::NameColumnC ]);
                }
               if (isset($row[TB_Timetable::DetailColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_Timetable::DetailColumnC ." ] -> [ ".
                             $row[TB_Timetable::DetailColumnC] ." ]");
                  $theTable->setDetail($row[TB_Timetable::DetailColumnC ]);
                }
            }

            if (strcmp($theTable->getTableName(),TB_News::TB_NewsTableC) == 0){
               if (isset($row[TB_News::DateTimeColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_News::DateTimeColumnC ." ] -> [ ".
                             $row[TB_News::DateTimeColumnC] ." ]");
                  $theTable->setDateTime($row[TB_News::DateTimeColumnC ]);
                }
               if (isset($row[TB_News::TitleColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_News::TitleColumnC ." ] -> [ ".
                             $row[TB_News::TitleColumnC] ." ]");
                  $theTable->setTitle($row[TB_News::TitleColumnC ]);
                }
               if (isset($row[TB_News::NewColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_News::NewColumnC ." ] -> [ ".
                             $row[TB_News::NewColumnC] ." ]");
                  $theTable->setNew($row[TB_News::NewColumnC ]);
                }
               if (isset($row[TB_News::PublishedColumnC])){
                  $logger->trace("Set value to column [ ".
                             TB_News::PublishedColumnC ." ] -> [ ".
                             $row[TB_News::PublishedColumnC] ." ]");
                  $theTable->setPublished($row[TB_News::PublishedColumnC ]);
                }
            }

            }else{
               $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
               $theResult[MSG_ERROR] = "The Key has not been found.";
               $logger->warn($theResult[MSG_ERROR]);
               break;
            }
         }
         $logger->trace("Update the data in the database");
         if ( ! $theTable->update()){
            $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
            $theResult[MSG_ERROR] = $theTable->getStrError();
            $logger->error("The update failed. Error [ " . $theResult[MSG_ERROR] . " ]");
         }
      $logger->trace("Exit");
   }

   function insertData($theTable, $theData, &$theResult){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Insert data: [ ".json_encode($theData)." ]");
      $logger->trace("Into [ " . $theTable->getTableName() ." ]");

      if (strcmp($theTable->getTableName(),TB_User::TB_UserTableC) == 0){

         //Declare variables
         $varPassword = $theData["Password"];
         $varNombre = $theData["Nombre"];
         $varApellidos = $theData["Apellidos"];

         $newId = $theTable->insert($varPassword
                                ,$varNombre
                                ,$varApellidos
                                );
      }

      if (strcmp($theTable->getTableName(),TB_Activity::TB_ActivityTableC) == 0){

         //Declare variables
         $varNombre = $theData["Nombre"];
         $varColor = $theData["Color"];
         $varImage = $theData["Image"];

         $newId = $theTable->insert($varNombre
                                ,$varColor
                                ,$varImage
                                );
      }

      if (strcmp($theTable->getTableName(),TB_Timetable::TB_TimetableTableC) == 0){

         //Declare variables
         $varName = $theData["Name"];
         $varDetail = $theData["Detail"];

         $newId = $theTable->insert($varName
                                ,$varDetail
                                );
      }

      if (strcmp($theTable->getTableName(),TB_News::TB_NewsTableC) == 0){

         //Declare variables
         $varDateTime = $theData["DateTime"];
         $varTitle = $theData["Title"];
         $varNew = $theData["New"];
         $varPublished = $theData["Published"];

         $newId = $theTable->insert($varDateTime
                                ,$varTitle
                                ,$varNew
                                ,$varPublished
                                );
      }

      if( $newId != -1){
           $logger->trace("The insertion was exectuted successfully. ".
                           "The new Id is [ $newId ]");
           $theResult[RETURN_LAST_ID]=$newId;
        }else{
           $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
           $theResult[MSG_ERROR] = $theTable->getStrError();
           $logger->error("The insert failed. Error [ " . $theResult[MSG_ERROR] . " ]");
        }
      $logger->trace("Exit");
   }

   function delete($theTable, $theData, &$theResult){
      global $logger;
      $logger->trace("Enter");
      $jsonKey = $theData[PARAM_KEY];
      $logger->trace("Delete from table ".$theTable->getTableName().
                    " with key [ ".json_encode($jsonKey)." ]");

      if (strcmp($theTable->getTableName(),TB_User::TB_UserTableC) == 0){
         $composedKey = array();
         $composedKey["Usuario"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_Activity::TB_ActivityTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_Timetable::TB_TimetableTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }

      if (strcmp($theTable->getTableName(),TB_News::TB_NewsTableC) == 0){
         $composedKey = array();
         $composedKey["Id"] = json_encode($jsonKey);
         $logger->trace("Order table [ ".$theTable->getTableName().
                  " ] with key [ " . json_encode($composedKey). " ]");
          $theTable->searchByKey($composedKey);
      }
      $logger->trace("Delete data in the database");
      if (! $theTable->delete()){
         $theResult[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
         $theResult[MSG_ERROR] = $theTable->getStrError();
         $logger->error("The delete failed. Error [ " . $theResult[MSG_ERROR] . " ]");
      }
      $logger->trace("Exit");
   }

   function selectData($theTable, $theData, &$theResult){
      global $logger;
      $logger->trace("Enter");
      $logger->trace("Select data from  [ " . $theTable->getTableName() ." ]");
      $logger->trace("with params: [ ".json_encode($theData)." ]");
      if (isset($theData[PARAM_SEARCH_BY])){
         $logger->trace("Search by column [ ".
                                  $theData[PARAM_SEARCH_BY][PARAM_SEARCH_COLUMN] .
                                  " ] value [ " .
                                  $theData[PARAM_SEARCH_BY][PARAM_SEARCH_VALUE] . 
                                   " ]");
         if (! $theTable->searchByColumn($theData[PARAM_SEARCH_BY][PARAM_SEARCH_COLUMN],
                                     $theData[PARAM_SEARCH_BY][PARAM_SEARCH_VALUE])){
            $logger->trace("The search has not had success");
            return;
         }
      }
      $numRows = 0;
      
      $skipRows = 0;
      if (isset($theData[PARAM_SKIP_ROWS])){
         $skipRows = $theData[PARAM_SKIP_ROWS];
      }
      if (isset($theData[PARAM_NUM_ROWS])){
         $numRows = $theData[PARAM_NUM_ROWS];
      }
      if ($numRows == 0){
         $numRows = $theTable->getCardinality() - $skipRows;
      }
      $theTable->skip($skipRows);

      $idx = 0;
      $theResult[PARAM_DATA] = array();
      while ($theTable->next() && $idx < $numRows){
         $rowData = array();

         if (strcmp($theTable->getTableName(),TB_User::TB_UserTableC) == 0){

             $rowData['Usuario'] = $theTable->getUsuario();
             $rowData['Password'] = $theTable->getPassword();
             $rowData['Nombre'] = $theTable->getNombre();
             $rowData['Apellidos'] = $theTable->getApellidos();
         }

         if (strcmp($theTable->getTableName(),TB_Activity::TB_ActivityTableC) == 0){

             $rowData['Id'] = $theTable->getId();
             $rowData['Nombre'] = $theTable->getNombre();
             $rowData['Color'] = $theTable->getColor();
             $rowData['Image'] = $theTable->getImage();
         }

         if (strcmp($theTable->getTableName(),TB_Timetable::TB_TimetableTableC) == 0){

             $rowData['Id'] = $theTable->getId();
             $rowData['Name'] = $theTable->getName();
             $rowData['Detail'] = $theTable->getDetail();
         }

         if (strcmp($theTable->getTableName(),TB_News::TB_NewsTableC) == 0){

             $rowData['Id'] = $theTable->getId();
             $rowData['DateTime'] = $theTable->getDateTime();
             $rowData['Title'] = $theTable->getTitle();
             $rowData['New'] = $theTable->getNew();
             $rowData['Published'] = $theTable->getPublished();
         }
         $logger->trace("Add row [ $idx ] [ " . json_encode($rowData) ." ]");
         $theResult[PARAM_DATA][strval($idx)] = $rowData;
         $idx++;
      }
      $logger->trace("Exit");
   }
   
   /******************* MAIN *********************************/

  
   $method = $_SERVER['REQUEST_METHOD'];
   
   if (count($_POST) > 0 || count($_GET) > 0){
      $logger = LoggerMgr::Instance()->getLogger("RequestFromWeb.php");
   

      $logger->info("A request [ $method ] has been received from web");
      $resultArray = array();
      $strCommand = null;
      $strParams = null;
      
      if ($method == "POST"){
         $strCommand = $_POST[COMMAND];
         $strParams = $_POST[PARAMS];
      }
      if ($method == "GET"){
         $strCommand = $_GET[COMMAND];
         $strParams = $_GET[PARAMS];
      }
      if (!isset ($strCommand ) || ! isset ($strParams)){
         $resultArray[RESULT_CODE] = RESULT_CODE_INTERNAL_ERROR;
         $resultArray[MSG_ERROR] = "Unmatched format request. Absence of param COMMAND or PARAMS";
         $logger->error(json_encode($resultArray));
         //$logger->error("Unmatched format request. Absence of param $COMMAND or $PARAMS");
            //print("ERROR 500. Unmatched format request. Absence of param $COMMAND or $PARAMS");
         
      }else{
         $resultArray[RESULT_CODE] = RESULT_CODE_SUCCESS;
         
         $logger->trace("The command is [ $strCommand ] and the params are [ $strParams ]");
         $params = json_decode($strParams, true);
         $table = getTable($params[PARAM_TABLE]);
         $logger->trace("The command parameter is [ $strCommand ]");
         $logger->trace("Open the table [ " .$table->getTableName(). " ]");
         $table->open();
      
         if (strcmp(strtoupper($strCommand), COMMAND_UPDATE) == 0){
            $logger->debug("It is a update command in table [ ". $table->getTableName() . " ]");
            updateData($table, $params[PARAM_ROWS],$resultArray);
         }
         if (strcmp(strtoupper($strCommand), COMMAND_INSERT) == 0){
            $logger->debug("It is a insert command in table [ ". $table->getTableName() . " ]");
            insertData($table, $params[PARAM_DATA], $resultArray);
         }
         if (strcmp(strtoupper($strCommand), COMMAND_DELETE) == 0){
            $logger->debug("It is a delete command in table [ ". $table->getTableName() . " ]");
            delete($table, $params[PARAM_DATA], $resultArray);
         }
         if (strcmp(strtoupper($strCommand), COMMAND_SELECT) == 0){
            $logger->debug("It is a select command in table [ " . $table->getTableName() . " ]");
            selectData($table, $params[PARAM_DATA], $resultArray);
         }
         if (isset($params[PARAM_DATA][ADD_TO_CALLBACK])){
            $resultArray[ADD_TO_CALLBACK] = $params[PARAM_DATA][ADD_TO_CALLBACK];
         }
         $logger->trace("The request has been processed. Result [ " . json_encode($resultArray) ." ]");
        
      }
      print(json_encode($resultArray));
   } 
   
?>