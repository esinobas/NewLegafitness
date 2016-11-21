<?php
/**
 * This file has the html code and javascript code to handle the timetables
 */
if (! strpos ( get_include_path (), $_SERVER['DOCUMENT_ROOT'])) {
   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
}

define("URL_REQUEST_FROM_WEB_C", "php/Database/Tables/RequestFromWeb.php");

include_once("php/Database/Tables/RequestFromWebConstants.php");
include_once("php/Database/Tables/TB_Activity.php");
include_once("php/Database/Tables/TB_Timetable.php");

?>
<div id="Timetables-Container">
   <div id="Selected-Timetable">
      Horario
      <select id="Timetable-combobox">
      <?php 
      $tbTimetable = new TB_Timetable();
      $tbTimetable->open();
      while ($tbTimetable->next()){
         ?><option value="<?php print($tbTimetable->getId());?>" id="<?php print($tbTimetable->getId());?>">
         <?php print($tbTimetable->getName());?>
         </option>
      <?php 
      }
      ?>
      </select>
      <div id="New-Btn" class="Round-Corners-Button" title="Crear nuevo calendario">
         Nuevo
      </div>
      <div id="Save-Btn" class="Round-Corners-Button" title="Guardar calendario">
         Guardar
      </div>
   </div>
   
   <div id="Current-Timetable">
   </div>
   
   <div id="Dialog-New-Timetable" title="Nuevo Horario">
      Nombre: <input id="Timetable-Name" type="text" title="Nombre del Horario">
   </div>
   <div id="Dialog-Add-ActivityToDay" title="Añadir actividad">
      Actividad: <select>
     <?php
         $tbActivity = new TB_Activity();
         $tbActivity->open();
         while ($tbActivity->next()){
            ?>
            <option value="<?php print($tbActivity->getColor().";".$tbActivity->getFontColor());?>">
               <?php print($tbActivity->getNombre());?>
            </option>
      <?php 
         }
      ?>
      </select>
   </div>
   
   <div id="Dialog-Remove-ActivityToDay" title="Borrar actividad">
      ¿ Borrar la actividad ?
      
   </div>
   
   <!--  <div id="Dialog-Error" title="Error"> 
   </div> -->
   <!--  <div id="Dialog-Exit-Without-Save" title="No se han guardado los cambios">
      No se han guardado los cambios. ¿Quieres guardarlos ahora?
   </div> -->
   
   <div class="Timetable-Template">
      <div class="Timetable-Time">
         <div class="Timetable-Detailtime"><br></div>
         <?php for ($hour = 7; $hour < 23; $hour++){
         ?>
         <div class="Timetable-Detailtime">
            <div class="Timetable-Quarter"><?php print($hour)?>:00</div>
            
            <?php if ($hour<22){
               for ($quarter = 15; $quarter < 60; $quarter = $quarter + 15){?>
            <div class="Timetable-Quarter"><?php print($hour.":".$quarter);?></div>
            <?php }
            }?>
         </div>
         <?php
         }?>
      </div>
      <div class="Timetable-Day-Week Timetable-All-Day">
         Lunes
         <div class="Timetable-Day-Week Timetable-Day-Time Line-Right-Part">
         </div>
      </div>
      <div class="Timetable-Day-Week Timetable-All-Day">
         Martes
         <div class="Timetable-Day-Week Timetable-Day-Time Line-Right-Part">
         </div>
      </div>
      <div class="Timetable-Day-Week Timetable-All-Day">
         Miercoles
         <div class="Timetable-Day-Week Timetable-Day-Time Line-Right-Part">
         </div>
      </div>
      <div class="Timetable-Day-Week Timetable-All-Day">
         Jueves
      <div class="Timetable-Day-Week Timetable-Day-Time Line-Right-Part">
      </div>
      </div>
      <div class="Timetable-Day-Week Timetable-All-Day">
         Viernes
         <div class="Timetable-Day-Week Timetable-Day-Time Line-Right-Part">
         </div>
      </div>
      <div class="Timetable-Day-Week Timetable-All-Day">
         Sabado
         <div class="Timetable-Day-Week Timetable-Day-Time Line-Right-Part">
         </div>
      </div>
      <div class="Timetable-Day-Week Timetable-All-Day">
         Domingo
         <div class="Timetable-Day-Week Timetable-Day-Time ">
         </div>
      </div>
      
   </div>
