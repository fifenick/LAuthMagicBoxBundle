<?php   
  /**
   * TwigWell
   * 
   * Custom twig extension for bootstrap Well
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Badge;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigBadge  extends \Twig_Extension {

	public function  __construct() {}
  
   public function getFilters()
    {
      return array(
            new \Twig_SimpleFilter(
              'Badge', 
              array($this, 'badgeFilter'),
              array('pre_escape' => 'html', 'is_safe' => array('html'))
            )
        );
    }

  public function badgeFilter($text)
    {
      $myBadge = new Badge;
      $myBadge->setText($text);
      return $myBadge->render('html');
    }

   public function getName()
    {
        return 'Badge';
    }
}