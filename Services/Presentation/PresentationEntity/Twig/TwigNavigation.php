<?php   
/**
   * TwigNavigation
   * 
   * Custom twig extension for Navigation
   * By Nick Mullen
   * 02/June/2015 
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Navigation;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigNavigation  extends \Twig_Extension {


  public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Navigation', array($this, 'navigation'), array('is_safe' => array('html'))),
      );
    }

  public function navigation($options)
    {
      $myNavigation = new Navigation();
      $myNavigation->addOptions($options);
      return $myNavigation->render('html');
    }

   public function getName()
    {
        return 'Navigation';
    }
}