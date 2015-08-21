<?php 
  /** 
    *  Table
    * 
    * for creating bootstrap tables
    * By Nick Mullen 14/April/2015 
    */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;
  use Symfony\Component\HttpKernel\Exception\HttpException;

  /**
   * @author nick mullen
   * @version v1.0
   */
  class Table extends Meta  {
  	
    /**
     * @var arrat holds table rows 
     */
    private $table = array();

    /**
     * @var array holds a table row  
     */
    private $tableRow = array();

    /**
     * @var array icons to use 
     */
    private $icons = array();

  	public function  __construct() {}

    /**
     * add a cell to a table 
     * @todo split into row and cell options
     * @param array $params cell options 
     * label= the item to be displayed
     * order= the numeric cell order within the row
     * row = the numeric row order within the table
     * colSpan= a col span value
     * cellClass= add a class to the cell
     * cellId= add an id to the cell
     * icon = add an ison to the cell
     * 
     * rowClass= add a class to the row
     * rowID=  add an id to the row
     * head = boolean value, the row is within the tabe head
     * body = boolean value, the row is within the table body
     * foot = boolean valuem the row is within the foot of the header
     */
    public function addItem(array $params) {
      $defaults = array( 'label'=>'', 'order'=>'','row'=>'','colSpan'=>Null, 'cellClass'=>Null, 'cellId'=>Null, 'rowClass'=>Null, 'rowID'=>Null, 'head'=>Null,'body'=>Null,'foot'=>Null,'icon'=>Null);
      $args = array_merge($defaults, array_intersect_key($params, $defaults));
      list($label,$order,$row,$colSpan,$cellClass,$cellId,$rowClass,$rowID,$head,$body,$foot,$icon) = array_values($args);
         
      $cell['label'] = $label;
      $cell['span'] = $colSpan;
      $cell['cellClass'] = $cellClass;
      $cell['cellId'] = $cellId;
      $cell['icon'] = $icon;

      // add row settings
      $tableRow = $this->setRow($row,$rowClass,$rowID,$head,$body,$foot);
      // add cell
      $tableRow['cells'][$order] = $cell;
      $this->table[$row] = $tableRow;
      return  $this->table;
    }

    /**
      * add row settings
      * 
      * @param numeric $row the row position within the table
      * @param string $rowClass add a class to the row
      * @param string $rowID  add an id to the row
      * @param boolean  $head   boolean value, the row is within the tabe head
      * @param boolean $body   boolean value, the row is within the table body
      * @param boolean $foot   boolean valuem the row is within the foot of the header
      * 
      */
    public function setRow($row,$rowClass = Null,$rowID = Null,$head = Null,$body = Null,$foot = Null) {

      if(isset($this->table[$row])){
        $tableRow = $this->table[$row]; 
      }else{
        $tableRow = array();
      }
      if ($rowClass !== Null ){
        $tableRow['rowClass'] = $rowClass;
      }else{
        $tableRow['rowClass'] = Null;
      }
      if ($head !== Null ){
        $tableRow['head'] = $head;
      }else{
        $tableRow['head'] = Null;
      }
      if ($rowID !== Null){
        $tableRow['rowID'] = $rowID;
      }else{
        $tableRow['rowID'] = Null;
      }
      return  $tableRow;
    }

    /**
     * return the table
     * 
     * @return array returnt the main table array
     */
    public function getTable() {
      return  $this->table;
    }

    /**
     * set icons
     * 
     * @param array $icons array of icons to be displayed
     * @return array return array of icons
     */
    public function setIcons($icons) {
      return  $this->icons = $icons;
    }

    /**
     * get icons
     * 
     * @return array return array of icons
     */
    public function getIcons() {
      return  $this->icons;
    }

    /**
     * set table rows
     * 
     * @param array $rows table rows
     * @return array table
     */
    public function setRows($rows){
      foreach ($rows as $row) {
        foreach ($row as $cell) {
          $defaults = array( 'label'=>'', 'order'=>'','row'=>'','colSpan'=>Null, 'cellClass'=>Null, 'cellId'=>Null, 'rowClass'=>Null, 'rowID'=>Null, 'head'=>Null,'body'=>Null,'foot'=>Null,'icon'=>Null);
          $args = array_merge($defaults, array_intersect_key($cell, $defaults));
          $this->addItem($args);
        }
      }
    }

    /**
     * render the table
     * 
     * @param string $type markup type
     * @return string raw markup
     */
    public function render($type) {
      if (strtolower($type) == 'html') {
          $content = $this->renderHTML();
        }else{
          throw $this->createNotFoundException( 'type not found for'.$type);
        }
      return $content;
    }

      /**
      * render the table a html
      * @return string table rendard as html
      */
      private function renderHTML() {
        $content = '<table';
        $content = $content.$this->renderClass();
        $content = $content.$this->renderID();
        $content = $content.'>';
        /** add a row */
        foreach ($this->table as $row) {    
      
          if ($row['head'] == true){
            $content = $content.'<thead><tr';
          }else{
            $content = $content.'<tr';
          }
          
          if ($row['rowClass'] !== Null){
            $content = $content.' class="'.$row['rowClass'].'" ';
          }

          if ($row['rowID']  !== Null){
              $content = $content.' class="'.$row['rowID'].'" ';
          }

          $content = $content.'>';
          /** add cells */
          $r = 0;
          foreach ($row['cells']  as $cell) {
            if ($row['head'] == true){
              $content = $content.'<th';
            }else{
              $content = $content.'<td';
            }
            

            if ($cell['span'] !== Null){
                $content = $content.' colspan="'.$cell['span'].'" ';
            }
            
            $content = $content.'>'.$cell['label'];
            
            if ($row['head'] == true){
              if(isset($this->icons[$r]) && $this->icons !== Null ){
                $content = $content.'&nbsp;<i class="'.$this->icons[$r].'"></i>';
              }
              if(isset($cell['icon']) && $cell['icon'] !== Null ){
                $content = $content.'&nbsp;<i class="'.$cell['icon'].'"></i>';
              }
           
              $content = $content.'</th>';
            }else{

              if(isset($cell['icon']) && $cell['icon'] !== Null ){
                $content = $content.'&nbsp;<i class="'.$cell['icon'].'"></i>';
              }

              $content = $content.'</td>';
            }
            $r++;
          }

          /** close row */
          if ($row['head'] == true){
            $content = $content.'</tr></thead>';
          }else{
            $content = $content.'</tr>';
          }
        }

        $content = $content.'</table>';
        return $content;
      }
  }