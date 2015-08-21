<?php 
  /** 
   * Tab
   * 
   * for creating a bootstrap tab bar
   * By Nick Mullen 30/April/2015 
   *
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * @author nick mullen
   * @link http://getbootstrap.com/javascript/#tabs bootstrap site
   * @version v1.0 
   */
  class Tab extends Meta {

  /**
   *  @var array hold tab values 
   */
	private $tab = array();

  /**
   *  @var boolean show tabs as pills 
   */
  private $pills = Null;

  /**
   * make tabs or pills equal widths
   */
  private $justified = Null;


	public function  __construct() { }

	/**
	 * add a tab
   *
   * @param string $title the title (link text) displayed
   * @param string $text the main display 
   * @param numeric $order display order
   * @param boolean $pills display as pills
   * @param boolean $justified display tabs with equal width
   * @return array tabs array
	 */
	public function addTab($title,$text,$order,$pills = Null,$justified=Null) {
		$tab['title'] =  $title;
		$tab['text'] =  $text;
		$tab['order'] =  $order;
    $tab['id'] = $this->getRandId();
    
    if (is_numeric($order) == false) {
      echo "'{$order}' is not numeric", PHP_EOL;
      break;
    }
 		
    // add tab to array of tabs
    array_push($this->tab , $tab);
    
    // set Justification
    if($justified !== Null){
      $this->setJustified($justified);
    }

    // set pills
    if($pills !== Null){
      $this->setPills($pills);
    }

    return $this->tab;
  }

  /**
   *  getRandId
   * 
   * @param int $lenght length of id
   * @return string random id
   */
  public function getRandId($length = 5){
   return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
  }

  /**
   * setJustified
   * 
   * @param boolean $justified pills or tabs equal width
   */
  public function setJustified($justified){
    if(isset($justified) && $justified== 'True'){
      $this->justified = 'True';
    }else{
      $this->justified = 'False';
    }
  }

  /**
   *  setPills
   * 
   * @param boolean $pills display as spills 
   */
  public function setPills($pills){
    if(isset($pills) && $pills== 'True'){
      $this->pills = 'True';
    }else{
      $this->pills = 'False';
    }
  } 

  /**
   * return the tab
   * @return array the tab array
   */
	public function getTab() {
     usort($this->tab, function($a, $b) {
        return $a['order'] - $b['order'];
    });
		return  $this->tab;
  }

 	/**
  	* output the object   
    * 
    * @param string $type the markup type
    * @return string the tab as markup 
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
   * has content
   * 
   * @return boolean if the tabe has any set values 
   */
 private function hasContent(){
    if(sizeof($this->tab) > 0 ){
      return True;
      break;
    }else{
      return false;
      break;
    }
  }

  /**
   * render the alert as html
   * @return string tab as html
   */
	private function renderHTML() {
    $content = '';
    if($this->hasContent()) {
     	foreach ($this->getTab() as $tab) {
        $content = '<ul ';
        if($this->pills !== 'True'){
          if($this->justified !== 'True'){
            $content = $content.$this->renderClass('nav nav-tabs');
          }else{
            $content = $content.$this->renderClass('nav nav-tabs nav-justified');
          }
        }else{  
           if($this->justified !== 'True'){
              $content = $content.$this->renderClass('nav nav-pills');
            }else{
              $content = $content.$this->renderClass('nav nav-pills nav-justified');
            }
        }
        $content = $content.$this->renderID(' tabs ');
        $content = $content.' data-tabs="tabs">';
        $i = 0;
        foreach ($this->getTab() as $tab) {
          $content = $content.'<li role="presentation" ';       
          if($i == 0){
            $content = $content.' class="active" ';
          }
          $content = $content.'><a href="#'.$tab['id'].'" data-toggle="tab">'.$tab['title'].'</a></li>';
          $i++;
        }
        $content = $content.'</ul>';
     	}

      $content = $content.'<div id="my-tab-content" class="tab-content">';
      $x = 0;
      foreach ($this->getTab() as $tab) {
        $content = $content.'<div class="tab-pane ';
        if($x == 0){
            $content = $content.' active ';
          } 
        $content = $content.'" id="'.$tab['id'].'">'.$tab['text'].'</div>';
        $x++;
      }
          
      $content = $content.'</div>';

      // add javascript
      $content = $content.'<script type="text/javascript">jQuery(document).ready(function ($){$("#tabs").tab();});</script>';
    }
		return $content;
	}
}