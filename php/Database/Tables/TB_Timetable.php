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
   
   class TB_Timetable extends GenericTable {

     private $loggerM;

     /*
      * Constant Table Name
      */
     const TB_TimetableTableC = "TB_Timetable";

 
     /*
      * Contants table columns
      */
     const IdColumnC = "Id";
     const NameColumnC = "Name";
     const DetailColumnC = "Detail";
      
      /*** Phisical constants ***/

   
      const phisicalTB_TIMETABLEC = "TB_TIMETABLE";
      const phisicalTB_TIMETABLEIdColumnC = "Id";
      const phisicalTB_TIMETABLENameColumnC = "Name";
      const phisicalTB_TIMETABLEDetailColumnC = "Detail";

     /*
      * Constructor. The table definition is done here
      */
	public function __construct(){
      $this->loggerM = LoggerMgr::Instance()->getLogger(__CLASS__);
       
      $this->loggerM->trace("Enter");
        parent::__construct();
		$this->tableDefinitionM = new TableDef(self::TB_TimetableTableC);
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::IdColumnC,ColumnType::integerC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::NameColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addColumn(new ColumnDef(
                              self::DetailColumnC,ColumnType::stringC));
		$this->tableDefinitionM->addKey(self::IdColumnC);
   
      $this->tableMappingM = new TableMapping();
      
      $this->tableMappingM->addTable(self::phisicalTB_TIMETABLEC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_TIMETABLEC ,
            self::phisicalTB_TIMETABLEIdColumnC ,
            self::IdColumnC,
            ColumnType::integerC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_TIMETABLEC ,
            self::phisicalTB_TIMETABLENameColumnC ,
            self::NameColumnC,
            ColumnType::stringC);
      $this->tableMappingM->addColumn(
            self::phisicalTB_TIMETABLEC ,
            self::phisicalTB_TIMETABLEDetailColumnC ,
            self::DetailColumnC,
            ColumnType::stringC);
      
      $this->tableMappingM->addKey(self::phisicalTB_TIMETABLEC,
            self::phisicalTB_TIMETABLEIdColumnC );
      
      
      $this->loggerM->trace("Exit");
	}
      
      public function insert( $theName
                              ,$theDetail
                                ){
         $this->loggerM->trace("Enter");
         $arrayData = array();
         $arrayData[self::NameColumnC] = $theName;
         $arrayData[self::DetailColumnC] = $theDetail;
         $this->loggerM->trace("Exit");

         return parent::insertData($arrayData);
      }
      
      public function getId(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::IdColumnC);
      }
      
      public function getName(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::NameColumnC);
      }
      
      public function setName($Name){
         $this->loggerM->trace("Enter");
         $this->set(self::NameColumnC, $Name);
         $this->loggerM->trace("Exit");
      }
      public function getDetail(){
         $this->loggerM->trace("Enter/Exit");
         return $this->get(self::DetailColumnC);
      }
      
      public function setDetail($Detail){
         $this->loggerM->trace("Enter");
         $this->set(self::DetailColumnC, $Detail);
         $this->loggerM->trace("Exit");
      }

      public function getTableName(){
         $this->loggerM->trace("Enter / Exit");
         return self::TB_TimetableTableC;
      }
   }
?>
