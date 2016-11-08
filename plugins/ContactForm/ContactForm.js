/**
 * File with the necesary functions to send data from a contact form to server
 * 
 * It is mandatory there be declared or included previously :
 *    - JQueryUI
 */
var ContactForm = ContactForm || {};
/** 
 * Define the constants used by the functions
 */

/**
 * Object to log
 */
JSLogger.getInstance().registerLogger("ContactForm", JSLogger.levelsE.WARN);
/**
 * Constant with the email address
 */
const EMAIL_ADDRESS_C = "info@legafitness.com";
/**
 * Constant with the server url
 */
const SERVER_URL_C = "plugins/ContactForm/SendEmail.php";

/**
 * Function to check there are any field empty
 * 
 * @param theDataContactForm is a string in JSON format with the 
 * data contact form.
 * 
 * @return a boolean value, true when any field is empty or false
 * when all the field have data.
 */

ContactForm.checkEmptyValues = function(theDataContactForm){
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().debug("The data contact form is [ " + theDataContactForm +
   " ]");
   var data = JSON.parse(theDataContactForm);
   var emptyValues = new Array();
   for (var key in data){
      JSLogger.getInstance().trace("Check value for key [ " + key + " ]");
      if (data[key].length == 0){
         JSLogger.getInstance().debug("The [ " + key + " ] value is empty");
         emptyValues[emptyValues.length] = key;
         
      }
   }
   if (emptyValues.length > 0){
      
      var text = "Por favor, debes especificar los siguientes datos de entrada:<br>";
      for (var i = 0; i < emptyValues.length; i++){
         //text += "\""+emptyValues[i] + "\"\n";
         text += "\""+emptyValues[i] + "\"<br>";
         JSLogger.getInstance().warn("The field [ " + emptyValues[i] +" ] is emtpy");
      }
      ContactForm.showDialog("Error", text);
      JSLogger.getInstance().traceExit();
      return true;
   }
   JSLogger.getInstance().traceExit();
   return false;
}

/**
 * Checks if the email and the re-email are equals, it is check to avoid write wrong the 
 * email address.
 * 
 * @param the * @param theDataContactForm is a string in JSON format with the 
 * data contact form.
 * @return  a boolean value with true value when the address email and
 * address re-email are not equal.
 */
ContactForm.checkEmail = function (theDataContactForm){
   //Check the email
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().debug("ContactData [ " + theDataContactForm + " ]");
   var data = JSON.parse(theDataContactForm);
   JSLogger.getInstance().trace("Email [ " + data['Email']+ " ], Re-Email [ " + 
                           data['Re-Email'] + " ]");
   if (data['Email'].localeCompare(data['Re-Email']) != 0){
      ContactForm.showDialog('Error', 'Revise su dirección de correo electrónico.');
      JSLogger.getInstance().warn("The email and re-email are not equals");
      JSLogger.getInstance().traceExit();
      return false;
   }
   JSLogger.getInstance().traceExit();
   return true;
}


/**
 * @param theDataContactForm is a string in JSON format with the 
 * data contact form.
 */
ContactForm.sendContactFormToServer = function (theDataContactForm){
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().debug("The data contact form is [ " + theDataContactForm +
                                                   " ]");
   JSLogger.getInstance().debug("Url where the email data is sent [ " + 
         SERVER_URL_C + " ]");
   var resultCode = true;
   var data = JSON.parse(theDataContactForm);
   var requestParams = {};
   requestParams.emailsData = {};
   requestParams.emailsData[0] = {};
   requestParams.emailsData[0].address = EMAIL_ADDRESS_C;
   
   requestParams.emailsData[0].message = encodeURIComponent("Direccion de correo: " +
          data['Email'].replace(/\"/g,"\\\"")+"<br>"+data['Comentarios'].replace(/\"/g,"\\\"").replace(/\r/g,"<br>").replace(/\n/g,"<br>"));
   requestParams.emailsData[0].subject = encodeURIComponent((
                                          data['Email']).replace(/\"/g,"\\\""));
   requestParams.emailsData[0].from = data['Nombre'] + " " + 
   data['Apellidos'] + 
                                  "<" + data['Email'] + ">";

   JSLogger.getInstance().debug("Contact data [ " + JSON.stringify(requestParams) +" ]");
   
   var requestResponse = sendSynAjaxRequestWithPost(SERVER_URL_C, requestParams);
   JSLogger.getInstance().debug("Request response [ " + requestResponse + " ]");
   if (requestResponse != "0"){
      JSLogger.getInstance().error("An error has been produced in send email from contact form");
      ContactForm.showDialog("Error", "Se ha producido un error en el envío de los datos.<br> Inténtelo más tarde o ponganse encontacto con el administrador.");
      resultCode = false;
   }else{
      JSLogger.getInstance().debug("The contact form has been sent successfull");
      ContactForm.showDialog("Información","El envio se ha realizado correctamente.<br>Atenderemos su petición lo más rápido posible.<br>Gracias");
   }
   JSLogger.getInstance().traceExit();
   return resultCode;
}

/**
 * Shows a  dialog with the text passed like argument.
 * This method uses jquery ui
 *
 *@param theText: a string with the text will be showed in the error dialog
*/
ContactForm.showDialog = function (theTitle,theText){
   JSLogger.getInstance().traceEnter();
   JSLogger.getInstance().debug("theTitle [ " + theTitle + 
         " ]. theText [ " + theText + " ]");
   $('#Dialog').attr('title', theTitle);
   $('#Dialog-Text').empty();
   $('#Dialog-Text').append(theText);
   $('#Dialog').dialog({
                     modal: true,
                     resizable: false,
                     buttons: [{
                                 text: 'OK', click: function(){$(this).dialog('close');}
                              }]
                     });
   JSLogger.getInstance().traceExit();
}