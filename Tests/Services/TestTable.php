<?php
/**
 * Test the bootstrap Table service
 * By Nick Mullen
 * Created 08/June/2015
 */

  namespace LAuth\MagicBoxBundle\Tests\Services;

  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Table;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigTable;

/**
  * TestTable
  * 
  * @author Nick Mullen
  * @version 1.0
  */
  class TestTable extends \PHPUnit_Framework_TestCase
  {

    /**
      * Test the add/return markup
      */
    public function testRender()
    {
      $myTable = new Table;
      $myTable ->addItem(array('label'=>'A', 'order'=>'0', 'row'=>'0','head' =>'true'));
      $myTable ->addItem(array('label'=>'B', 'order'=>'1', 'row'=>'0','head' =>'true'));
      $myTable ->addItem(array('label'=>'C', 'order'=>'2', 'row'=>'0','head' =>'true'));
      $myTable ->addItem(array('label'=>'1', 'order'=>'0', 'row'=>'1'));
      $myTable ->addItem(array('label'=>'2', 'order'=>'1', 'row'=>'1'));
      $myTable ->addItem(array('label'=>'3', 'order'=>'2', 'row'=>'1', 'rowClass'=> 'rowClass'));

      $expectedResult = '<table><thead><tr><th>A</th><th>B</th><th>C</th></tr></thead><tr class="rowClass" ><td>1</td><td>2</td><td>3</td></tr></table>';
      $result =  $myTable ->render('html');
 
      // assert that the text was added correctly
      $this->assertEquals($expectedResult, $result);
    }
}