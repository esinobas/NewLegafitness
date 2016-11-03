<?php
   /**
    * Class with the specific methods and properties to access to the table data
    * 
    * In this class the logical structure table is defined.
    */
   
   /*if ( ! strpos(get_include_path(), dirname(__FILE__))){ 
      set_include_path( get_include_path() . PATH_SEPARATOR . dirname(__FILE__));
   }*/
   
   require_once 'php/Database/Core/TableDef.php';
   require_once 'php/Database/Core/ColumnDef.php';
   require_once 'php/Database/Core/ColumnType.php';
   require_once 'php/Database/Core/TableMapping.php';
   require_once 'php/Database/Core/GenericTable.php';
   
   include_once 'php/LoggerMgr/LoggerMgr.php';

   class TB_User extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_UserTableC = "TB_User";

 
     /*
      * Contants table columns
      */
     const UsuarioColumnC = "Usuario";
     const PasswordColumnC = "Password";
     const NombreColumnC = "Nombre";
     const ApellidosColumnC = "Apellidos";
      
      /*** Phisical constants ***/

   
      const phisicalTBUserC = "TB_Users";
      const phisicalTBUserUserColumnC = "User";
      const phisicalTBUserPasswordColumnC = "Password";
      const phisicalTBUserNameColumnC = "Name";
      const phisicalTBUserSurnameColumnC = "Surname";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_UserTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::UsuarioColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::PasswordColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::NombreColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ApellidosColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::UsuarioColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTBUserC);
      $this->tableMappingM->addColumn(
            self::phisicalTBUserC ,
            self::phisicalTBUserUserColumnC ,
            self::UsuarioColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTBUserC ,
            self::phisicalTBUserPasswordColumnC ,
            self::PasswordColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTBUserC ,
            self::phisicalTBUserNameColumnC ,
            self::NombreColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTBUserC ,
            self::phisicalTBUserSurnameColumnC ,
            self::ApellidosColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTBUserC,
            self::phisicalTBUserUserColumnC );
      
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $thePassword
                              ,$theNombre
                              ,$theApellidos
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::PasswordColumnC] = $thePassword;
         $arrayData[self::NombreColumnC] = $theNombre;
         $arrayData[self::ApellidosColumnC] = $theApellidos;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getUsuario(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::UsuarioColumnC);
      }
      
      public function getPassword(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::PasswordColumnC);
      }
      
      public function setPassword($Password){
         $this->loggerM->trace("Enter");
         $this->set(self::PasswordColumnC, $Password);
         $this->loggerM->trace("Exit");
      }
      public function getNombre(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::NombreColumnC);
      }
      
      public function setNombre($Nombre){
         $this->loggerM->trace("Enter");
         $this->set(self::NombreColumnC, $Nombre);
         $this->loggerM->trace("Exit");
      }
      public function getApellidos(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ApellidosColumnC);
      }
      
      public function setApellidos($Apellidos){
         $this->loggerM->trace("Enter");
         $this->set(self::ApellidosColumnC, $Apellidos);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_UserTableC;
      }
   }
?>
