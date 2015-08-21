<?php 
  /**
   * well
   * 
   * for creating bootstrap Wells
   */
  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

/**
  * @author Nick Mullen <nick.mullen@fife.gov.uk>
  * @version v1.0
  * @link http://getbootstrap.com/components/#wells bootstrap site
  */
class Well extends Meta {

  /**
   * @var string $Text is to hold the Text
   */
  private $Text;

  /**
   * @var string $Size is to hold the well size
   */
  private $Size;

  public function __construct() {}

  /**
   * add an item to the well
   * 
   * @param string $text well text
   * @param string $size the size of the well
   */
  public function addItem( $text, $size ) {
    $this->setText( $text );
    $this->setSize( $size );
  }

  /**
   * set text
   * 
   * @param text $text the text to be displayed
   */
  private function setText( $text ) {
    $this->Text = $text;
  }

  /**
   * get text
   * 
   * @return string the text to be displayed
   */
  private function gettext() {
    return $this->Text;
  }

  /**
   * set size
   * 
   * @param string $size the size of the well
   */
  private function setSize( $size ) {
    if ( strtolower( $size ) == 'small' ) {
      $this->setClass( 'well-sm' );
    }elseif ( strtolower( $size ) == 'large' ) {
      $this->setClass( 'well-lg' );
    }
  }

  /**
   *  output the object
   * 
   * @param string $type the type of markup
   */
  public function render( $type ) {
    if ( strtolower($type) == 'html' ) {
      $content = $this->renderHTML();
    } else {
      throw $this->createNotFoundException( 'type not found for'.$type );
    }
    return $content;
  }

  /**
   * render the alert as html
   * 
   * @return string the well as html
   */
  private function renderHTML() {
    $content = '';
    $content = $content.'<div ';
    $content = $content.$this->renderClass( ' well ' );
    $content = $content.$this->renderID();
    $content = $content.' >'.$this->getText().'</div>';
    return $content;
  }
}
