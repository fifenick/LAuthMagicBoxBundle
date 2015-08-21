<?php   
/**
   * TwigFlickrit
   * 
   * Custom twig extension for Flickrit
   * By Nick Mullen
   * 02/June/2015 
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Flickrit;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigFlickrit   extends \Twig_Extension {


  public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Flickrit', array($this, 'flickrit'), array('is_safe' => array('html'))),
      );
    }

  public function flickrit($albumID, $protocol = Null, $size = Null, $height = Null, $style = Null)
    {
      $myFlickrit = new Flickrit();
      $myFlickrit->setAlbumID($albumID);

      if(isset($protocol) && $protocol !==Null){
        $myFlickrit->setTransferProtocol($protocol);
      }
      
      if(isset($size) && $size !==Null){
        $myFlickrit->setSize($size);
      }
      
      if(isset($height) && $height !== Null){
        $myFlickrit->setHeight($height);
      }

      if(isset($style) && $style !== Null){
        $myFlickrit->setStyle($style);
      }

      return $myFlickrit->render('html');
    }

   public function getName()
    {
        return 'Flickrit';
    }
}