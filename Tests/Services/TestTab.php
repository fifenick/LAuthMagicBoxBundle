<?php
/**
 * Test the bootstrap Tab service
 * By Nick Mullen
 * Created 08/June/2015
 */

  namespace LAuth\MagicBoxBundle\Tests\Services;

  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Tab;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigTab;

/**
  * TestTab
  * 
  * @author Nick Mullen
  * @version 1.0
  */
  class TestTab extends \PHPUnit_Framework_TestCase
  {

    /**
      * Test the add/return markup
      */
    public function testRender()
    {
      $myTab = new Tab;
      $myTab->addTab('title 1','page 1',0);
      $myTab->addTab('title 2','page 2',1);
  

      $expectedResult = array(
                              array('title'=>'title 1', 'text'=>'page 1', 'order'=>0),
                              array('title'=>'title 2', 'text'=>'page 2', 'order'=>1)
                              );

      $result =  $myTab ->getTab();
      // remove the random ids
      unset($result[0]['id']);
      unset($result[1]['id']);

      // assert that the text was added correctly
      $this->assertEquals($expectedResult, $result);
    }
}