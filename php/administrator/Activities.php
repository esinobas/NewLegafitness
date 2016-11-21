<?php
/**
 * This file has the html code and javascript code to handle the activities
 */
if (! strpos ( get_include_path (), $_SERVER['DOCUMENT_ROOT'])) {
   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
}

define("URL_REQUEST_FROM_WEB_C", "php/Database/Tables/RequestFromWeb.php");

include_once("php/Database/Tables/RequestFromWebConstants.php");
include_once("php/Database/Tables/TB_Activity.php");

$tbActivity = new TB_Activity();
$tbActivity->open();
?>

<div class="Table" id="Tabla-Actividades">
   <div id="Tabla-Actividades-Header" class="Table-Row Table-Header">
      <div id="Tabla-Actividades-Actividad" class="Table-Column Table-Column1-Width">
         Actividad
      </div>
      <div id="Tabla-Actividades-Color" class="Table-Column Table-Column2-Width">
         Color
      </div>
      <div id="Tabla-Actividades-Add" class="Table-Column Round-Corners-Button Table-Column3-Width">
         Nueva Actividad
      </div>
   </div>
   <?php 
      while ($tbActivity->next()){
         ?>
         <div id="Tabla-Actividad-<? print($tbActivity->getId());?>" class="Table-Row">
            <div class="Table-Column Table-Column1-Width">
               <?php print($tbActivity->getNombre());?>
            </div>
            <div class="Table-Column Table-Column2-Width">
               <div style="background-color:<?php print($tbActivity->getColor());?>;color:<?php print($tbActivity->getFontColor());?>;width:100%;height:100%;display:block;text-align:center">Color Texto<br></div>
            </div>
            <div id="Remove-Activity-Btn-<?php print($tbActivity->getId());?>" class="Table-Column Round-Corners-Button Table-Column3-Width Remove-Activity-Btn" data-id="<? print($tbActivity->getId());?>" data-activity-name="<?php print($tbActivity->getNombre());?>">
               Eliminar
            </div>
         </div>
         <?php 
      }
   ?>
</div>
<!-- Definition of new dialog activity -->
<div id="Dialog-New-Activity" title="Nueva Actividad">
   Nombre: <input id="Activity-Name" type="text" title="Nombre actividad">
   Color: <input id="Activity-Color" type="color" title="Color de la actividad">
   Color texto: <input id="Activity-Font-Color" type="color" title="Color del texto">
   <script type="text/javascript">
      $('#Activity-Font-Color').val("#ffffff");
   </script>
</div>
<!-- Definition of the remove activity dialog -->
<div id="Dialog-Remove-Activity" title="Borrar Actividad">
   <div style="display: block; min-width:20em">
      ¿ Seguro/a de borrar la actividad " <span id="Remove-Activity-Name" style="font-weight:bolder"></span> "?
   </div>
</div>

