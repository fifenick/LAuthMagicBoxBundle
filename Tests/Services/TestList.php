<?php
/**
 * Test the bootstrap List service
 * By Nick Mullen
 * Created 08/June/2015
 */

  namespace LAuth\MagicBoxBundle\Tests\Services;

  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\ListGroup;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigList;

/**
  * TestList
  * 
  * @author Nick Mullen
  * @version 1.0
  */
  class TestList extends \PHPUnit_Framework_TestCase
  {

    /**
      * Test the add/return markup
      */
    public function testRender()
    {
      $myList = new ListGroup;
      $myList->addItem(array('label'=>'item 1', 'order'=>'0'));
      $myList->addItem(array('label'=>'item 2', 'order'=>'1'));
      $myList->addItem(array('label'=>'item 3', 'order'=>'2'));

      $expectedResult = '<ul class=" list-group   "><li  class="  list-group-item" >item 1</li><li  class="  list-group-item" >item 2</li><li  class="  list-group-item" >item 3</li></ul>';
      $result =  $myList->render('html');
 
      // assert that the text was added correctly
      $this->assertEquals($expectedResult, $result);
    }
    
    /**
     * test adding removing and sorting
     */
    public function testAdditems() {
      $myList = new ListGroup;
      $myList->addItem(array('label'=>'C', 'order'=>'0'));
      $myList->addItem(array('label'=>'Z', 'order'=>'1', 'itemClass'=>'iclass', 'itemId'=>'id'));
      $myList->addItem(array('label'=>'A', 'order'=>'2'));
      $myList->removeItem(0);
      $myList->setSortBy('A');
      $result = $myList->getList();

      $expectedResult  =  array(
         array('label'=>'A', 'order'=>2, 'link'=>null, 'itemClass'=>null, 'itemId'=>null, 'linkClass'=>null, 'linkId'=>null),
         array('label'=>'Z', 'order'=>'1', 'link'=>null, 'itemClass'=>'iclass', 'itemId'=>'id', 'linkClass'=>null, 'linkId'=>null)
      );

      // assert that the text was added correctly
      $this->assertEquals($expectedResult, $result);
    }

}