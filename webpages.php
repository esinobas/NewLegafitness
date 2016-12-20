<?php
   /**
    * Constants used in the pages
    */
    define("PREVIEW_NEWS_NUM_CHARACTERS_C", 150);

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
   
   ///////////////////////////////////////////////////////////////////////
   function friendlyUrl($url) {
       
      // Tranformamos todo a minusculas
       
      $url = strtolower($url);
       
      //Rememplazamos caracteres especiales latinos
       
      $find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
       
      $repl = array('a', 'e', 'i', 'o', 'u', 'n');
       
      $url = str_replace ($find, $repl, $url);
       
      // Añaadimos los guiones
       
      $find = array(' ', '&', '\r\n', '\n', '+');
      $url = str_replace ($find, '-', $url);
       
      // Eliminamos y Reemplazamos demás caracteres especiales
       
      $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
       
      $repl = array('', '-', '');
       
      $url = preg_replace ($find, $repl, $url);
       
      return $url;
       
   }
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
         <div id="Dialog-Legal-Warning" title="AVISO LEGAL Y POLITICA DE PRIVACIDAD WEBS">
         <ol>
            <li>
               DATOS IDENTIFICATIVOS: <br>En cumplimiento con el deber de información
               recogido en artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la
               Sociedad de la Información y del Comercio Electrónico, a continuación se reflejan
               los siguientes datos: la empresa titular de www.legafitness.es es SPORARENA GESTIÓN, S.L.
               (en adelante SPORARENA), con domicilio a estos efectos en Calle El Charco 13, 28911, Léganes, Madrid.
               número de C.I.F.: B83148040 inscrita en el Registro Mercantil de Madrid en el
               tomo YYYY general, ZZZZ de la Sección A, inscripción B del Libro de Sociedades,
               folio XX, Hoja XXXXX. Correo electrónico de contacto: info@legafitness.es.
            </li>
            <li>
               USUARIOS: <br>El acceso y/o uso de este portal de SPORARENA
               atribuye la condición de USUARIO, que acepta, desde dicho acceso y/o uso, las
               Condiciones Generales de Uso aquí reflejadas. Las citadas Condiciones serán de
               aplicación independientemente de las Condiciones Generales de Contratación que
               en su caso resulten de obligado cumplimiento.
            </li>
            <li>
               USO DEL PORTAL: <br>www.legafitness.es proporciona el acceso a multitud de
               informaciones, servicios, programas o datos (en adelante, &quot;los contenidos&quot;) en
               Internet pertenecientes a SPORARENA o a sus licenciantes a los que el
               USUARIO pueda tener acceso. El USUARIO asume la responsabilidad del uso del
               portal. Dicha responsabilidad se extiende al registro que fuese necesario para
               acceder a determinados servicios o contenidos. En dicho registro el USUARIO será
               responsable de aportar información veraz y lícita. Como consecuencia de este
               registro, al USUARIO se le puede proporcionar una contraseña de la que será
               responsable, comprometiéndose a hacer un uso diligente y confidencial de la
               misma. El USUARIO se compromete a hacer un uso adecuado de los contenidos y
               servicios (como por ejemplo servicios de chat, foros de discusión o grupos de
               noticias) que SPORARENA ofrece a través de su portal y con carácter
               enunciativo pero no limitativo, a no emplearlos para (1º) incurrir en actividades
               ilícitas, ilegales o contrarias a la buena fe y al orden público; (2º) difundir
               contenidos o propaganda de carácter racista, xenófobo, pornográfico-ilegal, de
               apología del terrorismo o atentatorio contra los derechos humanos; (3º) provocar
               daños en los sistemas físicos y lógicos de SPORAREAN, de sus
               proveedores o de terceras personas, introducir o difundir en la red virus
               informáticos o cualesquiera otros sistemas físicos o lógicos que sean susceptibles
               de provocar los daños anteriormente mencionados; (4º) intentar acceder y, en su
               caso, utilizar las cuentas de correo electrónico de otros usuarios y modificar o
               manipular sus mensajes. SPORARENA se reserva el derecho de retirar
               todos aquellos comentarios y aportaciones que vulneren el respeto a la dignidad de
               la persona, que sean discriminatorios, xenófobos, racistas, pornográficos, que
               atenten contra la juventud o la infancia, el orden o la seguridad pública o que, a su
               juicio, no resultaran adecuados para su publicación. En cualquier caso, SPORARENA
                no será responsable de las opiniones vertidas por los usuarios a través
               de los foros, chats, u otras herramientas de participación.
            </li>
            <li>
               PROTECCIÓN DE DATOS: <br>SPORARENA cumple con las directrices
               de la Ley Orgánica 15/1999 de 13 de diciembre de Protección de Datos de Carácter
               Personal, el Real Decreto 1720/2007 de 21 de diciembre por el que se aprueba el
               Reglamento de desarrollo de la Ley Orgánica y demás normativa vigente en cada
               momento, y vela por garantizar un correcto uso y tratamiento de los datos
               personales del usuario. Para ello, junto a cada formulario de recabo de datos de
               carácter personal, en los servicios que el usuario pueda solicitar a SPORARENA,
                hará saber al usuario de la existencia y aceptación de las condiciones
               particulares del tratamiento de sus datos en cada caso, informándole de la
               responsabilidad del fichero creado, la dirección del responsable, la posibilidad de
               ejercer sus derechos de acceso, rectificación, cancelación u oposición, la finalidad
               del tratamiento y las comunicaciones de datos a terceros en su caso. Asimismo,
               SPORARENA informa que da cumplimiento a la Ley 34/2002 de 11 de
               julio, de Servicios de la Sociedad de la Información y el Comercio Electrónico y le
               solicitará su consentimiento al tratamiento de su correo electrónico con fines
               comerciales en cada momento.
            </li>
            <li>PROPIEDAD INTELECTUAL E INDUSTRIAL:<br>SPORARENA por sí o
               como cesionaria, es titular de todos los derechos de propiedad intelectual e
               industrial de su página web, así como de los elementos contenidos en la misma (a
               título enunciativo, imágenes, sonido, audio, vídeo, software o textos; marcas o
               logotipos, combinaciones de colores, estructura y diseño, selección de materiales
               usados, programas de ordenador necesarios para su funcionamiento, acceso y uso,
               etc.), titularidad de SPORARENA o bien de sus licenciantes. Todos los
               derechos reservados. En virtud de lo dispuesto en los artículos 8 y 32.1, párrafo
               segundo, de la Ley de Propiedad Intelectual, quedan expresamente prohibidas la
               reproducción, la distribución y la comunicación pública, incluida su modalidad de
               puesta a disposición, de la totalidad o parte de los contenidos de esta página web,
               con fines comerciales, en cualquier soporte y por cualquier medio técnico, sin la
               autorización de SPORARENA. El USUARIO se compromete a respetar
               los derechos de Propiedad Intelectual e Industrial titularidad de SPORARENA.
                Podrá visualizar los elementos del portal e incluso imprimirlos, copiarlos
               y almacenarlos en el disco duro de su ordenador o en cualquier otro soporte físico
               siempre y cuando sea, única y exclusivamente, para su uso personal y privado. El
               USUARIO deberá abstenerse de suprimir, alterar, eludir o manipular cualquier
               dispositivo de protección o sistema de seguridad que estuviera instalado en el las
               páginas de Nombre de la empresa.
            </li>
            <li>EXCLUSIÓN DE GARANTÍAS Y RESPONSABILIDAD:<br>SPORARENA 
               no se hace responsable, en ningún caso, de los daños y perjuicios de
               cualquier naturaleza que pudieran ocasionar, a título enunciativo: errores u
               omisiones en los contenidos, falta de disponibilidad del portal o la transmisión de
               virus o programas maliciosos o lesivos en los contenidos, a pesar de haber
               adoptado todas las medidas tecnológicas necesarias para evitarlo.
            </li>
            <li>MODIFICACIONES:<br>SPORARENA se reserva el derecho de efectuar
               sin previo aviso las modificaciones que considere oportunas en su portal, pudiendo
               cambiar, suprimir o añadir tanto los contenidos y servicios que se presten a través
               de la misma como la forma en la que éstos aparezcan presentados o localizados en
               su portal.
            </li>
            <li>ENLACES:<br>En el caso de que en www.legafitnes.es se dispusiesen enlaces o
               hipervínculos hacía otros sitios de Internet, SPORARENA no ejercerá
               ningún tipo de control sobre dichos sitios y contenidos. En ningún caso SPORARENA
                asumirá responsabilidad alguna por los contenidos de algún enlace
               perteneciente a un sitio web ajeno, ni garantizará la disponibilidad técnica, calidad,
               fiabilidad, exactitud, amplitud, veracidad, validez y constitucionalidad de cualquier
               material o información contenida en ninguno de dichos hipervínculos u otros sitios
               de Internet. Igualmente la inclusión de estas conexiones externas no implicará
               ningún tipo de asociación, fusión o participación con las entidades conectadas.
            </li>
            <li>DERECHO DE EXCLUSIÓN:<br>SPORARENA se reserva el derecho a
               denegar o retirar el acceso a portal y/o los servicios ofrecidos sin necesidad de
               preaviso, a instancia propia o de un tercero, a aquellos usuarios que incumplan las
               presentes Condiciones Generales de Uso.
            </li>
            <li>GENERALIDADES:<br>SPORARENA <strong>perseguirá el incumplimiento
               </strong>de las presentes condiciones así como cualquier utilización indebida de su portal
               ejerciendo todas las acciones civiles y penales que le puedan corresponder en
               derecho.
            </li>
            <li>MODIFICACIÓN DE LAS PRESENTES CONDICIONES Y DURACIÓN:<br>SPORARENA 
               podrá modificar en cualquier momento las condiciones
               aquí determinadas, siendo debidamente publicadas como aquí aparecen. La
               vigencia de las citadas condiciones irá en función de su exposición y estarán
               vigentes hasta que sean modificadas por otras debidamente publicadas.
            </li>
            <li>LEGISLACIÓN APLICABLE Y JURISDICCIÓN:<br>La relación entre SPORARENA
                y el USUARIO se regirá por la normativa española vigente y cualquier
               controversia se someterá a los Juzgados y Tribunales de la ciudad de Lugar.
            </li>
         </ol>
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
                  $('#Dialog-Legal-Warning').dialog({
                     modal: true,
                     resizable: false,
                     width: 500,
                     height: 500,
                     buttons: [{
                                 text: 'Aceptar', 
                                 click: function(){$(this).dialog('close');}
                               },
                               {
                                 text: 'Rechazar',
                                 click: function(){$(this).dialog('close');}
                              }]
                     });
                 /*if ( ContactForm.sendContactFormToServer(dataContactForm) ) {
                     DataEntryFunctions.clearValues('#Contact-Form');
                  }*/
               }
            }
         });
      </script>
   <?php 
      //Dialog error definition in Contact form
      dialog();
   }
   
   ///////////////////////////////////////////////////////////////
   /**
    * Extracts and returns the date (dd/mm/YYYY) from a timestamp
    * @param String with the $theTimestap
    * @return String with the date in format dd/mm/YYYY
    */
   function getDateFromTimestamp($theTimestap){
      $timestamp = strtotime($theTimestap);
      $date = getDate($timestamp)['mday'] . "/" .
            getDate($timestamp)['mon'] . "/" .
            getDate($timestamp)['year'];
       
      return $date;
   }
   //////////////////////////////////////////////////////////////////////
   /**
    * Extracts the plain text from a html text to be used in preview blog
    * @param unknown $html
    * @param unknown $numchars
    * @param string $addThreePoins
    * @return string
    */
   function getPlainTextIntroFromHtml($html, $numchars, $addThreePoins = true) {
      // Remove the HTML tags
      $html = strip_tags($html);
      // Convert HTML entities to single characters
      $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
      // Make the string the desired number of characters
      // Note that substr is not good as it counts by bytes and not characters
      $html = mb_substr($html, 0, $numchars, 'UTF-8');
      if ($addThreePoins){
         // Add an elipsis
         $html .= "…";
      }
      return $html;
   }
   

   //////////////////////////////////////////////////////////////////////////
   function getNews($thePostId){
   ?>
      <script type="text/javascript">
      $('#Menu-News').addClass('Current-Page');
      </script>
      <?php
         $tbNews = new TB_News();
         $tbNews->open();
      ?>
      <article id="News" class="Main-Article Orange-Article">
         <?php
            if ($thePostId == null){ 
               while ($tbNews->next()){
                  if ($tbNews->getPublished()){
               ?>
               <div id="<?php print($tbNews->getId());?>" class="New-Preview">
                  <div class="New-Header">
                     <div class="New-Title">
                        <?php print($tbNews->getTitle());?>
                     </div>
                     <div class="New-Date">
                        <?php print(getDateFromTimestamp($tbNews->getDateTime())); ?>
                     </div>
                  </div>
                  <div>
                     <?php print(getPlainTextIntroFromHtml($tbNews->getNew(), PREVIEW_NEWS_NUM_CHARACTERS_C));?>
                  </div>
                  <a href="Noticias/<?php print(friendlyUrl($tbNews->getTitle()));?>">
                     <div id="Read-New-<?php print($tbNews->getId());?>" class="Read-New-Button Round-Corners-Button" title="Leer la Noticia">
                        Leer
                     </div>
                  </a> 
               </div>
               <?php
                  } 
               }
            }else{
               $found = false;
               while (!$found && $tbNews->next()){
                  if (strcasecmp($thePostId, friendlyUrl($tbNews->getTitle())) == 0 ){
                     $found = true;
                  }
               }
               ?>
               <div class="New-Header">
                  <div class="New-Title">
                     <?php print($tbNews->getTitle());?>
                  </div>
                  <div class="New-Date">
                     <?php print(getDateFromTimestamp($tbNews->getDateTime())); ?>
                  </div>
               </div>
               <div>
                  <?php print($tbNews->getNew());?>
               </div>
               <a href="javascript:history.back(-1);">
                  <div id="Read-New-<?php print($tbNews->getId());?>" class="Read-New-Button Round-Corners-Button" title="Volver a Noticias">
                     Volver
                  </div>
               </a> 
            <?php 
            }?>
         
      </article>
     <!-- <aside id="News-Aside">
         <div id="News-Post-Index">
            <div id="News-Last-Five-Post">
            </div>
            <div id="News-Post-By-Date">
            </div>
         </div>
         
      </aside>  -->
      
   <?php    
   }
?>