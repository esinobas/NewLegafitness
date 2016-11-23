<?php
/**
 * This file has the html code and javascript code to handle the blog
 */
if (! strpos ( get_include_path (), $_SERVER['DOCUMENT_ROOT'])) {
   set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
}

define("URL_REQUEST_FROM_WEB_C", "php/Database/Tables/RequestFromWeb.php");

include_once("php/Database/Tables/RequestFromWebConstants.php");
include_once("php/Database/Tables/TB_News.php");
$tbNews = new TB_News();
$tbNews->open();
?>

<div id="Blog-Container">
   <div id="Blog-Toolbar">
      <div id="Blog-Btn-New" class="Round-Corners-Button Blog-Button" title="Añadir nuevo post">Nuevo</div>
      <div id="Blog-Btn-Save" class="Round-Corners-Button Blog-Button" title="Guardar los cambios">Guardar</div>
      <div id="Blog-Btn-Delete" class="Round-Corners-Button Blog-Button" title="Borrar el post actual">Eliminar</div>
   </div>
   <div id="Blog-News">
      <div id="Blog-News-List-Container">
         
         <div id="Blog-News-List" class="ListBox">
         <?php while ($tbNews->next()){?>
            <div id="<?php print($tbNews->getId());?>" class="ListBoxItem">
               <?php print($tbNews->getTitle());?>
            </div>
         <?php }?>
         </div>
      </div>
      <div id="Blog-New">
         <!-- <div id="Blog-New-Title">
         </div>
         <div id="Blog-New-Published">
         </div>
         <div id="Blog-New-Data"> -->
         </div>
      </div>
   </div>
      <div id="Dialog-Remove-Blog" title="Borrar blog">
      ¿ Borrar la entrad del blog ?
      
   </div>
