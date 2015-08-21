<?php 
/** 
  * Badge.
  * 
  * Bootstrap Badge
  * by Nick Mullen 26/May/2015 
  */

   namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * bootstrap badge
   * 
   * @link http://getbootstrap.com/components/#badges bootstrap site
   * @author Nick Mullen 
   * @version 1.0
  */
  Class Badge extends Meta {

    /**
      * @var string $text the display text of the badge
      */
  	private $text;

  	public function  __construct() {}

    /**
     * set the text valable
     * @param string $text the text to be displayed
     * @return string text to be displayed
     */
    public function setText($text) {
      $this->text = $text;
    }

    /**
     * get the text var
     * @return string the text to be displayed
     */
    public function getText() {
      return $this->text;
    }

   	/**
    	* output the object as markup
      * @param string $type the type of markup   
      * @return string raw markup
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
     * render the badge as html
     * @return string raw html markup
     */
  	private function renderHTML() {
      $content = '';
      $content = $content.'<span '; 
      $content = $content.$this->renderClass(' badge');
      $content = $content.$this->renderID();
   		$content = $content.' >'.$this->getText().'</span>';
  		return $content;
  	}
  }