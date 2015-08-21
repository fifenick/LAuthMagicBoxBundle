<?php
  /**
    * testButton
    * to ensure it produces a Bootstrap Button 
    * By Nick Mullen 04/june/2015
    */

   namespace LAuth\MagicBoxBundle\Tests\Services;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Button;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigButton;

  /**
   * @author nick mullen
   * @version v1.0
   */
  class TestButton extends \PHPUnit_Framework_TestCase
  {
    /**
      * test the add function
      */
    public function testAdd()
    {
        $myButton = new Button();
        $myButton->addItem('display text','warning','small');
        $result = $myButton->render('html');

        $expectedResult = '<button type="button"  class=" btn  btn-sm    btn-warning  " >display text</button>';
         
        // assert that the alert was added correctly
        $this->assertEquals($expectedResult, $result);
    }
  }