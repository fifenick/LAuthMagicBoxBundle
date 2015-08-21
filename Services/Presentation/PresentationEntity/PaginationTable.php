<?php 
  /* 
   * PaginationTable
   * 
   * for creating bootstrap data table pagination
   * By Nick Mullen 26/May/2015 
   *
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Pagination as Pagination;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Table as Table;

  /**
   * @author nick mullen
   * @version v1.0
   */ 
  class PaginationTable extends Meta {

 
    /**
      * hold the controls
      * @var object Pagination object
      */
  	private $pagePagination;

    /**
      * hold the table
      * @var object table object
      */
    private $pageTable;


  	public function  __construct(Table $PageTable,Pagination $PagePagination) {
      $this->pageTable = $PageTable;
      $this->pagePagination = $PagePagination;
    }


  /**
    * set the start row number  
    * 
    * @param numeric $currentPage curent page number
    * @param numeric $recordsPerPage number of records per page
    */	
  public function setStartRow($currentPage,$recordsPerPage){
    $this->startRow = ($currentPage - 1) * $recordsPerPage; 
      if ($this->startRow < 0){
        $this->startRow = 0;
      }
   }
  
  /**
    * set the end row number
    * 
    * @param numeric $startRow the starting row
    * @param numeric $recordsperpage the number of rows per page
    */
  public function setEndRow($startRow,$recordsPerPage){
    $this->endRow = $startRow + $recordsPerPage;
    if($this->endRow >  count($this->dataSet) ){
      $this->endRow = count($this->dataSet);
    }
   }

   /**
     * Add a class to the table
     * @param string $style style to be added to the table
     */
  public function setTableClass($styles){
    $this->tableStyles = $styles;
  }

  /**
    * set the header icons
    * @param array $icons array of icons that are to be added to the table headings
    */
  public function setIcons($icons){
    $this->icons = $icons;
  }


  /**
   * set the Pagination settings
   * @param array $params pagination settings
   *  options are:
   *  $Controls = display  back and next controls
   *  $URL = the post url
   *  $DataSet = array of the data to page
   *  $Columns =  array the of date columns to be used
   *  $CurrentPage = current page number
   *  $recordsPerPage = number of rows per page
   *  $ColumnLabels = array to override the column name with user friendly labels
   *  $Size = display size (large or small)
   *  $Icons = array of table header icons
   *  $Links = add a link column to the table
   */
  public function setPagination($params) {
    $defaults = array(
                'Controls'=>Null,
                'URL'=>Null,
                'DataSet'=>Null,
                'Columns'=>Null,
                'CurrentPage'=>1,
                'recordsPerPage'=>1,
                'ColumnLabels'=>Null,
                'Size'=>Null,
                'Icons'=>Null,
                'Links'=>Null);

    $args = array_merge($defaults, array_intersect_key($params, $defaults));
    list(
      $Controls,
      $URL,
      $DataSet,
      $Columns,
      $CurrentPage,
      $recordsPerPage,
      $ColumnLabels,
      $Size,
      $Icons,
      $Links) = array_values($args);

//die(var_dump($DataSet));

    /** 
      * If the number of recordsperpage is greater than the max number of records, set the
      *  recordsperpage to max number of records 
      */
    if($recordsPerPage > sizeof($DataSet)){
      $recordsPerPage = sizeof($DataSet);
    }


    $this->recordsPerPage  = $recordsPerPage;
    $this->controls = $Controls;
    $this->url = $URL;
    $this->icons = $Icons;
    $this->dataSet = $DataSet;
    $this->columns = $Columns;
    $this->currentPage = $CurrentPage;
    $this->columnLabels=$ColumnLabels;
    $this->links=$Links;
    $NoRecrecords = sizeof($DataSet);
    $this->setStartRow($CurrentPage,$recordsPerPage);
    $this->setEndRow($this->startRow,$recordsPerPage);
    /** set the Pagination control **/
    $this->pagePagination->setPagination($Controls,$this->url,$Size,Null,$NoRecrecords,$this->recordsPerPage,$CurrentPage);
  }
  
 	/**
  	*  output the object   
    * @param string $type the markup to be displayed 
  	*/
	public function render($type) {
  	if (strtolower($type) == 'html') {
  		$content = $this->renderHTML();
  	} else{
    		throw $this->createNotFoundException( 'type not found for'.$type);
  	}
		return $content;
  }

  /**
   * render the pagingtable as html
   * @return string the paginationtable as html
   */
	public function renderHTML() {
    /*  row counter */
    $row = 0;
    /* Colum counter */
    $order = 1;
    $col = $this->columns;
    /* Apply header icons to table  if passed */
    if(isset($this->icons) && $this->icons !== Null){
        $this->pageTable->setIcons($this->icons);      
    }
    /** Set the table style if passed */
    if(isset($this->tableStyles) && $this->tableStyles !== Null){
        $this->pageTable->setClass($this->tableStyles);      
    }
    
    /** add table header  */
    if(sizeof($col) > 0){
      foreach ($col as $Header ) {
        if(isset($this->columnLabels) && isset($this->columnLabels[$order - 1]) && $this->columnLabels !== Null){
          $Header = $this->columnLabels[$order - 1];
        }
        $this->pageTable->additem(array('label'=>$Header,'order'=>$order,'row'=>$row,'head'=>true));
        $order++;
      }
      if(isset($this->link) && $this->link !== Null){
        $this->pageTable->additem(array('label'=>'','order'=>$order,'row'=>$row,'head'=>true));
      }
      $row = 2;
    }
    
    /** add data to table */
    for($i = $this->startRow, $this->endRow; $i < $this->endRow; $i++){
      $order = 1;
      foreach ($col as $Labels ) {  
          $this->pageTable->additem(array('label'=>$this->dataSet[$i][$Labels],'order'=>$order,'row'=>$row,'head'=>false));
         $order++;
      }

    /** add data links as cols */
    foreach ($this->links as $link) {
      if(isset($link) && $link !== Null){
        $idCol = $link['Column'];
        $mylabel = "<a  ";
        /** class to link */
        if (isset($link['Class']) && $link['Class'] !== Null){
          $mylabel = $mylabel.'class ="'.$link['Class'].'"';
        }
        $mylabel = $mylabel.' href="'.$link['URL'].'&id='.$this->dataSet[$i][$idCol].'">'.$link['Label'].'</a>';
               
        if(isset($link['Icon']) && $link['Icon']!== Null){
          $myicon = $link['Icon'];
        }else{
          $myicon = Null;
        }
        $this->pageTable->additem(array('label'=>$mylabel,'order'=>$order,'row'=>$row,'head'=>false, 'icon'=>$myicon ));   
        $order++;
      }
    }
    $row++;     
  }
    
  $content = '<div';    
  $content = $content.$this->renderClass();
  $content = $content.$this->renderID();
  $content = $content.'>';
  $content = $content.$this->pageTable->render('html');
  $content = $content.$this->pagePagination->render('html');
  $content = $content.'</div>';
  return  $content;
	}
}