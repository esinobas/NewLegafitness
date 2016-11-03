<?php
   /**
    * This file executes the necesary commands to done the dashboard logout
    */
   define("URL_ADMIN_C", "../../admin");
   session_destroy();
?>
<!DOCTYPE HTML>
   <head>
   </head>
   <body>
      <script type="text/javascript">
         window.location.replace("<?php print(URL_ADMIN_C);?>");
      </script>
   </body>
</html>