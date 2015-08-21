<?php
  /**
    * testWell
    * to ensure it produces a Bootstrap Well 
    * By Nick Mullen 04/june/2015
    */

  namespace LAuth\MagicBoxBundle\Tests\Services;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Well;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigWell;

  /**
   * @author nick mullen
   * @version v1.0
   */
  class TestWell extends \PHPUnit_Framework_TestCase
  {
    /**
      * test the add function
      */
    public function testAdd()
    {
        $myWell = new Well();
        $myWell->addItem('I am in a well','small');
        $result = $myWell->render('html');

        $expectedResult = '<div  class="  well   well-sm " >I am in a well</div>';
         
        // assert that the alert was added correctly
        $this->assertEquals($expectedResult, $result);
    }
  }