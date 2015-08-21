<?php
/**
  * test the pageAlert service 
  * to ensure it produces a Bootstrap alert box 
  * By Nick Mullen 04/june/2015
  */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 

  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Alert;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigAlert;

  /**
   * @author nick mullen
   * @version v1.0
   */
  class TestAlert extends \PHPUnit_Framework_TestCase
  {
    /**
      * Test the add function
      */
    public function testAdd()
    {
        $myAlert = new Alert();
        $myAlert->addAlert('title','text','alert-info');
        $result =  $myAlert->getAlert();

        $expectedResult['title'] = "title";
        $expectedResult['text'] = "text";
        $expectedResult['type'] = "alert-info";
         
        // assert that the alert was added correctly
        $this->assertEquals($expectedResult, $result[0]);
    }
    
    /**
      * Test the html render of the alert
      */
    public function testdisplay()
    {
        $myAlert = new Alert();
        $myAlert->addAlert('title','text','alert-info');
        $result = $myAlert->render('html');

        $expectedResult= '<div class=" alert-info  alert " role="alert"><strong>title</strong>text</div>';
         
        // assert that the alert displays correctly
        $this->assertEquals($expectedResult, trim($result));
    }

    /**
      * Test the twig alert extensions
      */
    public function testtwig()
    {
        $myTwigAlert = new TwigAlert();
        $result = $myTwigAlert->bs_alert('title','text','alert-info');
        $expectedResult= '<div class=" alert-info  alert " role="alert"><strong>title</strong>text</div>';
        // assert that the alert displays correctly with twig
        $this->assertEquals($expectedResult, trim($result));
    }
  }