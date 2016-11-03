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

   class TB_Activity extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_ActivityTableC = "TB_Activity";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const NombreColumnC = "Nombre";
     const ColorColumnC = "Color";
     const ImageColumnC = "Image";
      
      /*** Phisical constants ***/

   
      const phisicalTB_ACTIVIDADC = "TB_ACTIVIDAD";
      const phisicalTB_ACTIVIDADIDColumnC = "ID";
      const phisicalTB_ACTIVIDADNameColumnC = "Name";
      const phisicalTB_ACTIVIDADColorColumnC = "Color";
      const phisicalTB_ACTIVIDADImageColumnC = "Image";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_ActivityTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::NombreColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ColorColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::ImageColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_ACTIVIDADC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_ACTIVIDADC ,
            self::phisicalTB_ACTIVIDADIDColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_ACTIVIDADC ,
            self::phisicalTB_ACTIVIDADNameColumnC ,
            self::NombreColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_ACTIVIDADC ,
            self::phisicalTB_ACTIVIDADColorColumnC ,
            self::ColorColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_ACTIVIDADC ,
            self::phisicalTB_ACTIVIDADImageColumnC ,
            self::ImageColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_ACTIVIDADC,
            self::phisicalTB_ACTIVIDADIDColumnC );
      
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theNombre
                              ,$theColor
                              ,$theImage
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::NombreColumnC] = $theNombre;
         $arrayData[self::ColorColumnC] = $theColor;
         $arrayData[self::ImageColumnC] = $theImage;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
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
      public function getColor(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ColorColumnC);
      }
      
      public function setColor($Color){
         $this->loggerM->trace("Enter");
         $this->set(self::ColorColumnC, $Color);
         $this->loggerM->trace("Exit");
      }
      public function getImage(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::ImageColumnC);
      }
      
      public function setImage($Image){
         $this->loggerM->trace("Enter");
         $this->set(self::ImageColumnC, $Image);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_ActivityTableC;
      }
   }
?>