<!-- Bind the new Activity button with its funtion -->
<script type="text/javascript">
   JSLogger.getInstance().registerLogger("Activities.php",JSLogger.levelsE.TRACE);

   
   /////////////////////////////////////////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////
   /**
    * Function to binds the remove activity buttons to the function that shows
    *  a confirm dialog and removes the activity
    */
    $('.Remove-Activity-Btn').click(function(){
       var activityId = $(this).attr('data-id');
       var activityName = $(this).attr('data-activity-name');
       
       showRemoveActivityDialog(activityId,activityName, $(this).parent());
    });

   ////////////////////////////////////////////////////////////////////////////
   /**
    * Removes in the dashboard the activity that has been removed
    */
    
   //////////////////////////////////////////////////////////////////////////////////////////
   /**
    * Creates the structe for remove an activity
    *
    * @param theActivityId
    * @param theJQueryObject
    */
   function removeActivity(theActivityId, theJQueryObject){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("The activity Id is [ " + theActivityId +" ]");
      
      var requestParams = {};
      requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_DELETE);?>";
      requestParams.<?php print(PARAMS);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_Activity::TB_ActivityTableC);?>";
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
      
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_KEY);?> = parseInt(theActivityId); 
      
      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

      var response = sendSynAjaxRequestWithPost("<?php print(URL_REQUEST_FROM_WEB_C);?>", requestParams);
      JSLogger.getInstance().debug("Response [ " + JSON.stringify(response) +" ]");

      if (parseInt(JSON.parse(response)['ResultCode']) == 200){
         JSLogger.getInstance().debug("The activity has been removed successfully");
         theJQueryObject.remove();
      }else{
         JSLogger.getInstance().debug("An error has been produced when the activity with id [ " + 
               theActivityId + " ] was being removed. Error [ " + 
               JSON.parse(response)['ErrorMsg'] +" ]");
         $("#Dialog").attr('title', "Error");
         var msgError = "No se ha podido borrar la actividad."+
         ". Error [ " + JSON.parse(response)['ErrorMsg'] +" ]";
         $("#Dialog-Text").append(msgError);
         $('#Dialog').dialog({
            modal: true,
            resizable: false,
            buttons: [{
               text: 'OK', click: function(){$(this).dialog('close');}
            }]
         });
      }
      
      JSLogger.getInstance().traceExit();
   }
   //////////////////////////////////////////////////////////////////////////////
   /**
    * Function that show the remove activity dialog
    *
    * @param theActivityId
    * @param theActivityName
    * @param theJQueryObject that contains the activity to be removed
    */
   function showRemoveActivityDialog(theActivityId, theActivityName, theJQueryObject){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Show remove activity [ " + theActivityName + " ]");
      $("#Remove-Activity-Name").empty();
      $("#Remove-Activity-Name").append(theActivityName);
      $('#Dialog-Remove-Activity').dialog({
         modal: true,
         resizable: false,
         width: 'auto',
         buttons: [
                   {
                     text: 'OK', click: function(){
                        removeActivity(theActivityId,theJQueryObject);
                        $(this).dialog('close');}
                   },
                   { text: 'Cancelar', click: function(){$(this).dialog('close');}
                   }
                   ]
      });
      JSLogger.getInstance().traceExit();
   }
   ///////////////////////////////////////////////////////////////////////////
   /**
    * Function to add new activity in the web
    * 
    * @param theActivityId
    * @param theActivityName
    * @param theActivityColor
    * @oaram theActivityFontColor
    */
   function addActivityToTable(theActivityId, theActivityName, theActivityColor,
                              theActivityFontColor){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().debug("Add activity with params: Activity ID [ " + 
            theActivityId + " ], Activity Name [ " + theActivityName + 
            " ], Activity Color [ " + theActivityColor + " ] and Activity Font Color [ " +
            theActivityFontColor + " ]");
      var htmlToAppend = "<div id=\"Tabla-Actividad-"+theActivityId+"\" class=\"Table-Row\">";
      htmlToAppend += "<div class=\"Table-Column Table-Column1-Width\">";
      htmlToAppend += theActivityName;
      htmlToAppend += "</div>";
      htmlToAppend += "<div class=\"Table-Column Table-Column2-Width\">";
      htmlToAppend += "<div style=\"background-color:"+theActivityColor+";color:"+theActivityFontColor+";width:100%;height:100%;display:block;text-align:center\">Color Texto<br></div>";
      htmlToAppend += "</div>";
         htmlToAppend += "<div id=\"Remove-Activity-Btn-" + theActivityId +"\" class=\"Table-Column Round-Corners-Button Table-Column3-Width Remove-Activity-Btn\">";
      htmlToAppend += "Eliminar";
      htmlToAppend += "</div>";
      htmlToAppend += "</div>";
      JSLogger.getInstance().trace("Html to Add [ " + htmlToAppend +" ]");
      $('#Tabla-Actividades').append(htmlToAppend);
      var objectId = '#Remove-Activity-Btn-'+theActivityId;
      JSLogger.getInstance().trace("Binding click event to new button [ " + objectId + " ]");
      $(objectId).click(function(){
               showRemoveActivityDialog(theActivityId,theActivityName, $(this).parent());
      });
      JSLogger.getInstance().traceExit();
   }
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   /**
    * Function to send the activity data to the server
    *
    * @param theActivityName. String with the activity name
    * @param theActivityColor. String with the activity color in hexadecimal format
    * @param theActivityFontColor. String with the font color activity in hexadecimal format.
    */
   function sendActivityDataToServer(theActivityName, theActivityColor, theActivityFontColor){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().debug("theActivityName [ " + theActivityName +
            " ], theActiviyColor [ " + theActivityColor +" ] and theActivityFontColor [ "+
            theActivityFontColor + " ]");

      var requestParams = {};
      requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_INSERT);?>";
      requestParams.<?php print(PARAMS);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_Activity::TB_ActivityTableC);?>";
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_Activity::NombreColumnC)?> = encodeURIComponent(theActivityName.replace(/\"/g,"\\\""));
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_Activity::ColorColumnC)?> = encodeURIComponent(theActivityColor.replace(/\"/g,"\\\"")); 
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_Activity::FontColorColumnC)?> = encodeURIComponent(theActivityFontColor.replace(/\"/g,"\\\""));
            
      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");
      var response = sendSynAjaxRequestWithPost("<?php print(URL_REQUEST_FROM_WEB_C);?>", requestParams);
      JSLogger.getInstance().debug("Response [ " + JSON.stringify(response) +" ]");
      if (parseInt(JSON.parse(response)['ResultCode']) == 200){
         JSLogger.getInstance().debug("The activity [ " + theActivityName +
               " ] has been added successfully");
         addActivityToTable(parseInt(JSON.parse(response)['lastID']),theActivityName,
                         theActivityColor, theActivityFontColor);
      }else{
         JSLogger.getInstance().debug("An error has been produced when the activity [ " + 
               theActivityName + " ] was being added. Error [ " + 
               JSON.parse(response)['ErrorMsg'] +" ]");
         $("#Dialog").attr('title', "Error");
         var msgError = "No se ha insertado la actividad " + theActivityName +
         ". Error [ " + JSON.parse(response)['ErrorMsg'] +" ]";
         $("#Dialog-Text").append(msgError);
         $('#Dialog').dialog({
            modal: true,
            resizable: false,
            buttons: [{
               text: 'OK', click: function(){$(this).dialog('close');}
            }]
         });
      }
      $('#Activity-Name').val("");
      JSLogger.getInstance().traceExit();
   }
   //////////////////////////////////////////////////////////////
   /**
    * Funtion to get and sent the new activity data to the server
    */
   function getAndSendNewActivityData(){
      JSLogger.getInstance().traceEnter();
     
      var activityName = $('#Activity-Name').val();
      var activityColor = $('#Activity-Color').val();
      var activityFontColor = $('#Activity-Font-Color').val();
     
      JSLogger.getInstance().debug("The new activity name is [ " +
         activityName +" ] and its color is [ " +
         activityColor + " ] and the font color is [ " + 
         activityFontColor + " ] ");
        sendActivityDataToServer(activityName, activityColor, activityFontColor);
      JSLogger.getInstance().traceExit()
   }
   ////////////////////////////////////////////////////////////////////
   /**
    * Function to show the dialog
    */
   function showNewActivityDialog(){
      $('#Dialog-New-Activity').dialog({
         modal: true,
         resizable: false,
         width: 'auto',
         buttons: [{
            text: 'OK', click: function(){
                  getAndSendNewActivityData();
                  $(this).dialog('close');}
            },
            {
            text: 'Cancelar', click: function(){$(this).dialog('close');}
         }]
      });
   }
   /////////////////////////////////////////////////////////
   $('#Tabla-Actividades-Add').click(showNewActivityDialog);
</script>