<?php 
  /** 
   * Button
   * 
   * for creating a bootstrap button 
   * see http://getbootstrap.com/components/#btn-groups-sizing
   * By Nick Mullen 5/may/2015 
   *
   */
   
    namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

    /**
     * @author nick mullen
     * @version V1.0
     */
  class Button  extends Meta  {
  
  /**
    * @var string size of the button options large| small | extrasmall':
    **/
  private $size; 
  
  /**
   * @var string text to be display 
   **/
  private $text;

  /**
   *@var boolead display as block 
   */
  private $block;
  
  /**
   * @var string button is selected 
   */
  private $active;

  /**
   * @var boolean button is disabled 
   */
  private $disabled;

	public function  __construct() {}

	/**
	  * add a button
    * @param string $text display text
    * @param string $style css style to apply
    * @param string $size   large| small | extrasmall
    * @param boolean $block display as block
    * @param boolean $disabled disable the button
	  */
	public function addItem($text,$style,$size=Null,$block=Null,$active=Null,$disabled=Null) {
		$this->text =  $text;
    $this->setStyle($style);
    $this->setSize($size);
    if($block){
      $this->setBlock();
    }
    if($active){
      $this->setActive();
    }
    if($disabled){
      $this->setDisabled();
    }    
  }

 /**
    * set diplay as Disabled
    * @return boolean disabled
    */
  public function setDisabled() {
    return $this->disabled = True;
  }

  /**
    * get display as Disabled
    * @return boolean disabled
    */
  public function getDisabled() {
    return $this->disabled;
  }

  /**
    * set display as Active
    * @return boolean is bitton active
    */
  public function setActive() {
    return $this->active = ' active ';
  }

  /**
    * get display as Active
    * @return boolean is bitton active
    */
  public function getActive() {
    return $this->active;
  }

  /**
    * set display as block
    * @return string block style
    */
  public function setBlock() {
    return $this->block = ' btn-block ';
  }

  /**
    * @return string display as block
    */
  public function getBlock() {
    return $this->block;
  }
  
  /**
    * get size
    * @return string the sixe of the button
    */
  public function getSize() {
    return $this->size;
  }

  /**
    * set size
    * @param string $size 
    */
  public function setSize($size) {
    switch (strtolower ($size)) {
      case 'large':
        $this->size = ' btn-lg ';
        break;
      case 'small':
        $this->size = ' btn-sm ';
        break;
      case 'extrasmall':
        $this->size = ' btn-xs ';
        break;
    }
  }

  /**
    * set style
    * @param string $style css style
    */
  public function setStyle($style) {
    switch (strtolower ($style)) {
      case 'primary':
        $this->setClass(' btn-primary ');
        break;
      case 'success':
        $this->setClass(' btn-success ');
        break;
      case 'info':
        $this->setClass(' btn-info ');
        break;
      case 'warning':
        $this->setClass(' btn-warning ');
        break;
      case 'danger':
        $this->setClass(' btn-danger ');
        break;
      case 'link':
        $this->setClass(' btn-link ');
        break;
    }
  }

  /**
    * return the text
    * 
    * @return string the display text
    */
	public function getText() {
		return  $this->text;
  }

 	/**
  	*  output the object   
    *   @param string $type type ofmarkup
    *   @return string raw markup
  	*/
	public function render($type) {
  	if ($type == 'html') {
  		$content = $this->renderHTML();
  	} else{
    		throw $this->createNotFoundException( 'type not found for'.$type);
  	}
		return $content;
  }

  

  /**
   * render the button as html
   * @return string button as html
   * 
   */
	 private function renderHTML() {
    $content = '';
    $content = $content.'<button type="button" ';
    $content = $content.$this->renderClass('btn '.$this->getSize().$this->getBlock().$this->getActive() );
    $content = $content.$this->renderID();
    if($this->getDisabled()){
      $content = $content.'disabled="disabled"';
    }
 		$content = $content.' >'.$this->getText().'</button>';
		return $content;
	}
}