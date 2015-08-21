<?php
/**
  * test Pagination service 
  * to ensure it produces a Bootstrap Pagination
  * By Nick Mullen 04/june/2015
  */

  namespace LAuth\MagicBoxBundle\Tests\Services;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Pagination;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig\TwigPagination;

  /**
   * @author nick mullen
   * @version 1.0
   */
  class TestPagination extends \PHPUnit_Framework_TestCase
  {
    /**
      * test the add function
      */
    public function testSettings()
    {
        $Pagination= new Pagination();
        $Pagination->setPagination(True,'#','small',4,20, 5,1);
        $result =  $Pagination->render('html');

        $expectedResult = ' <nav><ul  class="  pagination   pagination-sm " > 
        <li>
          <a href="#/page/1" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li> <li class="active"  ><a href="#/page/1">1</a></li> <li ><a href="#/page/2">2</a></li> <li ><a href="#/page/3">3</a></li> <li ><a href="#/page/4">4</a></li> <li>
          <a href="#/page/4" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li> </ul></nav>';
         
        // assert that the alert was added correctly
        $this->assertEquals($expectedResult, $result);
    }
}