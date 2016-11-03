/**
 * File with a set the general funtions
 */

/**
 * Object to log
 */
JSLogger.getInstance().registerLogger("GeneralLib", JSLogger.levelsE.ERROR);

/**
 * Sends as synchrinized Ajax request to the server 
 * 
 * @theUrl: A string with the url where the request is sent
 * @theRequestParams: A object with the request params to be send to the server
 */
var sendSynAjaxRequestWithPost = function(theUrl, theRequestParams){
   JSLogger.getInstance().traceEnter();
   
   var ajaxObject = new Ajax();
   ajaxObject.setSyn()
   ajaxObject.setPostMethod();
   JSLogger.getInstance().debug("Url whete the data will be send [ " 
      + theUrl);
   ajaxObject.setUrl(theUrl);
   
   JSLogger.getInstance().debug("Request parameters [ " + JSON.stringify(theRequestParams) +" ]");
   
   ajaxObject.setParameters(JSON.stringify(theRequestParams));
   ajaxObject.send();
   JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");
   JSLogger.getInstance().traceExit();
   return ajaxObject.getResponse();
}

/**
* Sends as synchrinized Ajax request to the server 
* 
* @theUrl: A string with the url where the request is sent
* @theRequestParams: A object with the request params to be send to the server
*/
var sendSynAjaxRequestWithGet = function(theUrl, theRequestParams){
  JSLogger.getInstance().traceEnter();
  
  var ajaxObject = new Ajax();
  ajaxObject.setSyn()
  ajaxObject.setGetMethod();
  JSLogger.getInstance().debug("Url whete the data will be send [ " 
     + theUrl + " ]");
  ajaxObject.setUrl(theUrl);
  
  JSLogger.getInstance().debug("Request parameters [ " + JSON.stringify(theRequestParams) +" ]");
  if (theRequestParams != null){
     ajaxObject.setParameters(JSON.stringify(theRequestParams));
  }
  ajaxObject.send();
  JSLogger.getInstance().trace("Response [ " + ajaxObject.getResponse() + " ]");
  JSLogger.getInstance().traceExit();
  return ajaxObject.getResponse();
}
   