</div>
<script type="text/javascript">
   JSLogger.getInstance().registerLogger("Blog.php",JSLogger.levelsE.ERROR);

   var modifiedWithoutSaveM = false;
   //////////////////////////////////////////////////////////////////////////
   /**
    * Removes the blog post from the database and removes the html objects 
    * from the dashboard
    */
   function removeBlogPost(){
      JSLogger.getInstance().traceEnter();
      var postId = $('.ListBoxItemSelected').attr('id');

      var requestParams = {};
      requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_DELETE);?>";
      requestParams.<?php print(PARAMS);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_News::TB_NewsTableC);?>";
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
      
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_KEY);?> = parseInt(postId); 
      
      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");

      var response = sendSynAjaxRequestWithPost("<?php print(URL_REQUEST_FROM_WEB_C);?>", requestParams);
      JSLogger.getInstance().debug("Response [ " + JSON.stringify(response) +" ]");

      if (parseInt(JSON.parse(response)['ResultCode']) == 200){
         JSLogger.getInstance().debug("The blog post has been removed successfully");
         //Remove the html objects
         $('.ListBoxItemSelected').remove();
         $('#Blog-New').empty();
         modifiedWithoutSaveM = false;
      }else{
         JSLogger.getInstance().debug("An error has been produced when the blog post with id [ " + 
               postId + " ] was being removed. Error [ " + 
               JSON.parse(response)['ErrorMsg'] +" ]");
         showDialogError("Se ha producido un error, no se han podido borrar. [" + 
               JSON.parse(response)['ErrorMsg'] + " ]");
      }
      JSLogger.getInstance().traceExit();
   }
   /////////////////////////////////////////////////////// 
   /**
    * Shows a dialog to confirm the delete post of the blog
    */
   function showDialogRemoveBlogPost(){
      JSLogger.getInstance().traceEnter();
      $('#Dialog-Remove-Blog').dialog({
         modal: true,
         resizable: false,
         width: 'auto',
         buttons: [
                   {
                     text: 'OK', click: function(){
                        removeBlogPost();
                        $(this).dialog('close');}
                   },
                   { text: 'Cancelar', click: function(){$(this).dialog('close');}
                   }
                   ]
          });
      JSLogger.getInstance().traceExit();
   }

   /////////////////////////////////////////////////////////////////////////////
   /**
    * Gets News or Post data from the database
    *
    * @param theNewsId.
    *
    * @return the server response
    */
   function getNewsDataFromDDBB(theKey){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().debug("Get News data from DDBB for key [ " + theKey +
               " ]" );
      var requestParams = {};
      requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_SELECT);?>";
      requestParams.<?php print(PARAMS);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_News::TB_NewsTableC);?>";
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_COLUMN);?> = "<?php print(TB_News::IdColumnC);?>";
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(PARAM_SEARCH_BY);?>.<?php print(PARAM_SEARCH_VALUE);?> = parseInt(theKey);
      
      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");
      var response = sendSynAjaxRequestWithPost("<?php print(URL_REQUEST_FROM_WEB_C);?>", requestParams);
      JSLogger.getInstance().debug("Response [ " + JSON.stringify(response) +" ]");
      
      JSLogger.getInstance().traceExit();
      return response;
   }
   /////////////////////////////////////////////////////////////////
   /**
    * Handles the selected news from the list box. Gets data from the 
    * database and refresh the objects with the data.
    * 
    */
   function handleSelectedNews(){
      JSLogger.getInstance().traceEnter();
      var id = $('.ListBoxItemSelected').attr('id');
      JSLogger.getInstance().debug("Handling News data from DDBB for key [ " + id +
      " ]" );
      var response = getNewsDataFromDDBB(id);

      if (parseInt(JSON.parse(response)['ResultCode']) == 200){
         JSLogger.getInstance().debug("The news data with Id[ " + id +
               " ] has been loaded successfully");
         $('#Blog-New').empty();
         $('#Blog-New').append('<div id="Blog-Title-'+id+'" class="Blog-Title">'+
                        JSON.parse(response)['data'][0].Title+'</div>');
         $('#Blog-New').append('<div id="Blog-Published-'+id+'" class="Blog-Published"><input type="checkbox"'+
               ' name="Published-Post" value="No"'+
               (JSON.parse(response)['data'][0].Published == 1?"checked":"")+'>Publicado</div>');
         $('#Blog-New').append('<div id="Blog-Text-'+id+'" class="Blog-Text">'+
                        JSON.parse(response)['data'][0].New+'</div>');

         bindBlogObjectsToTinyMCE(('#Blog-Title-'+id), ('#Blog-Text-'+id));
         modifiedWithoutSaveM = false;
         bindEventChange();
         
      }else{
         JSLogger.getInstance().error("The data has not been loaded. An error has been produced [ " +
               JSON.parse(response)['ErrorMsg'] +" ]");
         showDialogError("Se ha producido un error, no se han podido leer los datos. [" + 
               JSON.parse(response)['ErrorMsg'] + " ]");
      }
      JSLogger.getInstance().traceExit();
   }
   //////////////////////////////////////////////////////////////////////////
   /**
    * Asks when the changes hasn't been saved if they want to be saved.
    */
   function askSaveBeforeChange(){
      JSLogger.getInstance().traceEnter();
      functionToExecuteM = handleSelectedNews;
      showDialogExitWithoutSave();
      JSLogger.getInstance().traceExit();
   } 
   ////////////////////////////////////////////////////////////////////////
   /**
    * Adds more functionality to the News listbox items
    */
   function addFunctionalityListBoxItems(){
      JSLogger.getInstance().traceEnter();
      $('.ListBoxItem').click(function(){
         askSaveBeforeChange();
      });
      JSLogger.getInstance().traceExit();
   }
   
   ////////////////////////////////////////////////////////////////////////////////
   /**
    * Sends to the server the post datas for they be saved in data base
    * @param theId: The post indentifier, if it is null, the post is new.
    * @param theTitle: The Post title
    * @param theText: The Post text
    * @param thePublished: If the post is published or not.
    *
    * @return theRequestResponse The request sent from the server
    */
   function sendPostToServer(theId, theTitle, theText, thePublished){
      JSLogger.getInstance().traceEnter();

      if (theId == null){
         JSLogger.getInstance().debug("The post is new");
      }else{
         JSLogger.getInstance().trace("The post now exists");
      }
      var requestParams = {};

      if (theId == null){
         requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_INSERT);?>";
      }else{
         requestParams.<?php print(COMMAND);?> = "<?php print(COMMAND_UPDATE);?>";
         
      }
      requestParams.<?php print(PARAMS);?> = {};
      requestParams.<?php print(PARAMS);?>.<?php print(PARAM_TABLE);?> = "<?php print(TB_News::TB_NewsTableC);?>";

      if (theId == null){
         //It is a new post in the blog
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_News::TitleColumnC)?> = encodeURIComponent(theTitle.replace(/\"/g,"\\\""));
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_News::NewColumnC)?> = encodeURIComponent( theText.replace(/\"/g,"\\\""));
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_DATA);?>.<?php print(TB_News::PublishedColumnC)?> = thePublished;
      }else{
         //It is a update
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?> = {};
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(PARAM_KEY);?> = parseInt(theId);
       
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(TB_News::TitleColumnC);?> = encodeURIComponent(theTitle.replace(/\"/g,"\\\"")); 
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(TB_News::NewColumnC);?> = encodeURIComponent(theText.replace(/\"/g,"\\\"")); 
         requestParams.<?php print(PARAMS);?>.<?php print(PARAM_ROWS);?>.<?php print(PARAM_ROW)?>.<?php print(TB_News::PublishedColumnC)?> = thePublished;
      }

      JSLogger.getInstance().debug("Command parameters [ " + JSON.stringify(requestParams) +" ]");
      var response = sendSynAjaxRequestWithPost("<?php print(URL_REQUEST_FROM_WEB_C);?>", requestParams);
      JSLogger.getInstance().debug("Response [ " + JSON.stringify(response) +" ]");
     
      JSLogger.getInstance().traceExit();
      return response;
   }
   
   ////////////////////////////////////////
   /**
    * Saves the post in database and adds the post name in the list box
    */
   function savePostInDDBB(){
      JSLogger.getInstance().traceEnter();
      var postId = null;
      if ($('.Blog-Title').attr('id') != "Blog-New-Title"){
         if (selectedNewIdM == 0){
            postId = $('.ListBoxItemSelected').attr('id');
         }else{
            postId = selectedNewIdM;
         }
      }
      
      var response = sendPostToServer(postId,
                        $('.Blog-Title > p').html(), 
                        $('.Blog-Text').html(),
                        ($('.Blog-Published > input').is(':checked')?1:0));
      

      if (parseInt(JSON.parse(response)['ResultCode']) == 200){
         JSLogger.getInstance().debug("The post has been added sucessfully");
         modifiedWithoutSaveM = false;
         if (postId == null){
            //The post is new
            JSLogger.getInstance().trace("Add the Post in the listbox");
            $('.ListBoxItem').removeClass('ListBoxItemSelected');
            var newListItem = $('<div id="'+
                                       JSON.parse(response)['lastID'] + 
                           '" class="ListBoxItem ListBoxItemSelected">' +
                           $('.Blog-Title > p').html() +"</div>");
            $('#Blog-News-List').prepend(newListItem);
            //JSLogger.getInstance().trace("-> " + $('.Blog-Title > p').html());
            newListItem.click(function(){
               $(this).parent().find('.ListBoxItem').removeClass('ListBoxItemSelected');
               //$('.ListboxItem').removeClass('ListBoxItemSelected');
               $(this).addClass('ListBoxItemSelected');
            });
            
         }else{
            //The operation is an update, modified the listboxitem name
            //JSLogger.getInstance().trace(" -> #" + parseInt(selectedNewIdM));
            $('#' + parseInt(selectedNewIdM)).empty();
            $('#' + parseInt(selectedNewIdM)).append($('.Blog-Title > p').html());
         }
         showSaveSuccess();
      }else{
         JSLogger.getInstance().error("The datas has not been saved. An error has been produced [ " +
               JSON.parse(response)['ErrorMsg'] +" ]");
         showDialogError("Se ha producido un error, no se han podido guardar los cambios. [" + 
               JSON.parse(response)['ErrorMsg'] + " ]");
      }
      JSLogger.getInstance().traceExit();
   }
   ////////////////////////////////////////////////////////////////////////
   /**
    * Bind the title post and the text post to the TintyMCE
    *
    * @param theTitleObj The title object to bind
    * @param theTextObj The text object to bind
    */
   function bindBlogObjectsToTinyMCE(theTitleObj, theTextObj){
      JSLogger.getInstance().traceEnter();
      JSLogger.getInstance().trace("Title Selector [ " + theTitleObj +
            " ] Text Selector [ " + theTextObj + " ]");
      tinymce.init({
         selector: theTitleObj,
         theme: "modern",
         skin: "custom",
         inline: true,
         statusbar: false,
         entity_encoding : "raw",
         add_unload_trigger: false,
         schema: "html5",
         language: "es",
         //plugins: "textcolor",
         menubar: false,
         toolbar: false
         //toolbar: "bold italic underline | fontselect fontsizeselect | forecolor backcolor | alignleft aligncenter alignright alignjustify "
      });
      tinymce.init({
         selector: theTextObj,
         theme: "modern",
         skin: "custom",
         inline: true,
         statusbar: false,
         entity_encoding : "raw",
         add_unload_trigger: false,
         schema: "html5",
         language: "es",
         plugins: "textcolor advlist image imagetools link lists",
         menubar: false,
         //toolbar1: "formatselect | undo redo | bold italic underline | fontselect fontsizeselect | forecolor backcolor",
         toolbar1: "undo redo | bold italic underline | fontsizeselect | forecolor backcolor",
         toolbar2: "alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | cut copy paste | image link",
         file_browser_callback: RoxyFileBrowser
         
      });
      JSLogger.getInstance().traceExit();
   }

   /////////////////////////////////////////////////////////////////////////////
  function RoxyFileBrowser(field_name, url, type, win) {
  var roxyFileman = 'plugins/Roxy-Fileman/fileman/index.html';
  if (roxyFileman.indexOf("?") < 0) {     
    roxyFileman += "?type=" + type;   
  }
  else {
    roxyFileman += "&type=" + type;
  }
  roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
  if(tinyMCE.activeEditor.settings.language){
    roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
  }
  tinyMCE.activeEditor.windowManager.open({
     file: roxyFileman,
     title: 'Ficheros',
     width: 800, 
     height: 500,
     resizable: "yes",
     plugins: "media",
     inline: "yes",
     close_previous: "no"  
  }, {     window: win,     input: field_name    });
  return false; 
}

   ////////////////////////////////////////////////////////////////////////
   /**
    * Adds the html objects to the dashboard when a new post is created
    */
   function addNewPost(){
      JSLogger.getInstance().traceEnter();
      $('#Blog-New').empty();
      $('#Blog-New').append('<div id="Blog-New-Title" class="Blog-Title">Pulsa para escribir el título</div>');
      $('#Blog-New').append('<div id="Blog-New-Published" class="Blog-Published"><input type="checkbox" name="Published-Post" value="No">Publicado</div>');
      $('#Blog-New').append('<div id="Blog-New-Data" class="Blog-Text">Pulsa para escribir post</div>');

      bindBlogObjectsToTinyMCE('#Blog-New-Title', '#Blog-New-Data');
      modifiedWithoutSaveM = true;
      JSLogger.getInstance().traceExit();
   }
   ///////////////////////////////////////////////////////////////////////////////////////////////////////////
   /**
    * Binds the title object and the blog text object event change.
    * This event modified the variable modifiedWithoutSaveM, to be check before
    * the blog entry, and show a dialogbox says the data doesn't saved.
    */
   function bindEventChange(){
      JSLogger.getInstance().traceEnter();
      $('.Blog-Title').mousedown(function(){
         JSLogger.getInstance().traceEnter();
         selectedNewIdM = $('.ListBoxItemSelected').attr('id');
         modifiedWithoutSaveM = true;
         JSLogger.getInstance().traceExit();
      });
      $('.Blog-Published').change(function(){
         JSLogger.getInstance().traceEnter();
         modifiedWithoutSaveM = true;
         selectedNewIdM = $('.ListBoxItemSelected').attr('id');
         JSLogger.getInstance().traceExit();
      });
      $('.Blog-Text').mousedown(function(){
         
         JSLogger.getInstance().traceEnter();
         modifiedWithoutSaveM = true;
         selectedNewIdM = $('.ListBoxItemSelected').attr('id');
         JSLogger.getInstance().traceExit();
         
      });
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
                        savePostInDDBB();
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
   ///////////////////////////////////////////////////////////////////
   var functionToExecuteM = null; 
   var selectedNewIdM = 0;
   //Bind the functions to the buttons
   
   //Bind for new Post
   
   $('#Blog-Btn-New').click(function (){
            functionToExecuteM = addNewPost;
            showDialogExitWithoutSave();
   });
   //Bind for the save Post
   $('#Blog-Btn-Save').click(savePostInDDBB);
   //Bind for the remove post
   $('#Blog-Btn-Delete').click(showDialogRemoveBlogPost);

   //Inits the Post listbox
   ListBoxInit.execute();
   addFunctionalityListBoxItems();

   bindEventChange();
   
</script>