<?php
/**
 * Test the bootstrap badge service
 * 
 * By Nick Mullen
 * Created 08/June/2015
 */

  namespace LAuth\MagicBoxBundle\Tests\Services;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Badge;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigBadge;


/**
  * test the Badge service to ensure it produces a Bootstrap Badge
  * 
  * @author Nick Mullen
  * @version 1.0
  */
  class PageBadgeTest extends \PHPUnit_Framework_TestCase
  {

    /**
      * Test the add/return text functions
      */
    public function testAdd()
    {
      $myBadge = new Badge();
      $myBadge->setText('test text');
      $result =  $myBadge->getText();

      $expectedResult = 'test text';
         
      // assert that the text was added correctly
      $this->assertEquals($expectedResult, $result);
    }
    
    /**
      * Test the html render of the badge
      */
    public function testdisplay()
    {
      $myBadge = new Badge();
      $myBadge->setText('test text');
      $result = $myBadge->render('html');

      $expectedResult= '<span  class="  badge  " >test text</span>';
         
      // assert that the badge displays correctly
      $this->assertEquals($expectedResult, trim($result));
    }

    /**
      * Test the twig alert extensions
      */
    public function testtwig()
    {
        $myTwigBadge = new TwigBadge();
        $result = $myTwigBadge->badgeFilter('test');
        $expectedResult= '<span  class="  badge  " >test</span>';
        // assert that the badge displays correctly with twig
        $this->assertEquals($expectedResult, trim($result));
    }
}