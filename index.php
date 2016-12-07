<!DOCTYPE HTML>
   <head>
      
      <meta charset="utf-8">
      <meta name="description" content="Página web del gimnasio Legafitness">
      
      <title>Legafitness</title>
      <!-- JQuery -->
      <script type="text/javascript" src="/plugins/JQuery/jquery-3.1.0.min.js"></script>
      <?php 
      if(isset ($_GET['p']) && ($_GET['p'] == "Contacto") || $_GET['p'] == "Noticias"){
      ?> 
         <?php if ($_GET['p'] == "Contacto"){?>
         
            <!-- JQuery UI, custom to Legafitness -->
            <script type="text/javascript" src="/plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.min.js"></script>
            <link rel="stylesheet" href="/plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.min.css">
            <link rel="stylesheet" href="/plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.structure.min.css">
            <link rel="stylesheet" href="/plugins/JQuery-UI/jquery-ui-1.12.0.custom/jquery-ui.theme.min.css">
         
            <script type="text/javascript" src="/js/JSLogger/JSLogger.js"></script>
            <script type="text/javascript" src="/plugins/Ajax/Ajax.js"></script>
            <script type="text/javascript" src="/js/GeneralLib.js"></script>
         
            <!--  DataEntry -->
            <script type="text/javascript" src="/plugins/DataEntry/DataEntryFunctions.js"></script>
            <link rel="stylesheet" href="/plugins/DataEntry/DataEntry.css"/>
        
            <!--  ContactForm -->
            <script type="text/javascript" src="/plugins/ContactForm/ContactForm.js"></script>
         <?php }?>
         <link rel="stylesheet" href="/styles/ButtonsStyles.css"/>
      <?php 
      }
      ?>
      <link rel="stylesheet" href="/styles/style.css"/>
      
      
   </head>
   <body>
   <?php 
      require_once './webpages.php';
   ?>
      <header class="container">
         <a href="/"><div id="logo"></div></a>
         <nav>
            <ul>
               <li id="Menu-Salas"><a href="/Salas">Salas</a></li>
               <li id="Menu-Horarios">
                  <a href="/Horarios">Horarios</a>
                  <ul>
                    <!--  <li><a href="?p=Horarios#Anchor-Timetable-Cicle">Clases Ciclo</a></li> -->
                     <li><a href="/Horarios/Clases-Ciclo">Clases Ciclo</a></li>
                     <!-- <li><a href="?p=Horarios#Anchor-Timetable-Collective-Classes">Clases Colectivas</a></li> -->
                     <li><a href="/Horarios/Clases-Colectivas">Clases Colectivas</a></li>
                  </ul>
               </li>
               <li id="Menu-Actividades"><a href="/Actividades">Actividades</a></li>
               <li id="Menu-Contacto"><a href="/Contacto">Contacto</a></li>
               <li id="Menu-News"><a href="/Noticias">Noticias</a></li>
            </ul>
         </nav>
      </header>
      <section id="Section-Image-Fachada" class="container">
         <?php if (!isset($_GET['p'])){?>
            <div id="Image-Fachada"></div>
         <?php }else{
            if ($_GET['p'] == "Salas"){
            ?>
               <div id="Image-Rooms"></div>
            <?php 
            }
            if ($_GET['p'] == "Actividades"){
            ?>
               <div id="Image-Activities"></div>
            <?php
            }
            if ($_GET['p'] == "Noticias"){
                
            }
            if ($_GET['p'] == "Horarios"){
            ?>
               <div id="Image-Timetables"></div>
            <?php
            }
            if ($_GET['p'] == "Contacto"){
            ?>
               
            <?php
            }
         }?>
         
      </section>
      <section id="main" class="container">
         <?php if (!isset($_GET['p'])){
                  getHome();
               }else{
                  if ($_GET['p']=='Salas'){
                     getRooms();
                  }
                  if ($_GET['p']=='Actividades'){
                     getActivities();
                  }
                  if ($_GET['p']=='Noticias'){
                      getNews();
                  }
                  if ($_GET['p']=='Horarios'){
                     getTimeTables();
                  }
                  if ($_GET['p']=='Contacto'){
                     getContactForm();
                  }
               }
         ?>
      </section>
      <footer>
         <p>LEGAFITNESS.</p>
         <p>C/ El Charco 13. 28911. Léganes. Madrid.</p>
         <p>info@legafitness.com</p>
      </footer>
   </body>

</html>