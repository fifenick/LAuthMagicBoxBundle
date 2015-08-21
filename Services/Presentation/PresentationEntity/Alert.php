<?php 
/** 
 * Alert.
 * 
 * A service for creating bootstrop alert box
 * by Nick Mullen 24/April/2015 
 * testing: phpunit -c app src/team/coreBundle/Tests/Services/PageAlertTest.php
 */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * bootstrap alert
   * 
   * @author Nick Mullen 
   * @link http://getbootstrap.com/components/#alerts Bootstrap site
   * @version 1.0
   */

Class Alert extends Meta {

  /**
   *@var array $alert arry to hold all details about the alert 
   */
	private $alert = array();

	public function  __construct() {
    $this->int(); 
  }
  
  /**
   * Initialize the alert
   */
  public function int() {
    $this->setClass('alert'); 
  }

	/**
	 * add an alert item to the alert array
   * @param string $title  the title of the alert
   * @param string $text the main text to be displayed
   * @param string $type the type of display style to be applyed 
	 */
	public function addAlert($title,$text,$type) {
		$item['title'] =  $title;
		$item['text'] =  $text;
		$item['type'] =  $type;
 		array_push($this->alert, $item);
  }

  /**
   * return the alert array
   * @return object the alert object 
   */
	public function getAlert() {
		return  $this->alert;
  }

 	/**
  	* output the object as markup
    * @param string $type the type of markup
    * @param string $content the raw markup
  	*/
	public function render($type) {
  	if (mb_strtolower($type) == 'html') {
  		$content = $this->renderHTML();
  	} else{
    		throw $this->createNotFoundException( 'type not found for'.$type);
  	}
		return $content;
  }

  /**
   * render the alert as html
   * @return string the raw html
   */
	private function renderHTML() {
    $content = '';
   	foreach ($this->getAlert() as $item) {
      $content = $content.'<div'; 
      $content = $content.$this->renderClass($item['type']);
      $content = $content.$this->renderID();
   		$content = $content.' role="alert"><strong>'.$item['title'].'</strong>'.$item['text'].'</div>';
    }
		return $content;
	}
}