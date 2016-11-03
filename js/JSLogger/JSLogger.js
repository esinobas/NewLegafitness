/**
 * Singleton class writes in the console log the trace to debug the appliation
 * 
 * Use:
 *    Setup ->JSLogger.getInstance().registerLogger(<theClass>, <level>);
 *    where level can be: 
 *       JSLogger.levelsE.TRACE
 *       JSLogger.levelsE.DEBUG
 *       JSLogger.levelsE.WARN
 *       JSLogger.levelsE.ERROR
 *       JSLogger.levelsR.INFO
 *       
 * Tracing:
 *    JSLogger.getInstance().trace(<trace>);
 *    JSLogger.getInstance().debug(<debug>);
 *    JSLogger.getInstance().warn(<warn>);
 *    JSLogger.getInstance().error(<error>);
 *    JSLogger.getInstance().info(<info>);
 */

function JSLogger(){

   /*** Private properties ***/
   
   arrayClassesM = new Array();
   
   /*** Public properties ***/
   
      
   /*** Private functions ***/
   
   
   function getClassName(){
      
      var stack  = new Error("Dummy").stack;
      var functionName = stack.split("\n")[3];
      functionName = functionName.split("/")[functionName.split("/").length-1];
      functionName = functionName.split(":")[0];
      functionName = functionName.split(".")[0];
      return functionName;
      
   }
   
   function getFunctionName(){
      
      var stack  = new Error("Dummy").stack;
      var className = stack.split("\n")[3].split("@")[0];
      if (className == ""){
         className = "main";
      }
      return className;
   }
   
   function writeLog(theLevel,theLog){
      
      //get the class who has been the method
      var classToLog = getClassName();
      //get the class set level
      var level = arrayClassesM[classToLog] | 0;
      
      if (theLevel >= level){
         var text = "[ " + (theLevel == 0 ? "TRACE" : theLevel == 1 ? "DEBUG" :
                                           theLevel == 3 ? "WARNING" : 
                                          theLevel == 4 ? "ERROR" :
                                       "INFO") + " ]";
         text += ". "+ classToLog + ". " + getFunctionName() + "()" + ": ";
         text += theLog;
         console.debug(text);
      }
   }
   
   /*** Public functions ***/
   
 
   
   this.registerLogger = function (theClass, theLevel){
      //console.debug("XXX. theClass -> "+ theClass +". theLevel -> " + theLevel );
       arrayClassesM[theClass] = theLevel;
   }
   
   this.trace = function (theLog){
      writeLog(JSLogger.levelsE.TRACE, theLog);
   }
   
   this.debug = function (theLog){
      writeLog(JSLogger.levelsE.DEBUG, theLog);
   }
   
   this.warn = function (theLog){
      writeLog(JSLogger.levelsE.WARN, theLog);
   }
   
   this.error = function (theLog){
      writeLog(JSLogger.levelsE.ERROR, theLog);
   }
   
   this.info= function (theLog){
      writeLog(JSLogger.levelsE.INFO, theLog);
   }
   
   this.traceEnter = function(){
      writeLog(JSLogger.levelsE.TRACE, "Enter");
   }
   
   this.traceExit = function(){
      writeLog(JSLogger.levelsE.TRACE, "Exit");
   }
}

/*** Constants ***/
JSLogger.levelsE = {TRACE :0, DEBUG :1, INFO: 2, WARN: 3 , ERROR: 4};

/*** Static variables  ***/
var instanceM = null;
/**
 * Static public function that returns a JSLoggerInstance
 */
 JSLogger.getInstance = function(){
  
   if (instanceM == null){
      instanceM = new JSLogger();
   }
   return instanceM;
   
 }