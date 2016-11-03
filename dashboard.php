<?php 
   session_start();
   define("URL_LOGOUT_C", "php/administrator/logout.php");
   define("URL_ADMIN_C", "php/administrator/");
   define("ACTIVITIES_C", "Activities.php");
   define("TIMETABLES_C", "Timetables.php");
   define("BLOG_C", "Blog.php");
   
   if (! strpos ( get_include_path (), $_SERVER['DOCUMENT_ROOT'])) {
      set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
   }
   
?>
<!DOCTYPE HTML>
   <head>
      <meta charset="utf-8">
      <meta name="description" content="Página Admon. del gimnasio Legafitness">
      
     <title>Admon. Legafitness</title>
      <!-- JQuery -->
      <script type="text/javascript" src="plugins/JQuery/jquery-3.1.0.min.js"></script>
         
      <!-- JQuery UI, custom to Legafitness -->
      <script type="text/javascript" src="plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.min.js"></script>
      <link rel="stylesheet" href="plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.min.css">
      <link rel="stylesheet" href="plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.structure.min.css">
      <link rel="stylesheet" href="plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.theme.min.css">
         

     <script type="text/javascript" src="js/JSLogger/JSLogger.js"></script>
     <script type="text/javascript" src="plugins/Ajax/Ajax.js"></script>
     <script type="text/javascript" src="js/GeneralLib.js"></script>
     <script type="text/javascript" src="plugins/ListBox/ListBoxInit.js"></script>
     <script type="text/javascript" src="plugins/TinyMCE/js/tinymce/tinymce.min.js"></script>
    
     <!--  DataEntry -->
     <script type="text/javascript" src="plugins/DataEntry/DataEntryFunctions.js"></script>
     <link rel="stylesheet" href="plugins/DataEntry/DataEntry.css"/>
     <link rel="stylesheet" href="styles/ButtonsStyles.css"/>
     <!--  <link rel="stylesheet" href="./styles/style.css"/> -->
     <link rel="stylesheet" href="plugins/Table/Table.css">
     <link rel="stylesheet" href="/plugins/ListBox/ListBox.css"> 
     <link rel="stylesheet" href="./styles/dashboard.css"/>

     
   </head>
   <body>
      <header>
         <div id="logo">
         </div>
         <div id="title">
            Panel de Administración
         </div>
         <div id="Logout">
            Usuario: <span class="Bold"><?php print($_SESSION['User'])?></span>
            <div id="Btn-Logout" class="Round-Corners-Button">Logout</div>
         </div>
      </header>
      <nav>
         <!--  In this part will be the menu -->
         <ul id="Dashboard-Menu">
            <li id="Dashboard-Menu-Actividades">Actividades</li>
            <li id="Dashboard-Menu-Horarios" class="SelectedMenu">Horarios</li>
            <li id="Dashboard-Menu-Blog">Blog</li>
         </ul>
      </nav>
      <section>
         <article>
            <?php include('php/administrator/Timetables.php')?>
         </article>
      </section>
      <footer>
      </footer>
      <div id="Dialog" title="">
         <div id="Dialog-Text"></div>
      </div>
      <div id="Dialog-Error" title="Error">
      </div>
      <div id="Dialog-Exit-Without-Save" title="No se han guardado los cambios">
         No se han guardado los cambios. ¿Quieres guardarlos ahora?
      </div>
      <!--  ///////////////////////////////////////////////////////// -->
      <!--  Script functions -->
      <script type="text/javascript">
         JSLogger.getInstance().registerLogger("Dashboard",JSLogger.levelsE.ERROR);

         /////////////////////////////////////////////////////////////////////////////////////////////////////////////
         /** 
          * Shows a dialog with the error description
          *
          * @param theErrorDesc: The error descrition is showed
          */
         function showDialogError(theErrorDesc){
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
         }
         ///////////////////////////////////////////////////////////////////////////////
         
         /**
          * Execute the dashboard logout
          */
         function logout(){
            JSLogger.getInstance().traceEnter();
            
            window.location.replace("<?php print(URL_LOGOUT_C);?>");
            JSLogger.getInstance().traceExit();
         }
        /////////////////////////////////////////////////
        /**
         * Clean the article web
         */
        function cleanArticle(){
           $('article').empty();
        }
        //////////////////////////////////////////////////////////////////////////
         /**
          * Modifies the css properties of the selected menu
          */
         function selectedMenu(theObject){
            JSLogger.getInstance().traceEnter();
            $("#Dashboard-Menu > li").removeClass("SelectedMenu");
            theObject.addClass("SelectedMenu");
            cleanArticle();
            var url = "<?php print(URL_ADMIN_C);?>";
            if (theObject.attr('id') == "Dashboard-Menu-Actividades"){
               url += "<?php print(ACTIVITIES_C)?>";
            }
            if(theObject.attr('id') == "Dashboard-Menu-Horarios"){
               url += "<?php print(TIMETABLES_C)?>";
            }
            if (theObject.attr('id') == "Dashboard-Menu-Blog"){
               url += "<?php print(BLOG_C);?>";
            }
            JSLogger.getInstance().debug("The url is  [ " + url + " ]");
            var requestParams = {};
            JSLogger.getInstance().debug("Params to send to server [ " + 
                  JSON.stringify(requestParams) + " ]");
            var response = sendSynAjaxRequestWithGet(url, null);
            JSLogger.getInstance().trace("Response [ " + 
                  response + " ]");
            $('article').append(response);
            JSLogger.getInstance().traceExit();
         }
       ////////////////////////////////////////////////////////////////////////
         //It is executed when the page has been loaded completly
         $(document).ready(function(){
         
            $("#Btn-Logout").click(logout);
            $("#Dashboard-Menu > li").click(function(){
               selectedMenu($(this));
            });
         });
      </script>
   </body>
</html>