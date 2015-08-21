<?php   
/**
   * TwigPaginationTable
   * 
   * Custom twig extension for Pagination table
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\PaginationTable;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Pagination as Pagination;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Table as Table;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigPaginationTable   extends \Twig_Extension {


  public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('PaginationTable', array($this, 'pagination'), array('is_safe' => array('html'))),
      );
    }

  public function pagination($params)
    {

      $table = new Table();
      $pagination = new Pagination();

      $myPagination = new PaginationTable($table, $pagination);

      $myPagination->setPagination($params[0]);
      return $myPagination->render('html');
    }

   public function getName()
    {
        return 'PaginationTable';
    }
}