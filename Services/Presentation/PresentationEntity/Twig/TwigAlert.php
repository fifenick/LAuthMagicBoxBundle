<?php 
  /**
   * TwigAlert
   * 
   * Custom twig extension for bootstrap Alert
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
   use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Alert;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigAlert   extends \Twig_Extension {

  	private $alert;

  	public function  __construct() {}
    
    public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Alert', array($this, 'bs_alert'), array('is_safe' => array('html'))),
      );
    }

    public function bs_alert($title,$text,$type)
      {
        $myAlert = new Alert;
        $myAlert->addAlert($title,$text,$type);
        return $myAlert->render('html');
    }

     public function getName()
      {
          return 'twig_extension_alert';
    }
  }