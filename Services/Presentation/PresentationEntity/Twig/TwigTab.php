<?php  
  /**
   * TwigTab
   * 
   * Custom twig extension for bootstrap Tab
   * By Nick Mullen
   * 18/June/2015
   */

    namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
    use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Tab;

  /**
   * @author nick mullen
   * @version v1.0 
   */
  class TwigTab extends \Twig_Extension {


	public function  __construct() {		}


  public function getFunctions()  {
    return array(
      new \Twig_SimpleFunction('Tab', array($this, 'bs_tab'), array('is_safe' => array('html'))),
      );
    }


  public function bs_tab($tabs) {
      $myTab = new Tab;
      foreach ($tabs as $tab) {
        $defaults = array('title'=>Null,'text'=>Null,'order'=>Null,'pills'=>Null,'justified'=>Null);
        $args = array_merge($defaults, array_intersect_key($tab, $defaults));
        list($title,$text,$order,$pills,$justified) = array_values($args);
        $myTab->addTab($title,$text,$order,$pills,$justified);
      }
      return $myTab->render('html');
    }

   public function getName()
    {
        return 'Tab';
    }
}