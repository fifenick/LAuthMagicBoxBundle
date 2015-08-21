<?php 
  /** 
    * Flickrit
    * 
    * 02/June/2015 for creating a flicker slide show.
    * @author Nick Mullen 
    */
  
   namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
    * @version 1
    * @see http://flickrit.com/ 
    */
  class Flickrit extends Meta {

    /**
     * @var string flicker url 
     */
    private $flickritURL; 

    /**
     * @var string image size
     */
    private $size;

    /**
     * @var string image height in px 
     */
    private $height;

    /**
     * @var string css style to be added 
     */
    private $style;

	/**
    * @param $Options globalOptions class
    * 
    */ 
	public function  __construct() {
    $this->init();
  }

  /**
    * add setup default values
    * @method Null apply  default settings
    */
  public function init() {
    $this->setTransferProtocol('http://');
    $this->flickritURL = $this->getTransferProtocol().'flickrit.com/slideshowholder.php';
    $this->size = 'big';
    $this->height = 100;
    $this->style = "position: relative; padding-bottom: 101%; height: 0; overflow: hidden;";
  }

  /**
   * @return string the transfer protocol 
   */
   public function getTransferProtocol(){
    return $this->TransferProtocol;
   }

  /**
   * @param string $protocal set the protocl to use
   * @return string get the transfer protocol 
   */
   public function setTransferProtocol($protocol){
    return $this->TransferProtocol = $protocol;
   }

  /**
    * set the flicker album ID to to be displayed
    * @method string album id
    * @param string $AlbumID the flicker album id
    */
  public function setAlbumID($AlbumID){
    return $this->albumID = $AlbumID;
  }

  /**
    * get the flicker ablbum id
    * @method string album id 
    */
  public function getAlbumID(){
    return $this->albumID; 
  }


  /**
   * get the post url for flicker
   * @method string the url for the flicker app
   */
  public function  getFlickritURL(){
    return $this->flickritURL;
  }


  /**
   * get the css size of the display
   * @method string getSize() size (px) of the display div
   */  
  public function  getSize(){
    return $this->size;
  }

  /**
   * get the size of the display
   * @param string $Size css size of the display
   * @method string setSize(numeric $Size) size of the display
   */
  public function  setSize($Size){
    return $this->size = $Size;
  }


  /**
   * set the height in px
   * @param numeric $Height px height value of the display
   * @method string setHeight(numeric $Height) return the px height value
   */
  public function  setHeight($Height){
    return $this->height = $Height;
  }

  /** 
    * return the height px value
    * @method string getHeight() return the px height value
    */
  public function  getHeight(){
    return $this->height;
  }  


  /**
    * return the style 
    * @method string getStyle() return the css styles to be used
    */
  public function  getStyle(){
    return $this->style;
  }

  /**
   * set the css style to be used
   * @param string $Style the css inline styles to be used
   * @method string setStyle($Style) set the display styles
   */ 
  public function  setStyle($Style){
    return $this->Style = $Style ;
  }

 	/**
  	* output the object as mark-up code    
    * @method string render($Type) output raw code 
    * @param string $Type the format type of output to render
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
   * render the the flicker slider as html
   * @method string raw html
   */
	private function renderHTML() {
    $content = '';
    $content = $content.'<div style="'.$this->getStyle().'"';
    $content = $content.$this->renderClass();
    $content = $content.$this->renderID();
    $content = $content.' >';
    $content = $content."<iframe id='iframe' src='".$this->getFlickritURL()."?height=".$this->getHeight()."&size=".$this->getSize()."&setId=".$this->getAlbumID()."&credit=0&thumbnails=0&transition=0&layoutType=responsive&sort=0' scrolling='no' frameborder='0'style='width:100%; height:100%; position: absolute; top:0; left:0;' ></iframe></div>";
		return $content;
	}
}