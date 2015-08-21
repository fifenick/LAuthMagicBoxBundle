<?php 
  /** 
   * Jumbotron
   * 
   * for creating a bootstrap jumbotron 
   * By Nick Mullen 30/April/2015 
   */

   namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * @author Nick Mullen
   * @version 1.0
   * @link http://getbootstrap.com/examples/jumbotron/ bootstrsp site
   */
  class Jumbotron  extends Meta {
	
    /**
     * @var array holds jtron info
     */
    private $jumbotron = array();

  	public function  __construct() {}

    /**
     * add an item  to a  jumbotron
     * @param text $header the header text of the jumbotron
     * @param text $text the main text in the jumbotron
     * @param text $buttonText opt display text for creatng a button
     * @param text $buttonURL opt: the post url for the button 
     * @return array jumbotron values
     */
    public function additem($header,$text,$buttonText = Null,$buttonURL=Null) {
      $this->jumbotron['Header'] = $header;
      $this->jumbotron['Text'] = $text;
      $this->jumbotron['ButtonText'] = $buttonText;
      $this->jumbotron['ButtonURL'] = $buttonURL;
      
      return $this->jumbotron;
    }


    /**
     *  @return array the jumbotron array 
     */
    public function getJumbotron(){
      return $this->jumbotron;
    }

    /**
      * render the jumbotron
      * @param string $type the markup type
      * @return string raw markup
      */
    public function render($type)
    {
      if ($type == 'html') {
          $content = $this->renderHTML();
      } 
      return $content;
    }

    /**
      * return the header value
      * @return string;the header value
      */
    public function getHeader(){
      return $this->jumbotron['Header'];
    }

    /**
      * get the text 
      * @return string the value of the main text;
      */
    public function getText(){
      return $this->jumbotron['Text'];
    }

    /**
      * get the text for the button 
      * @return string the value of the button text
      */
    public function getButtonText(){
      return $this->jumbotron['ButtonText'];
    }

    /**
      * get the URL for the button 
      * @return string the value of the botton post url
      */
    public function getButtonURL(){
      return $this->jumbotron['ButtonURL'];
    }

    /**
    * render the table a html
    * @return string raw html
    */
    private function renderHTML() {
      $content = '<div';
      $content = $content.$this->renderClass('jumbotron');
      $content = $content.$this->renderID();
      $content = $content.'> <h1>'.$this->getHeader().'</h1><p>'.$this->getText().'</p>';
      if( $this->getButtonURL() !== Null && $this->getButtonText() !== Null){
        $content = $content.'<p><a class="btn btn-primary btn-lg" href="'.$this->getButtonURL().'" role="button">'.$this->getButtonText().'</a></p>';
      }
      $content = $content.'</div>';
      return $content;
    }
  }