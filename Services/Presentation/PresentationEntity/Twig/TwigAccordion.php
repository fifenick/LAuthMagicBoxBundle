<?php   
/**
   * TwigAccordion
   * 
   * Custom twig extension for Accordion
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Accordion;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigAccordion   extends \Twig_Extension {

  public function  __construct($webRoot) {
    $this->webRoot = $webRoot;
  }

  public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Accordion', array($this, 'accordion'), array('is_safe' => array('html'))),
      );
    }

  public function accordion($content)
    {
      $myAccordion = new Accordion($this->webRoot);
      $myAccordion->addContent($content);
      return $myAccordion->render('html');
    }

   public function getName()
    {
        return 'Accordion';
    }
}