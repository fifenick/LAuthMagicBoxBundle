<?php
/**
  * test Jumbotron service 
  * to ensure it produces a Bootstrap Jumbotron
  * By Nick Mullen 04/june/2015
  */

  namespace LAuth\MagicBoxBundle\Tests\Services;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Jumbotron;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigJumbotron;

  /**
   * @author nick mullen
   * @version 1.0
   */
  class JumbotronTest extends \PHPUnit_Framework_TestCase
  {
    /**
      * test the add function
      */
    public function testAdd()
    {
        $testJumbotron = new Jumbotron();
        $testJumbotron->additem("test","test text","test button","test url");
        $result =  $testJumbotron->getJumbotron();

        $expectedResult['Header'] = "test";
        $expectedResult['Text'] = "test text";
        $expectedResult['ButtonText'] = "test button";
        $expectedResult['ButtonURL'] = "test url";
         
        // assert that the alert was added correctly
        $this->assertEquals($expectedResult, $result);
    }
}