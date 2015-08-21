<?php   
/**
   * TwigCarousel
   * 
   * Custom twig extension for Carousel
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Carousel;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigCarousel   extends \Twig_Extension {

  public function  __construct($container) {
     $this->container = $container;
  }

  public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Carousel', array($this, 'carousel'), array('is_safe' => array('html'))),
      );
    }

  public function carousel($content)
    {
      $myCarousel = new Carousel($this->container);
      $myCarousel->addContent($content);
      return $myCarousel->render('html');
    }

   public function getName()
    {
        return 'Carousel';
    }
}