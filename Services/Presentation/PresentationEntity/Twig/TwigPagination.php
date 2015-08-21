<?php   
/**
   * TwigPagination
   * 
   * Custom twig extension for Pagination script tags
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Pagination;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigPagination   extends \Twig_Extension {


  public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Pagination', array($this, 'pagination'), array('is_safe' => array('html'))),
      );
    }

  public function pagination($controls,$URL,$size=Null,$pages =Null,$totalRecords =Null, $recordsPerPage = Null,$currentPage=1)
    {
      $myPagination = new Pagination;
      $myPagination->setPagination($controls,$URL,$size,$pages,$totalRecords, $recordsPerPage,$currentPage);
      return $myPagination->render('html');
    }

   public function getName()
    {
        return 'Pagination';
    }
}