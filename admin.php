<?php 
   session_start();
   //Constant with the URL and the script name where the login is done
   define("URL_DASHBOARD_C", "dashboard");
   define("URL_C", "admin.php");
   define("COOKIE_USER_C", "User");
   
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
    
     <!--  DataEntry -->
     <script type="text/javascript" src="plugins/DataEntry/DataEntryFunctions.js"></script>
     <link rel="stylesheet" href="plugins/DataEntry/DataEntry.css"/>
     <link rel="stylesheet" href="styles/ButtonsStyles.css"/>
     <link rel="stylesheet" href="./styles/style.css"/>
     
     <!-- Cryptography Library -->
     <script type="text/javascript" src="plugins/JSEncript/jsencrypt.min.js"></script>
   </head>
   <body>

      <?php 
         global $error;
         $error = false;
         if (isset($_POST['user']) && isset($_POST['pwd'])){
            require_once('php/administrator/Login.php');
            if ($error){
               $codeResult = $resultArray[RESULT_CODE_C];
               $errorText ="";
               if ($codeResult == RESULT_USER_NO_EXITS){
                  $errorText = "El usuario no existe";
               }
               if ($codeResult == RESULT_PWD_NO_MATCH){
                  $errorText = "La contraseña es incorrecta";
               }
               if ($codeResult == RESULT_ERROR_DESCRYPT){
                  $errorText = "Se ha producido un error al descencriptar la contraseña";
               }
               
            }else{
               $_SESSION[COOKIE_USER_C] = $_POST['user'];
               ?>
                  <script type="text/javascript">
                     window.location.replace("<?php print(URL_DASHBOARD_C);?>");
                  </script>
               <?php 
            }
         }
      ?>
      <section id="Login-Admin" class="Main-Article Orange-Article">
         <h1>Administración de</h1>
         <div id='logo'>
         </div>
         <form id="Formulario" action="<?php print(URL_C);?>" method="post">
         <div id="Form-Data-Login" class="DataEntryContainer" style="margin-left: -55px;padding-top: 145px;">
            <div class="DataEntryRow">
               <div class="DataEntryLabel" id="User">
                  Usuario:
               </div>
               <div class="DataEntryValue" id="User-Value">
                  <input type="text" name="user">
               </div>
            </div>
            <div class="DataEntryRow">
               <div class="DataEntryLabel" id="Password">
                  Password:
               </div>
               <div class="DataEntryValue" id="Password-Value">
                  <input type="password" name="pwd">
               </div>
            </div>
            
         </div>
         </form>
         <div class="DataEntryButtonsContainer" style="padding-left:325px">
            <div class="Round-Corners-Button DataEntryWindowButtonOk" id="Button-Contact">Entrar</div>
        </div>
        
      </section>
      <div id="Dialog" title="DialogTitle">
         <p id="Dialog-Text" style="text-align: center"></p>
      </div>
      
       
      <script type="text/javascript">
        JSLogger.getInstance().registerLogger("Admin",JSLogger.levelsE.TRACE);

         function showError(theError){
            JSLogger.getInstance().traceEnter();
            $('#Dialog').attr('title', "Error");
            $('#Dialog-Text').empty();
            $('#Dialog-Text').append("No se ha podido entrar en el sistema. Error [ " +
                      theError+ " ]");
            $('#Dialog').dialog({
               modal: true,
               resizable: false,
               buttons: [{
                  text: 'OK', click: function(){$(this).dialog('close');}
               }]
            });
            JSLogger.getInstance().traceExit();
         }
         
         //Define the function to send the login data to the server
         function sendDataToLogin(){
            JSLogger.getInstance().traceEnter();
  
            var publicKey = "-----BEGIN PUBLIC KEY-----\
               MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDZ9jcfPDWiO9iAafJc3xa1Og/+\
               sZb33yHeqbJu8RzBe2L7DL9++JNCs4vrJ9b6TjjFJRzVDDxA4hQHttLLGZgvjqsQ\
               LHYJN+uA3vPd8L773LPP+gLRRMyIsTi+1WA1SRUbGHSCXG1r8NeANZ9r4V2hRH0i\
               CEH0nIdxV76FkQv3SQIDAQAB\
               -----END PUBLIC KEY-----";
            
            var dataLogin = DataEntryFunctions.getValues('#Form-Data-Login');
            JSLogger.getInstance().trace("Data Login [ " + dataLogin + " ]");
            var encrypt = new JSEncrypt();

            JSLogger.getInstance().trace("Public Key [ " + publicKey + " ] ");
            encrypt.setPublicKey(publicKey);
            var encryptedPwd = encrypt.encrypt(JSON.parse(dataLogin)['Password']);
            JSLogger.getInstance().trace("Pwd [ " + JSON.parse(dataLogin)['Password'] +
                        " ] -> Encrypted -> [ " + encryptedPwd + " ]");
            requestParameters = {};
            requestParameters.user = encodeURIComponent(JSON.parse(dataLogin)['User']);
            requestParameters.pwd = encodeURIComponent(encryptedPwd);
            $('#Password-Value input').val(encryptedPwd);
            $('#Formulario').submit();
            JSLogger.getInstance().traceExit();
            
         }
         //When the document has been load completly, bind the button to the function
         $(document).ready(function(){
            $('#Button-Contact').click(function(){
               JSLogger.getInstance().traceEnter();
               sendDataToLogin();
               JSLogger.getInstance().traceExit();
            });
            
         });
         <?php
         if ($error){
         ?>
         showError("<?php print($errorText)?>");
         <?php 
         }?>
         
         //window.location.replace()
      </script>

    </body>

</html>