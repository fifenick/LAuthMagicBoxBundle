<?php
/**
 * Test the bootstrap breadcrumb service
 * By Nick Mullen
 * Created 08/June/2015
 */

  namespace LAuth\MagicBoxBundle\Tests\Services;

  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Breadcrumb;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigBreadcrumb;

/**
  * Breadcrumbtest
  * 
  * @author Nick Mullen
  * @version 1.0
  */
  class TestBreadcrumb extends \PHPUnit_Framework_TestCase
  {

    /**
      * Test the add/return link functions
      */
    public function testaddLink()
    {
      $param = array('URL'=>'#','text'=>'link','order'=>'0');
      $expectedResult = array($param );

      $myBreadcrumb = new Breadcrumb();
      $myBreadcrumb->addLink('#','link','0');
      $result =  $myBreadcrumb->getLinks();
 
      // assert that the text was added correctly
      $this->assertEquals($expectedResult, $result);
    }
    
     /**
      * Test the html render of the breadcrumb
      */
    public function testdisplay()
    {
      $myBreadcrumb = new Breadcrumb();
      $myBreadcrumb->addLink('#','link','0');
      $myBreadcrumb->addLink('#','link 2','1');
      $result = $myBreadcrumb->render('html');

      $expectedResult= '<ol  class="  breadcrumb  " ><li><a href="#">link</a></li><li  class="active"><a href="#">link 2</a></li> </ol>';
         
      // assert that the badge displays correctly
      $this->assertEquals($expectedResult, trim($result));
    }
  
    /**
     * test the twig render 
     */
    public function testtwig()
    {
        $BreadcrumbTwig = new TwigBreadcrumb();
        $result =  $BreadcrumbTwig->breadcrumb(array(array('URL'=>'#' ,'text'=>'link 1','order'=>'0')));
        $expectedResult= '<ol  class="  breadcrumb  " ><li  class="active"><a href="#">link 1</a></li> </ol>';
        // assert that the breadcrumb displays correctly with twig
        $this->assertEquals($expectedResult, trim($result));
    }
}