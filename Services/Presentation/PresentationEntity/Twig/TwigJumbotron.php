<?php   
/**
   * TwigJumbotron
   * 
   * Custom twig extension for Jumbotron script tags
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Jumbotron;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigJumbotron   extends \Twig_Extension {


  public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Jumbotron', array($this, 'jumb'), array('is_safe' => array('html'))),
      );
    }

  public function jumb($header,$text,$buttonText = Null,$buttonURL=Null)
    {
      $myJumbotron = new Jumbotron;
      $myJumbotron->additem($header,$text,$buttonText,$buttonURL);
      return $myJumbotron->render('html');
    }

   public function getName()
    {
        return 'Jumbotron';
    }
}