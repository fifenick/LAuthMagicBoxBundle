<?php   
  /**
   * TwigGooleMap
   * 
   * Custom twig extension for google maps
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\GoogleMap;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigGoogleMap  extends \Twig_Extension {

	
    public function  __construct($webRoot, $container) {
     $this->webRoot = $webRoot;
     $this->javaScript = $container->get('MB.JavascriptHeader');
    }
  
    public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('GoogleMap', array($this, 'Google_Map'), array('is_safe' => array('html'))),
      );
    }

   public function google_Map($Lat,$Lng,$type = Null, $width = Null,$height = Null, $zoom = Null, $pointTitle = Null, $pointLat = Null, $pointLng = Null)
    {

//die(var_dump($pointLng));

      $myMap = new GoogleMap($this->webRoot,$this->javaScript);
      $myMap->setCenter($Lat,$Lng);

      if(isset($type) && $type!== Null){
        $myMap->setMapTypeId($type);
      }

      if($width !== Null){
        $myMap->setCanvasWidth($width); 
      }

      if($height !== Null){
         $myMap->setCanvasHeight($height); 
      }

      if($zoom !== Null){
         $myMap->setZoom($zoom);
      }

      if(isset($pointTitle) && $pointTitle !== Null && isset($pointLat) && $pointLat !== Null && isset($pointLng) && $pointLng !== Null){
        $myMap->addPoint($pointTitle, $pointLat, $pointLng );
      }
      
      if($type !== Null){
       $myMap->setMapTypeId($type);
      }

      return $myMap->render('html');
    }

   public function getName()
    {
        return 'GoogleMap';
    }
}