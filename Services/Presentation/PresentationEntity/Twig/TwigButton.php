<?php 
 /**
   * TwigButton
   * 
   * Custom twig extension for bootstrap Button
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Button;

  Class TwigButton   extends \Twig_Extension {

	public function  __construct() { }
  
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('Button', array($this, 'bs_button'), array('is_safe' => array('html'))),
    );
  }
    public function bs_button($text,$style,$size=Null,$block=Null,$active=Null,$disabled=Null) {
      $myButton = new Button;
      $myButton->addItem($text,$style,$size=Null,$block=Null,$active=Null,$disabled=Null);
      return $myButton->render('html');
    }

   public function getName()  {
        return 'Button';
    }
}