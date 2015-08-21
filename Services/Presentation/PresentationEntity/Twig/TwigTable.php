<?php   
  /**
   * TwigTable
   * 
   * Custom twig extension for bootstrap Table
   * By Nick Mullen
   * 18/June/2015
   */


  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Table;

  /**
    * @author nick mullen
    * @version v1.0
    * 
    */
  class TwigTable  extends \Twig_Extension {

  	public function  __construct() {		
    }

    public function getFunctions() {
      return array(
          new \Twig_SimpleFunction('Table', array($this, 'bsTable'), array('is_safe' => array('html'))),
      );
    }

    public function bsTable($rows)  {
      $myTable = new Table;
      $myTable->setRows($rows);
      $T= $myTable->getTable();
      return $myTable->render('html');
    }

    public function getName() {
      return 'Table';
    }
  }