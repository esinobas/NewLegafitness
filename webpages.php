<?php
   /**
    * Constants used in the pages
    */

   /**
     * Includes
     */
   if (! strpos ( get_include_path (), $_SERVER['DOCUMENT_ROOT'])) {
      set_include_path( get_include_path() . PATH_SEPARATOR . $_SERVER['DOCUMENT_ROOT']);
   }
   require_once 'php/Database/Tables/TB_Timetable.php';
   require_once 'php/Database/Tables/TB_News.php';
   /**
    * This file contains functions to show page web
    */
   /////////////////////////////////////////////////////////////////////////
   function getArticleAllFitnessYouWant(){
      ?>
         <article id="AllFitnessYouWant" class="Main-Article Orange-Article">
            <hgroup> 
               <h1>Todo el Fitness que quieras</h1>
            </hgroup>
            <div id="ImageAllFitnessYouWant">
            </div>
            <div id="TextLowCost" class="Text-Article">
               <p>
                   No tienes excusa para no estar en forma y pasarlo fenomenal. 
                   Todo, pero todo el gimnasio destinado para ti, desde  <span class="StandOut-Text"> 21,60€/mes</span>. 
               </p>
               <p>
                  Así es la filosofía low cost que hemos querido ofrecerte para 
                  que todo Leganés disfrute de un mundo de ejercicios, máquinas 
                  de última generación, clases colectivas y asesores de fitness,
                   sólo para ti. Desde <span class="StandOut-Text">21,60€/mes</span>. 
               </p>
            </div>
         </article>
      <?php 
   }
   
   //////////////////////////////////////////////////////////////////////
   function getArticleTimeTable($theArticleColor = "White"){
      ?>
         <article id="Timetable" class="Main-Article <?php ($theArticleColor == "White"?print("White-Article"):print("Orange-Article"));?>">
            <hgroup>
               <h1>¡ Libertad de Horarios !</h1>
            </hgroup>
            <div id="Text-Timetable" class="Text-Article">
               <p>En <span class="StandOut-Text">Legafitness</span> tienes total
                <span class="StandOut-Text">libertad de horarios</span> para entrenar.
               Puedes venir a entrenar las horas que quieras, cuando quieras, las 
               veces que quieras durante nuestro horario.</p>
               
            </div>
            <div id="Image-Timetable">
            </div>
          
         </article>
      <?php 
   }
   ////////////////////////////////////////////////////////////////////////
   function getArticleParking(){
      ?>
         <article id="Parking" class="Main-Article Orange-Article">
            <hgroup>
               <h1>
                  Parking Gratuito
               </h1>
               <div id="Image-Parking">
               </div>
               <div id="Text-Parking" class="Text-Article">
                  <p>Si quieres venir en tu propio coche al gimnasio, no te 
                  preocupes por el aparcamiento.</p>
                  <p>En <span class="StandOut-Text">Legafitness</span> disponemos
                   de parking para nuestros socios.</p>
               </div>
            </hgroup>
         </article>
      <?php 
   }
   /////////////////////////////////////////////////////////////////////////
   function getHome(){
   
      getArticleAllFitnessYouWant();
      getArticleTimeTable();
      getArticleparking();
    
   }
   
   ////////////////////////////////////////////////////////////////////////
   function getRooms(){
      ?>
         <script type="text/javascript">
           $('#Menu-Salas').addClass('Current-Page');
         </script>

         <article id="Rooms" class="Main-Article Orange-Article">
            <hgroup>
               <h1>Más de 1000 m<sup>2</sup> repartidos en 3 salas</h1>
            </hgroup>
         </article>
         <article id="Article-Fitness-Room" class="Main-Article White-Article">
            <div id="Image-Fitness-Room">
            </div>
            <div id="Fitness-Room-Text" class="Text-Article">
               <h2>Sala de Fitness</h2>
               <p>De alta calidad y tecnologías. Con las últimas tendencias en
                equipamiento cardiovascular y de tonificación. Con asesores de 
               fitness especializados en el seguimiento de tu perfeccionamiento 
               muscular y físico.</p>
            </div>
         </article>
         <article id="Article-Collective-Rooms" class="Main-Article Orange-Article">
            <div id="Collective-Rooms-Text" class="Text-Article">
               <h2>2 salas de Clases Colectivas</h2>
               <p>Disfruta de las últimas tendencias: <br>
               Combo-Style, Zumba, GAP, Cardio-Tonic, Yoga, Pilates, Abdomen, 
               Ciclo y Ciclo Virtual.</p>
            </div>
            <div id="Image-Collective-Rooms">
            </div>
         </article>
         <article id="Article-Ademas" class="Main-Article White-Article">
            <div id="Image-Ademas">
            </div>
            <div id="Ademas-Text" class="Text-Article">
               <h2>Además ...</h2>
               <ul>
                  <li>Más de 200 máquinas diferentes.</li>
                  <li>Máquinas de musculación y cardio de última generación.</li>
                  <li>Sauna para relax.</li>
                  <li>Espaciosas áreas de vestuarios, duchas gratuitas y 
                  taquillas para tu mayor comodidad.</li>
               </ul>
            </div>
         </article>
         <article id="Use-Rules" class="Main-Article Orange-Article">
            <div id="Uses-Rules-Text" class="Text-Article">
               <h2>Reglamento de Uso</h2>
               <ol>
                  <li> Es obligatorio el acceso a la sala con calzado deportivo, ropa deportiva y toalla.</li>
                  <li> No se permite el acceso a clases sin camiseta, en bañador o con zapatillas de baño.</li>
                  <li> Una vez completado el aforo de plazas no se podrá asistir a la clase.</li>
                  <li> Se ruega máxima puntualidad en el inicio de la clase, ya que el calentamiento
                  es esencial para un buen entrenamiento, al igual que es muy importante no abandonar 
                  la sesión antes de que ésta finalice.</li>
                  <li> Si sufre algún tipo de lesión, enfermedad o toma medicación especial que pueda
                  afectarle en la práctica del ejercicio físico, le rogamos se lo comunique al monitor responsable de la clase.</li>
                  <li> Asegúrese de que el contenido e intensidad de las sesiones son los adecuados 
                  a su nivel actual de condición física.</li>
                  <li> Por razones de higiene es obligatorio usar toalla en los ejercicios de suelo.</li>
                  <li> Procure hidratarse antes y después de la práctica del ejercicio físico.
                   Es recomendable beber 200 ml. de agua cada 15 ó 20 minutos.</li>
                  <li> No se permite el uso del teléfono móvil dentro de la sala.</li>
                  <li> Para poder acceder a una clase, deberá esperar que finalice la anterior. </li>
                  <li> No se permite fumar, comer e introducir objetos de vidrio en la sala.</li
               </ol>
            </div>
         </article>
         
         
      <?php 
   }
   ////////////////////////////////////////////////////////////////////////
   /**
    * Returns the week day 
    * 
    * @param theIdx. The day index (0 = Monday)
    */
   function getStringDay($theIdx){
      switch ($theIdx){
         case 0: 
            return "Lunes";
            break;
         case 1:
            return "Martes";
            break;
         case 2:
            return "Miercoles";
            break;
         case 3:
            return "Jueves";
            break;
         case 4:
            return  "Viernes";
            break;
         case 5:
            return "Sábado";
            break;
         case 6:
            return "Domingo";
            break;
      }
   }
   //////////////////////////////////////////////////////////////
   /**
    * Add a timetable in the web
    * 
    * @param $theTimetableDetail The timetable detail (activities) in a string
    *        with JSON format.
    */
   function addTimeTable($theTimetableDetail){
      ?>
      <div class="Timetable-Hour-Detail">
         <?php for($hour = 7; $hour < 23;$hour++){
            ?><div class="Timetable-Hour-Detail-Quarter"><?php print($hour);?>:00</div>
            <?php 
            if ($hour<22){
               for ($quarter = 15; $quarter < 60; $quarter = $quarter + 15){
                  if ($quarter == 30) {
                     ?><div class="Timetable-Hour-Detail-Quarter"><?php print($hour.":".$quarter);?></div>
               <?php }
               }
            }
         }?>
      </div>
      <?php 
      $jsonDetail = json_decode($theTimetableDetail, true);
      
      for ($idxDay = 0;$idxDay < 7; $idxDay++){
      ?><div class="Timetable-Day-Detail">
         <div class="Timetable-Header">
            <?php print(getStringDay($idxDay));?>
         </div>
         <div class="Timetable-Day-Detail-Activities <?php if ($idxDay<6) print("Timetable-Day-Detail-Right-Line");?>">
            <?php 
               $dayDetail = $jsonDetail['detail'][$idxDay];
               
               foreach ($dayDetail as $activityDetail){
               
                  $activityName = $activityDetail['activityName'];
                  $activityColor = $activityDetail['activityColor'];
                  $activityFontColor = $activityDetail['activityFontColor'];
                  $activityTime = $activityDetail['activityTime'];
                  $activityStart = $activityDetail['activityStart'] * 11;
                  $activityDuration = $activityDetail['activityDuration'] * 11;
                  $paddingTop = ($activityDuration -32) / 2
                  
                  ?>
                  <div class="Activity-Detail" 
                     style="background-color: <?php print($activityColor)?>;
                     color: <?php print($activityFontColor);?>;
                     top: <?php print($activityStart)?>px;height: <?php print($activityDuration);?>px;
                     padding-top: <?php print($paddingTop);?>px;
                     <?php if ($activityDuration/11 < 3 )print ("font-size: 0.4em")?>">
                     
                     <div><?php print($activityName)?></div>
                     <div class="Activity-Time"><?php print($activityTime)?></div>
                  </div>
                  <?php 
                  
               } 
            ?>
         </div>
        </div>
      <?php
      }
   }
   ////////////////////////////////////////////////
   function getTimeTables(){
      getArticleTimeTable("Orange");
      $tbTimetable = new TB_Timetable();
      $tbTimetable->open();
      $tbTimetable->next();
      ?>
         <script type="text/javascript">
           $('#Menu-Horarios').addClass('Current-Page');
         </script>
         <article id="TimeTable" class="Main-Article White-Article">
            <hgroup>
               <h1>Horarios</h1>
            </hgroup>
            <span class="Aclaration-Text">
               Por razones objetivas los horarios podrán ser modificados, siendo comunicado
               con la mayor antelación posible a los socios del club.
            </span>
            <span id="Anchor-Timetable-Cicle" class="Anchor"></span>
            <div id="TimeTable-Ciclo" class="Timetable">
               <h2>Horario Clases Ciclo</h2>
               <?php addTimeTable($tbTimetable->getDetail());?>
            </div>
            <br>
            <span id="Anchor-Timetable-Collective-Classes" class="Anchor"></span>
            <div id="TimeTable-Collective-Classes" class="Timetable">
               <h2>Horario Clases Colectivas</h2>
               <?php 
               $tbTimetable->next();
               addTimeTable($tbTimetable->getDetail());?>
            </div>
            
         </article>
         <?php if (isset($_GET['anchor'])){?>
            
            <script type="text/javascript">
               
                $('html, body').scrollTop($("#<?php print($_GET['anchor']);?>").offset().top + 15);
            
               
            </script>
         <?php }
      
   }
   /////////////////////////////////////////////////////////////////////////
   function getActivities(){
      ?>
         <script type="text/javascript">
            $('#Menu-Actividades').addClass('Current-Page');
         </script>
         <article id="Combo-Style" class="Main-Article Orange-Article">
            <h2>Combo-Style</h2>
            <div id="Combo-Style-Image" class="Class-Article-Image">
            </div>
            <div id="Aerobic-Step-Text" class="Text-Article">
               <p>
                  ¡No pierdas el paso! Y únete a la clase más divertida de Leganés.
                  Los pasos más dinámicos para moldear tu cuerpo y quemar calorías te están esperando.
               </p>  
            </div>
         </article>
         <article id="GAP" class="Main-Article White-Article">
            <h2>GAP (Glúteos, Abdominales y Piernas)</h2>
            <div id="GAP-Text" class="Text-Article">
               <p>
                  Nuestros asesores trabajarán 
                  específicamente estas zonas de tu cuerpo, combinando ejercicios 
                  en el suelo con acciones dinámicas. ¡Verás los resultados! 
               </p>  
            </div>
            <div id="GAP-Image" class="Class-Article-Image">
            </div>
         </article>
         <article id="Ciclo-Indoor" class="Main-Article Orange-Article">
         <h2>Ciclo Indoor</h2>
            <div id="Ciclo-Indoor-Image" class="Class-Article-Image">
            </div>
            <div id="Ciclo-Indoor-Text" class="Text-Article">
               <p>
                  ¡Pedalea al ritmo de la música! Desde principiantes hasta 
                  expertos disfrutan quemando 
                  calorías y mejorando su sistema cardiovascular.
               </p>  
            </div>
         </article>
         <article id="Yoga" class="Main-Article White-Article">
            <h2>Yoga</h2>
            <div id="Yoga-Text" class="Text-Article">
               <p>
                  La disciplina justa para liberar, oxigenar y mantener tu cuerpo,
                   mente y espíritu en total armonía. Aquí en LegaFitness y con 
                   los mejores asesores de meditación podrás cultivar tu equilibrio, 
                   con esta gran clase colectiva.
               </p>  
            </div>
            <div id="Yoga-Image" class="Class-Article-Image">
            </div>
         </article>
         <article id="Pilates" class="Main-Article Orange-Article">
         <h2>Pilates</h2>
            <div id="Pilates-Image" class="Class-Article-Image">
            </div>
            <div id="Pilates-Text" class="Text-Article">
               <p>
                  Fortalecimiento muscular y estiramientos dirigidos a ejercitar 
                  tu cuerpo y mente; mejorar tu equilibrio y flexibilidad, y por
                   supuesto tu columna vertebral y tu salud general. 
               </p>  
            </div>
         </article>
         <article id="Zumba" class="Main-Article White-Article">
            <h2>Zumba</h2>
            <div id="Zumba-Text" class="Text-Article">
               <p>
                  Zumba es un movimiento o disciplina fitness de origen colombiano, 
                  enfocado por una parte a mantener un cuerpo saludable y por otra a desarrollar,
                   fortalecer y dar flexibilidad al cuerpo mediante movimientos de baile 
                   combinados con una serie de rutinas aeróbicas.
                </p>
                <p>
                  La zumba utiliza dentro de sus rutinas los principales ritmos latinoamericanos,
                   como son la salsa, el merengue, la cumbia, el reggaeton y la samba. 
                   En cada sesión de Zumba se pueden llegar a quemar 800 calorías 
               </p>  
            </div>
            <div id="Zumba-Image" class="Class-Article-Image">
            </div>
         </article>
          <article id="Cardio-Tonic" class="Main-Article Orange-Article">
         <h2>Cardio-Tonic</h2>
            <div id="Cardio-Tonic-Image" class="Class-Article-Image">
            </div>
            <div id="Cardio-Tonic-Text" class="Text-Article">
               <p>
                  El cardiotonic es un tipo de entrenamiento completo cuyos objetivos son 
                  la mejora del sistema cardiovascular y la tonificación de sistema muscular, 
                  lo que convierte a esta actividad en un ejercicio idóneo para la mejora de la condición física general. 
                  Se trabaja por intervalos la actividad cardiovascular y la tonificación muscular, 
                  combinada con coreografías al ritmo de la música.
               </p>  
            </div>
         </article>
         
      <?php 
   }
   
   /////////////////////////////////////////////////////////////////////////
   function dialog(){
   ?>
      <div id="Dialog" title="DialogTitle">
         <p id="Dialog-Text" style="text-align: center"></p>
      </div>
      
   <?php 
   }
   
   ///////////////////////////////////////////////////////////////////////
   function getContactForm(){
   ?>
      <script type="text/javascript">
         $('#Menu-Contacto').addClass('Current-Page');
      </script>
      <article id="Contact" class="Main-Article Orange-Article">
         <p>Rellene este formulario para cualquier consulta, duda o sugerencia
            que nos quiera hacer llegar.
         </p>
         <p>Nos pondremos en contacto con usted lo antes posible.</p>
         <p>Gracias</p>
         <div id="Contact-Form">
            <div class="DataEntryContainer">
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="Nombre">Nombre<sup>*</sup></div>
                  <div class="DataEntryValue" id="Name-Value">
                     <input type="text">
                  </div>
               </div>
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="Apellidos">Apellidos<sup>*</sup></div>
                  <div class="DataEntryValue" id="SurnameValue">
                     <input type="text">
                  </div>
               </div>
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="Email">Correo Electrónico<sup>*</sup></div>
                  <div class="DataEntryValue" id="EmailValue">
                     <input type="text">
                  </div>
               </div>
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="Re-Email">Confirmar Correo Electrónico<sup>*</sup></div>
                  <div class="DataEntryValue" id="Re-emailValue">
                     <input type="text">
                  </div>
               </div>
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="Asunto">Asunto<sup>*</sup></div>
                  <div class="DataEntryValue" id="Subject">
                     <input type="text">
                  </div>
               </div>
               <div class="DataEntryRow">
                  <div class="DataEntryLabel" id="Comentarios">Comentarios<sup>*</sup></div>
                  <div class="DataEntryValue" id="ComentsValue">
                     <textarea rows="10" required></textarea>
                  </div>
               </div>
               <span style="font-size: 75%">* Datos Obligatorios</span>
            </div>
            <div class="DataEntryButtonsContainer">
               <div class="Round-Corners-Button DataEntryWindowButtonOk" id="Button-Contact" title="Enviar">Enviar</div>
            </div>
         </div>
      </article>
      <!-- Bind the button for send the contact form to the function -->
      <script type="text/javascript">

         $('input').keypress(function(e){
            if (e.which == 13){
               $('#Button-Contact').click();
            }
         });
      
         $('#Button-Contact').click(function(){
            var dataContactForm = DataEntryFunctions.getValues('#Contact-Form');
            
            if (!ContactForm.checkEmptyValues(dataContactForm)){
               if (ContactForm.checkEmail(dataContactForm)){
                  if ( ContactForm.sendContactFormToServer(dataContactForm) ) {
                     DataEntryFunctions.clearValues('#Contact-Form');
                  }
               }
            }
         });
      </script>
   <?php 
      //Dialog error definition in Contac form
      dialog();
   }
   //////////////////////////////////////////////////////////////////////////
   function getNews(){
   ?>
      <script type="text/javascript">
      $('#Menu-News').addClass('Current-Page');
      </script>
      <?php
         $tbNews = new TB_News();
         $tbNews->open();
      ?>
      <article id="News" class="Main-Article Orange-Article">
         <?php while ($tbNews->next()){
            if ($tbNews->getPublished()){
               print($tbNews->getTitle());
               print($tbNews->getNew());
            }
         }?>
      </article>
      <aside id="News-Aside">
         <div id="News-Post-Index">
            <div id="News-Last-Five-Post">
            </div>
            <div id="News-Post-By-Date">
            </div>
         </div>
         
      </aside>
      
   <?php    
   }
?>