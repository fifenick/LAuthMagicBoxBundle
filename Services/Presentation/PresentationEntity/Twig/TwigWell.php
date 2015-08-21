<?php 
  /**
   * TwigWell
   * 
   * Custom twig extension for bootstrap Well
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Well;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigWell  extends \Twig_Extension {

	public function  __construct() { }
  
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('Well', array($this, 'bs_well'), array('is_safe' => array('html'))),
    );
  }

  public function bs_well($text,$size) {
    $myWell = new Well;
    $myWell->addItem($text,$size);
    return $myWell->render('html');
  }

  public function getName() {
    return 'Well';
  }
}