</div>

<!--  /////////////////////////////////////////////////////////////// -->

<script type="text/javascript">
   JSLogger.getInstance().registerLogger("Timetables.php",JSLogger.levelsE.TRACE);
   
   var modifiedWithoutSaveM = false;
   /////////////////////////////////////////////////////// 
   /**
    * Removes the activity from the timetable
    *
    * theJQueryObj
    */
   function removeActiviyFromDay(theJQueryObj){
      JSLogger.getInstance().traceEnter();
      $('#Dialog-Remove-ActivityToDay').dialog({
         modal: true,
         resizable: false,
         width: 'auto',
         buttons: [
                   {
                     text: 'OK', click: function(){
                        theJQueryObj.remove();
                        modifiedWithoutSaveM = true;
                        $(this).dialog('close');}
                   },
                   { text: 'Cancelar', click: function(){$(this).dialog('close');}
                   }
                   ]
          });
      JSLogger.getInstance().traceExit();
   }
   /////////////////////////////////////////////
   /**
    * Modifies the start time and finish time of the an activity
    *
    * theObject The ui resizable paremeter 
    */
   function updateStartFinishActivity(theObject){
      JSLogger.getInstance().traceEnter();
      var top = theObject.position.top;
      JSLogger.getInstance().trace("The object top [ "  + top +" ]");
      var hour = Math.floor(top / ( 22 * 4 )) + 7;
      var minutes = Math.floor((top % (22 * 4)) / 22);
      minutes = minutes * 15; 
      var startTime = hour +":"+ (parseInt(minutes)<10?"0":"") + minutes;
      JSLogger.getInstance().trace("Start Time [ " + startTime +" ]");
      var height = parseInt(top) + theObject.size.height;
      JSLogger.getInstance().trace("The object height [ "  + height +" ]");
      hour = Math.floor(height / ( 22 * 4 )) + 7;
      minutes = Math.floor((height % (22 * 4)) / 22);
      minutes = minutes * 15; 
      var finishTime = hour + ":"+ (parseInt(minutes)<10?"0":"") + minutes;
      JSLogger.getInstance().trace("Finish Time [ " + finishTime +" ]");
      var time = $('<div class="Activity-Time">De ' + startTime +
            ' a ' + finishTime + '</div>');
      theObject.element.find('.Activity-Time').remove();
      theObject.element.append(time);
      height = (theObject.size.height - 36) / 2;
      if (height > 0){
         theObject.element.css('padding-top', height+'px');
      }

      modifiedWithoutSaveM = true;

      JSLogger.getInstance().traceExit();
    
   }
   ///////////////////////////////////////////////////////////////////
   /**
    * Insert in the correspoding day the activiy in its start hour.
    *
    * @param theJQueryObj
    * @param theActivityNane
    * @param theActivityColor
    * @param theOffsetY
    */
   function addActivityInDay(theJQueryObj, theActivityName, theActivityColor, theOffsetY){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().debug("Add activity [ " + theActivityName + 
                  " ] with color [ " + theActivityColor + " ] in Y position [" +
                  theOffsetY + " ]");
      var fontColor = theActivityColor.substr(theActivityColor.indexOf(";")+1, 
            theActivityColor.length - theActivityColor.indexOf(";"));
      theActivityColor = theActivityColor.substr(0 , theActivityColor.indexOf(";"));
      JSLogger.getInstance().debug("Font Color [ " + fontColor + " ], background color [ " +
            theActivityColor + " ] ");
      var newActivity = $("<div class=\"Activity-Detail\" style=\"background-color:"+theActivityColor +
      ";color:"+fontColor+"\"><div>"+theActivityName+"</div></div>");
      //JSLogger.getInstance().debug("New html object [ " + newActivity + " ]");
      theJQueryObj.append(newActivity);
      JSLogger.getInstance().trace("parseInt(theOffsetY) / 22 = " + Math.round(parseInt(theOffsetY) / 22));
      var top = Math.round(parseInt(theOffsetY) / 22) * 22;
      var maxHeight = 1320 - top;
      JSLogger.getInstance().trace("Top : " + top);
      top += theJQueryObj.offset().top;
      JSLogger.getInstance().trace("Final Top : " + top);
      newActivity.offset({top: top});
      JSLogger.getInstance().trace("New Activity Max Henight [ " + maxHeight + " ]");
      newActivity.resizable({
            maxWidth: 109,
            maxHeight: maxHeight,
            minWidth: 109,
            minHeight: 22,
            grid: 22,
            resize: function( event, ui ) {
               updateStartFinishActivity(ui);
            }
      });
      
      newActivity.dblclick(function(theEvent){
         theEvent.stopPropagation();
         removeActiviyFromDay($(this));
      });
      modifiedWithoutSaveM = true;
      JSLogger.getInstance().traceExit();
      
   }
   /////////////////////////////////////////////////////////////////////////////////////////
   /**
    * Bind the double click event to the  time tables days
    *
    * @param theTimetableObject in JQuery format
    */
   function bindDoubleClickTimtableDays(theTimetableObject){
      JSLogger.getInstance().traceEnter();
      
      theTimetableObject.find('.Timetable-Day-Time').dblclick(
        function(e){
           
           var parentOffset = $(this).parent().offset(); 
           //or $(this).offset(); if you really just want the current element's offset
           
           var relY = e.pageY - $(this).offset().top;
           var jqueryObject = $(this);
           $('#Dialog-Add-ActivityToDay').dialog({
           modal: true,
           resizable: false,
           width: 'auto',
           buttons: [
                     {
                       text: 'OK', click: function(){
                          addActivityInDay(jqueryObject, 
                                $('#Dialog-Add-ActivityToDay select option:selected').text(),
                                $('#Dialog-Add-ActivityToDay select option:selected').val(),
                                relY);
                          $(this).dialog('close');}
                     },
                     { text: 'Cancelar', click: function(){$(this).dialog('close');}
                     }
                     ]
            });
        });
      JSLogger.getInstance().traceExit();
   }
   ////////////////////////////////////////////////////////////////
   /**
    * Add the html objects to create a editable timetable
    */
   function addHtmlTimetable(){
      JSLogger.getInstance().traceEnter();
      
      
      bindDoubleClickTimtableDays($(".Timetable-Template"));

      $(".Timetable-Template").clone(true).appendTo('#Current-Timetable');
      $("#Current-Timetable").find(".Timetable-Template").removeClass('Timetable-Template');
      JSLogger.getInstance().traceExit();
   }
   /////////////////////////////////////////////////////////////////////////////
   /**
    * Inserts in the Timetable-combobox the new inserted timetable name
    *
    * @param theTimtableNamme
    */
   function addNewTimetableNameInCombo(theTimetableName){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().debug("The new timetable name [ " + 
            theTimetableName + " ]");
      var add = $('<option value="New" id="New" selected>'+theTimetableName+"</option>");
      $('#Timetable-combobox').append(add);
      currentTimetableIdM = 0;
      $('#Current-Timetable').empty();
      addHtmlTimetable();
      modifiedWithoutSaveM = true;
      JSLogger.getInstance().traceExit();
   }
   /////////////////////////////////////////////////////
   /**
    * Shows the dialog to enter the new timetable name
    */
   function ShowNewTimetableDialog(){
      $("#Timetable-Name").empty();
      $('#Dialog-New-Timetable').dialog({
         modal: true,
         resizable: false,
         width: 'auto',
         buttons: [
                   {
                     text: 'OK', click: function(){
                        addNewTimetableNameInCombo($('#Timetable-Name').val());
                        $(this).dialog('close');}
                   },
                   { text: 'Cancelar', click: function(){$(this).dialog('close');}
                   }
                   ]
      });
   }
   /////////////////////////////////////////////////////////////////////////////////////////////////////////////
   /** 
    * Shows a dialog with the error description
    *
    * @param theErrorDesc: The error descrition is showed
    */
   /*function showDialogError(theErrorDesc){
      $('#Dialog-Error').empty();
      $('#Dialog-Error').append(theErrorDesc);
      $('#Dialog-Error').dialog({
         modal: true,
         resizable: false,
         width: 'auto',
         buttons: [
                   {
                     text: 'OK', click: function(){
                                 $(this).dialog('close');}
                   }]
      });
   }*/
   ///////////////////////////////////////////////////////////////////////
   /**
    * Saves in a object with JSON format the Timetable data
    *
    * @return a JSON with the timetable data
    */
   function saveTimetableInJSON(){
      JSLogger.getInstance().traceEnter();
      var timetableDayWeekArray = $('#Current-Timetable .Timetable-All-Day');
      var activitiesJSON = {};
      for (var idxDay = 0; idxDay < timetableDayWeekArray.length; idxDay ++){
         JSLogger.getInstance().trace("idxDay [ " + 
               idxDay + " ] getting its activities");
         activitiesJSON[idxDay] = {};
         var dayActivities = $(timetableDayWeekArray.get(idxDay));
         for ( var idxActivity = 0; 
                  idxActivity < dayActivities.find('.Activity-Detail').length;
                  idxActivity++ ){
            var activityDetail = $(dayActivities.find('.Activity-Detail').get(idxActivity));
            activitiesJSON[idxDay][idxActivity] = {};
            activitiesJSON[idxDay][idxActivity].activityName = $(activityDetail.find('div').get(0)).text().replace(/\n/g,'').trim();
            activitiesJSON[idxDay][idxActivity].activityColor = activityDetail.css('background-color');
            activitiesJSON[idxDay][idxActivity].activityFontColor = activityDetail.css('color');
            activitiesJSON[idxDay][idxActivity].activityTime = $(activityDetail.find('.Activity-Time')).text().replace(/\n/g,'').trim();
            activitiesJSON[idxDay][idxActivity].activityStart = (activityDetail.offset().top - activityDetail.parent().offset().top)/22;
            activitiesJSON[idxDay][idxActivity].activityDuration = parseInt(activityDetail.css('height'))/22;
         }

      }
     // JSLogger.getInstance().debug("The activities JSON [ " + 
     //       JSON.stringify(activitiesJSON) + " ]");
      JSLogger.getInstance().traceExit();
      return activitiesJSON
   }
   //////////////////////////////////////////////////////////////////////////////////77
   /**
    * Saves the Timetable data in data base
    */
   function savesTimetableData(){
       JSLogger.getInstance().traceEnter();
       var jsonTimetable = saveTimetableInJSON();
       
       var timetableData = {};
       //var isNew = $('#Timetable-combobox option:selected').attr('id') == 'New';
       var  isNew = currentTimetableIdM == 0;
       if ( ! isNew ) {
          //timetableData.id= $('#Timetable-combobox option:selected').val();
          timetableData.id = currentTimetableIdM;
          timetableData.timetableName = currentTimetableNameM;
       }else{
          timetableData.timetableName = $('#Timetable-combobox option:selected').text().replace(/\n/g,'').trim();
          JSLogger.getInstance().trace("-> " + $('#Timetable-combobox option:selected').text());
       }
       timetableData.detail = jsonTimetable;

       JSLogger.getInstance().debug("The timetable JSON [ " + 
             JSON.stringify(timetableData) + " ]");
       var requestParams = {};
       if (isNew){
          requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_INSERT);?>";
       }else{
          requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_UPDATE);?>";
          
       }
       requestParams.<?php print(PARAMS);?> = {};
       requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_Timetable::TB_TimetableTableC);?>";
       if (isNew){
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_Timetable::NameColumnC)?> = encodeURIComponent(timetableData['timetableName'].replace(/\"/g,"\\\""));
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_Timetable::DetailColumnC)?> = encodeURIComponent( JSON.stringify(timetableData).replace(/\"/g,"\\\""));
       }else{
          JSLogger.getInstance().trace("Updata timetable with id [ " + timetableData['id'] + 
                " ] and name [" + timetableData['timetableName'] + " ]");
          requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?> = {};
          requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW);?> = {};
          requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW);?>.<?php print(PARAM_KEY);?> = parseInt(timetableData['id']);
          requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW);?>.<?php print(TB_Timetable::DetailColumnC)?> = encodeURIComponent( JSON.stringify(timetableData).replace(/\"/g,"\\\""));
          
       }
     
       JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");
   
       var response = sendSynAjaxRequestWithPost("<?php print(URL_REQUEST_FROM_WEB_C);?>", requestParams);
       JSLogger.getInstance().debug("Response [ " + JSON.stringify(response) +" ]");
       if (parseInt(JSON.parse(response)['ResultCode']) == 200){
          if ( isNew ){
             JSLogger.getInstance().debug("The timetable [ " + timetableData['timetableName'] +
                " ] has been added successfully");
            
           
             $('#Timetable-combobox option:selected').attr('id',JSON.parse(response)['lastID']);
             $('#Timetable-combobox option:selected').val(JSON.parse(response)['lastID']);
          }else{
             JSLogger.getInstance().debug("The timetable [ " + timetableData['timetableName'] +
             " ] has been updated successfully");

             modifiedWithoutSaveM = false;
          }
          showSaveSuccess();
       }else{
            JSLogger.getInstance().error("The Timetable data has not been saved. An error has been produced [ " +
                        JSON.parse(response)['ErrorMsg'] +" ]");
            showDialogError("Se ha producido un error, no se han podido guardar los cambios. [" + 
                  JSON.parse(response)['ErrorMsg'] + " ]");
       }
       JSLogger.getInstance().traceExit();
   }
   /////////////////////////////////////////////////////// 
   /**
    * Shows a dialog when the user wants to of the current screen and the
    * changes have not been saved.
    * If the data are not modified, the flow continues.
    *
    */
   function showDialogExitWithoutSave(){
      JSLogger.getInstance().traceEnter();
      if (modifiedWithoutSaveM){
         $('#Dialog-Exit-Without-Save').dialog({
            modal: true,
            resizable: false,
            width: 'auto',
            buttons: [
                   {
                     text: 'OK', click: function(){
                        savesTimetableData();
                        functionToExecuteM();
                        $(this).dialog('close');}
                   },
                   { text: 'Cancelar', click: function(){
                      functionToExecuteM();
                      $(this).dialog('close');}
                   }
                   ]
          });
      }else{
         functionToExecuteM();
      }
      JSLogger.getInstance().traceExit();
   }
   ////////////////////////////////////////////////////////////////////////////////////**
   /**
    * Gets the timetable detail and adds the activities in the current timetable
    *
    * @param theJsonTimetableDetail
    */
   function addActivitiesFromTimetableDetail(theJsonTimetableDetail){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Timetable detail [ " + 
            JSON.stringify(theJsonTimetableDetail) +" ]");
      var timeTableDetail = theJsonTimetableDetail['detail'];

      JSLogger.getInstance().debug("Detail [ " + JSON.stringify(timeTableDetail) +" ]");

      //Get days of week Monday = 0;
      for (var day = 0; day < 7; day++){
         JSLogger.getInstance().trace("Get activities for day [ " + day +" ]");
         var activityList = timeTableDetail[day];
         JSLogger.getInstance().debug("Activity list for day [ " + day + 
               " ] -> [ " + JSON.stringify(activityList) + " ]"); 
         JSLogger.getInstance().debug("The day [ " + day + " ] has [ " +
               Object.keys(activityList).length + " ] activities.");
         for (var actKey in  Object.keys(activityList)){
            var activityData = activityList[actKey];
            JSLogger.getInstance().debug("Add activity [ " + 
                  activityData.activityName + " ] in day [ " + day +" ]");
            var activityName = activityData.activityName;
            var activityColor = activityData.activityColor;
            var activityFontColor = activityData.activityFontColor;
            var activityTime = activityData.activityTime;
            var activityStart = parseInt(activityData.activityStart);
            var activityDuration = parseInt(activityData.activityDuration);

            var objDay = $($('#Current-Timetable .Timetable-Day-Time').get(day));

            //Create the JQuery object with de activity data to add in the day
            
            var jqueryActivity = $('<div class="Activity-Detail" '+
                       'style="background-color:' + activityColor + ';'+
                       'color:' + activityFontColor + ';' +
                       'top:' + (activityStart * 22) + 'px;'+
                       'height:'+ (activityDuration * 22) + 'px">'+
                       '<div>'+activityName+'</div>'+
                       '<div class="Activity-Time">'+activityTime+
                       '</div></div>');
            JSLogger.getInstance().trace("New activity to Add [ " + 
                  '<div class="Activity-Detail" '+
                  'style="background-color:' + activityColor + ';'+
                  'top:' + (activityStart) + 'px;'+
                  'height:'+ (activityDuration * 22) + 'px">'+
                  '<div>'+activityName+'</div>'+
                  '<div class="Activity-Time">'+activityTime+
                  '</div></div>' +" ]"); 
            height = (jqueryActivity.height() - 36) / 2;
            
            if (height > 0){
               jqueryActivity.css('padding-top', height+'px');
            }

            jqueryActivity.resizable({
               maxWidth: 109,
               maxHeight: 1256,
               minWidth: 109,
               minHeight: 22,
               grid: 22,
               resize: function( event, ui ) {
                  updateStartFinishActivity(ui);
               }
            });
            jqueryActivity.dblclick(function(theEvent){
               theEvent.stopPropagation();
               removeActiviyFromDay($(this));
            });
            objDay.append(jqueryActivity);
           
            
         }
      }
      JSLogger.getInstance().traceExit();
   }
   
   /////////////////////////////////////////////////////////////////////////
   /**
    * Reads from the database the selected timetable and show the timetable
    */
   function refreshTimetableFromDatabase(){
      JSLogger.getInstance().traceEnter();
      modifiedWithoutSaveM = false;
      $('#Current-Timetable').empty();

      if ($('#Timetable-combobox option').length == 0){
         JSLogger.getInstance().warn("There is not timetable, exit");
         JSLogger.getInstance().traceExit();
         return;
      }
      addHtmlTimetable();

      currentTimetableIdM = parseInt($('#Timetable-combobox option:selected').attr('id'));
      currentTimetableNameM = $('#Timetable-combobox option:selected').text().replace(/\n/g,'').trim();
      
      var timetableId = $('#Timetable-combobox option:selected').attr('id');
      var timetableName = $('#Timetable-combobox option:selected').text().replace(/\n/g,'').trim();
      JSLogger.getInstance().debug("Get timetable data [ " + 
            timetableName +
            " ] with Id [ " + timetableId + " ]");
      
      var requestParams = {};
      requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_SELECT);?>";
      requestParams.<?php print(PARAMS);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_Timetable::TB_TimetableTableC);?>";
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_COLUMN);?> = "<?php print(TB_Timetable::IdColumnC);?>";
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_VALUE);?> = timetableId;

      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

      var response = sendSynAjaxRequestWithPost("<?php print(URL_REQUEST_FROM_WEB_C);?>", requestParams);
      JSLogger.getInstance().debug("Response [ " + JSON.stringify(response) +" ]");

      if (parseInt(JSON.parse(response)['ResultCode']) == 200){
         JSLogger.getInstance().debug("The timetable data [ " + timetableName +
               " ] has been loaded successfully");
         var rows = JSON.parse(response)['data'];
         addActivitiesFromTimetableDetail(JSON.parse(JSON.parse(response)['data'][0].Detail));
         //for (var row in rows){
         //   addActivitiesFromTimetableDetail(rows[row].Detail);
         //}
         
         
      }
      JSLogger.getInstance().traceExit();
   }
    //////////////////////////////////////////////////////////////
    var functionToExecuteM = null;
    var currentTimetableIdM = 0;
    var currentTimetableNameM = "";
   // Bind the function showNewTimetableDialog to the button New-btn
   $('#New-Btn').click(ShowNewTimetableDialog);
   // Bind the function saveTimetable
   $('#Save-Btn').click(savesTimetableData);
   // Bind the function refreshTimatableFromDatabase to the select onChange event
   $('#Timetable-combobox').change(function(){functionToExecuteM = refreshTimetableFromDatabase;
                                                showDialogExitWithoutSave()});
   $('#Timetable-combobox').change();
</script>