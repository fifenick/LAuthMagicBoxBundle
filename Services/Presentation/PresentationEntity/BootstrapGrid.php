<?php 
  /* 
   * BootStrapGrid
   * for creating a bootstrap grid layout
   * By Nick Mullen 27/April/2015 
   *
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * @author nick mullen
   * @version 1.0
   * @link http://getbootstrap.com/css/ the bootstrap site
   */
  class BootstrapGrid{

    /**
     * @var array to hold grid details 
     */
  	private $grid = array();

    /**
      * @var boolean use fluid container
      */
    private $fluidContainer;


  	public function  __construct() {
      $this->fluidContainer = false;
    }
  
    /**
     * set the fluid grid option
     * @param boolean $value set use fluid grid to true|false
     * @return boolean use fluidContainer or not
     */
    public function setFluidContainer($value) {
      return $this->fluidContainer= $value;
    }

    /**
     * return the fluid container setting
     * @return boolean use fluidContainer or not
     */
    public function getFluidContainer() {
     return $this->fluidContainer;
    }

  /**
   * @todo split this down into smaller functions - remove grid options
   * add a grid cell
   * @param array $param grid options
   * row = the row number
   * order = the cell order
   * md_push = change the order of the grid columns 
   * md_pull = change the order of the grid columns 
   * md_offset = increase the left margin of a column
   * smvisible = visible on small screens
   * mdvisible = visible on medium screens
   * xsvisible = visible on extra small screens
   * content = the code to be displayed in the cell
   * sm_span = cell span for small screens
   * md_span = cell span for medium screens
   * xs_span = cell span for Extra small screens
   * fluidcontainer = use a fluid container
   * class = add class to the cell
   * id = ad an id to the cell
   * 
   * @return array array of grid settings
   * 
   */
   public function additem( array $params) {
    $defaults = array( 'row'=>'', 'order'=>'', 'xsvisible'=>Null, 'mdpush'=>Null, 'mdpull'=>Null,  'smvisible'=>Null, 'mdvisible'=>Null,  'content'=>Null, 'mdoffset'=>Null,'smspan'=>Null, 'mdspan'=>Null,'xsspan'=>Null, 'class'=>Null, 'id'=>Null);
    $args = array_merge($defaults, array_intersect_key($params, $defaults));
    list( $row, $order,$xsvisible,$mdpush, $mdpull, $smvisible , $mdvisible,$content,$mdoffset, $smspan, $mdspan, $xsspan, $class, $id) = array_values($args);
      
    $item = '';
    $item['Content'] = $content;
    $item['Mdspan'] = $mdspan;
    $item['Xsspan'] = $xsspan;
    $item['Smspan'] = $smspan;
    $item['Class'] = $class;
    $item['Xsvisible'] = $xsvisible;
    $item['Smvisible'] = $smvisible;
    $item['Mdvisible'] = $mdvisible;
    $item['Mdoffset'] = $mdoffset; 
    $item['Mdpush'] = $mdpush;
    $item['Mdpull'] = $mdpull;
    $item['Id'] = $id;

    if(isset($this->grid[$row])){
      $tableRow = $this->grid[$row]; 
    }else{
      // new row
      $tableRow = '';
    }
    if ($order !== NULL){
      $tableRow[$order] = $item;
    }else{
      array_push( $tableRow[$item]);
    }
    $this->grid[$row] =  $tableRow;
    return $this->grid;
  }

  /**
  * render the grid
  * @param string $type the markup type
  * @return string the raw markup
  */
  public function render($type) {
    if ($type == 'html') {
        $content = $this->renderHTML();
    }
    return $content;
  }

  /**
  * render as html
  * @return string the html grid
  */
  public function renderHTML() {
    $content = '';

    if ($this->getFluidContainer() == True){
      $content = '<div class="container-fluid">';
    }else{
      $content = '<div class="container">';
    }

    foreach ($this->grid  as $row) {
      $content = $content.'<div class="row">';
      foreach ($row  as $item) {
        $content = $content.'<div class="';
        /** col spans */
        if(isset($item['Mdspan'] ) && $item['Mdspan'] !== Null){
          $content = $content.' col-md-'.$item['Mdspan'];
        }
        if(isset($item['Xsspan'] ) && $item['Xsspan'] !== Null){
          $content = $content.' col-xs-'.$item['Xsspan'];
        }
        if(isset($item['Smspan'] ) && $item['Smspan'] !== Null){
          $content = $content.' col-sm-'.$item['Smspan'];
        }
        /** Add the visible block */
        if(isset( $item['Xsvisible']  ) &&  $item['Xsvisible']  !== Null){
          $content = $content.' clearfix visible-xs-block';
        }
        if(isset($item['Smvisible'] ) && $item['Smvisible']  !== Null){
          $content = $content.' clearfix visible-sm-block';
        }
        if(isset($item['Mdvisible']) && $item['Mdvisible'] !== Null){
          $content = $content.' clearfix visible-md-block';
        }
        /** add any offset */
       if(isset(  $item['Mdoffset']  ) &&   $item['Mdoffset']  !== Null){
          $content = $content.' col-md-offset-'.$item['Mdoffset'];
        }
        if(isset($item['Sxoffset']) && $item['Sxoffset']  !== Null){
          $content = $content.' col-sx-offset-'.$item['Sxoffset'];
        }
        if(isset($item['Smoffset']) && $item['Smoffset'] !== Null){
          $content = $content.' col-sm-offset-'.$item['Smoffset'];
        }
        /** add any push */
        if(isset($item['Mdpush']) && $item['Mdpush'] !== Null){
          $content = $content.' col-md-push-'.$item['Mdpush'];
        }
        /** add any pull */
        if(isset($item['Mdpull']) && $item['Mdpull'] !== Null){
          $content = $content.' col-md-pull-'.$item['Mdpull'];
        }
        /** add any other class */
        if($item['Class'] !== Null){
          $content = $content.' '.$item['Class'].' ';
        }
        /** add an ID */
        $content = $content.'" ';
        if( $item['Id'] !== Null){
          $content = $content.' id="'.$item['Id'].'" ';
        }
        $content = $content.'>';
        $content = $content.$item['Content'];
        $content = $content.'</div>';
      }
      $content = $content.'</div>';
    }
    $content = $content.'</div>';
    return $content;
  }
}