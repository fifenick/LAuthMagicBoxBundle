<?php   
  /**
   * TwigList
   * 
   * Custom twig extension for bootstrap List
   * By Nick Mullen
   * 18/June/2015
   */


  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\ListGroup;

  /**
    * @author nick mullen
    * @version v1.0
    * 
    */
  class TwigList  extends \Twig_Extension {

  	public function  __construct() {		
    }

    public function getFunctions() {
      return array(
          new \Twig_SimpleFunction('List', array($this, 'bs_list'), array('is_safe' => array('html'))),
      );
    }

    public function bs_list($rows)  {
        $myList = new ListGroup;

        foreach ($rows as $row) {
          $myList->addItem($row);
        }

        return $myList->render('html');
    }

    public function getName() {
      return 'List';
    }
  }