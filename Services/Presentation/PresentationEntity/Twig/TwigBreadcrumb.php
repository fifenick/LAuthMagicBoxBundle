<?php
  /**
   * TwigBreadcrumb.
   * Custom twig extension for bootstrap breadcrumb
   * By Nick Mullen
   * 18/June/2015
   */
 
  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Breadcrumb;

  /**
   * @author nick mullen
   * @version 1.0 
   */
  class TwigBreadcrumb  extends \Twig_Extension {


    public function  __construct() {}
    
    public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('breadcrumb', array($this, 'breadcrumb'), array('is_safe' => array('html'))),
      );
    }

    public function breadcrumb($links)    {
      $myBreadcrumb = new Breadcrumb;
      $myBreadcrumb->setLinks($links);
      return $myBreadcrumb->render('html');
    }

    public function getName() {
        return 'breadcrumb';
    }
  }