<?php 
  /**
   * GoogleMap
   * 
   * for creating google maps
   * by nick mullen 09/6/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;
  use LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Javascript as JS;
  use LAuth\MagicBoxBundle\Services\Business\BusinessEntity\Coordinate;
  use LAuth\MagicBoxBundle\Services\Business\BusinessEntity\Polyline;
  use LAuth\MagicBoxBundle\Services\Business\BusinessEntity\Polygon;
  
  /**
   * PageGoogleMap
   * 
   * @author Nick Mullen <nick.mullen@fife.gov.uk>
   * @version 1.0
   */
  class GoogleMap extends Meta {

    /**
     * @var array $map that holds the map info
     */
    private $map;

    /**
     * @var array holding point to be plotted
     */
    private $points = array();

    /**
     * @var object of creating a polyine
     */
    private $polyline;

    /**
     * @var object of creating a polygon
     */
    private $polygon;

   /**
    * @param string $webRoot web root of the site
    * @param object $javaScript javascript control
    */ 
    public function __construct($webRoot, JS $javaScript) {
      $this->webRoot = $webRoot;
      $this->map['animationMarker'] = False;
      $this->javaScript = $javaScript;
      $this->int(); 
      $this->polyline = new polyline; 
      $this->polygon = new polygon;
    }


    /**
     * Initialize the map
     */
    public function int() {
      $this->map['Height'] = 200;
      $this->map['Width'] = 400;
      $this->map['Color'] = Null;
      $this->map['Icon'] = Null;
      $this->points = array();
      // Set a default id
      $this->setID('map-canvas');
      // apply the js link 
      $this->setJavascript(); 
      // Set default type
      $this->setMapTypeId('ROADMAP');
      // Set default zoom level
      $this->setZoom('8');
    }

    /**
     * add a point to the map
     *  @param numeric $Lat Latitude
     *  @param numeric $Lng Longitude
     *  @return array array of points to be added
     */
    public function addPoint($title,$lat,$lng){
      $myCenter = new coordinate;
      $myCenter->setLat($lat);
      $myCenter->setLng($lng);
      $point['Coordinate'] = $myCenter;
      $point['Title'] = $title;
      
      $points = $this->points;
      array_push($points ,$point);
      return $this->points = $points ;
    }

    /**
     * add a polygon point to the map
     *  @param numeric $lat Latitude
     *  @param numeric $lng Longitude
     *  @return array of polygon points to be added
     */
    public function addPolygonPoint($title,$lat,$lng){
      return $this->polygon->addPolygonPoint($title,$lat,$lng);
    }

   /**
     *  set Polygon settings 
     *  @param string $name name of line
     *  @param string $color the color of the line
     *  @param string $opacity the opacity of the line
     *  @param string $weight the weight of the line
     *  @param string $fillColor color of line
     *  @param string $fillOpacity Opacity of the fill line
     *  @return array of polyline settings 
     */
    public function setPolygonSetting($name,$color,$opacity,$weight,$fillColor,$fillOpacity){
      return $this->polygon->setPolygonSetting($name,$color,$opacity,$weight,$fillColor,$fillOpacity);
    }

    /**
     * add a polyline point to the map
     *  @param numeric $lat Latitude
     *  @param numeric $lng Longitude
     *  @return array of polyline points to be added
     */
    public function addPolylinePoint($title,$lat,$lng){
      return $this->polyline->addPolylinePoint($title,$lat,$lng);
    }

    /**
     * get the javascript for rendering a line
     * @return string javaScript for rendering a polyline
     */
    public function getPolylinePointsJS(){
      $JS = "";

      foreach ($this->polyline->getPolylinePoint() as $point) {
       $JS = $JS.'var '.$point['Title'].'=new google.maps.LatLng('.$point['Coordinate']->getLatLng().');';
      }
      return $JS;
    }

    /**
     * get the javascript for creating a polygon
     * @return string javascript for ploting a polygon 
     */
    public function getPolygonPointsJS(){
      $JS = "";

      foreach ($this->polygon->getPolygonPoint() as $point) {
       $JS = $JS.'var '.$point['Title'].'=new google.maps.LatLng('.$point['Coordinate']->getLatLng().');';
      }
      return $JS;
    }



   /**
     *  set polyline settings 
     *  @param string $name name of line
     *  @param string $color the color of the line
     *  @param string $opacity the opacity of the line
     *  @param string $weight the weight of the line
     *  @return array of polyline settings 
     */
    public function setPolylineSetting($name,$color,$opacity,$weight){
      return $this->polyline->setPolylineSetting($name,$color,$opacity,$weight);
    }

    /**
     * return the polyline settingg
     * @return array of polyline settings 
     */
    public function getPolylineSetting(){
      return $this->polyline->getPolylineSetting();
    }


    /**
     *  get animation marker
     *  @return boolean make markers animated
     */
    public function getAnimationMarkers(){
      return $this->map['animationMarker']; 
    }

    /**
     *  set animation marker
     *  @return boolean make markers animated
     */
    public function setAnimationMarkers(){
      return $this->map['animationMarker'] = True; 
    }

    /**
     *  set the points to be plotted
     *  @return array array of points to be added
     */
    public function getPoint(){
      return $this->points;
    }

   /**
    * get the icon
    * @return string the path to an icon 
    */
    public function getIcon(){
      return $this->map['Icon']; 
    }

   /**
    * set the icon
    * @param string $path path to the icon
    * @return string the path to an icon 
    */
    public function setIcon($path){
      return $this->map['Icon'] = $path; 
    }



    public function getPointsJS(){
      $JSpoints = "var locations = [";
      $i = 1;
      foreach ($this->points as $point) {
        $JSpoints = $JSpoints."['".$point['Title']."',".$point['Coordinate']->getLatLng().",".$i."]";
        if($i < sizeof($this->points)){
          $JSpoints = $JSpoints.',';
        }
        $i++;
      }
      $JSpoints = $JSpoints."];";

      $JSpoints = $JSpoints."
        var infowindow = new google.maps.InfoWindow();
        var marker, i;
        for (i = 0; i < locations.length; i++) {  
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),";

      if($this->getanimationMarkers()){
        $JSpoints = $JSpoints."animation:google.maps.Animation.BOUNCE,";
      }   
      if($this->getIcon()){
        $JSpoints = $JSpoints."icon:'".$this->getIcon()."',";
      }   

      $JSpoints = $JSpoints."      map: map
          });

   google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));


        }
      ";


    return  $JSpoints;
    }
   
    /**
     * add the required javaScript to the javascript object
     * @return object the javaScript object
     */
    public function setJavascript() {
      $this->javaScript->additem('https://maps.googleapis.com/maps/api/js');
      return $this->javaScript;
    }

    /**
     * get the javascript object
     * @return object the javaScript object
     */
    public function getJavascript() {
      return $this->javaScript;
    }

    /**
     *  set the zoom level
     * @param numeric $zoom zoom level
     * @return string zoom level
     */
    public function setZoom($zoom) {
      return $this->map['Zoom'] = $zoom;
    }

    /**
     *  get the zoom level
     * @return string zoom level
     */
    public function getZoom() {
      return $this->map['Zoom'];
    }
      
    /**
     * set map canvas width
     * @param numeric $width the width of the canvas in px
     * @return string the canvas width
     */
    public function setCanvasWidth($width) {
     return $this->map['Width'] = $width;
    }

    /**
     * get map canvas width
     * @return string the canvas width
     */
    public function getCanvasWidth() {
     return $this->map['Width'];
    }

    /**
     * set map canvas height
     * @param numeric $height the height of the canvas in px
     * @return string the canvas height
     */
    public function setCanvasHeight($height) {
     return $this->map['Height'] = $height;
    }

    /**
     * get map canvas height
     * @return string the canvas height
     */
    public function getCanvasHeight() {
     return $this->map['Height'];
    }

    /**
     * set the canvas background color
     * @param string $color canvas color HEX
     * @return string the canvas color
     */
    public function setCanvasColor($color) {
     return $this->map['Color'] = $color;
    }

    /**
     * get the canvas background color
     * @return string the canvas color
     */
    public function getCanvasColor() {
     return $this->map['Color'];
    }

    
    /**
     *  set the center the map
     *  @param numeric $Lat Latitude
     *  @param numeric $Lng Longitude
     *  @return object coordinate object
     */ 
    public function setCenter($Lat,$Lng) {
     $myCenter = new coordinate;
     $myCenter->setLat($Lat);
     $myCenter->setLng($Lng);
     return $this->map['Center'] = $myCenter;
    }

    /**
     *  get center the map
     *  @return string coordinate
     */ 
    public function getCenter() {
     return $this->map['Center']->getLatLng();
    }

    
    /**
     * set the map type
     * @param string $type type of map to display
     */
    public function setMapTypeId($type){
      switch (strtoupper($type)) {
        case "ROADMAP":
          //normal, default 2D map //
          $typeId = 'ROADMAP';
          break;  
        case "SATELLITE":
          //(photographic map // 
          $typeId = 'SATELLITE';
          break;
        case "HYBRID":
          // photographic map + roads and city names //
          $typeId = 'HYBRID'; 
          break; 
        case "TERRAIN":
          // map with mountains, rivers, etc.//
          $typeId = 'TERRAIN';
          break; 
        }
      return $this->map['TypeId'] = $typeId;
    }

  /**
     * get the map type
     * @return string $type type of map to display
     */
    public function getMapTypeId(){
      return $this->map['TypeId'];
    }
    /**
     * create the map javaScript
     * @return string raw js
     */
    public function getMapJS() {
      $JS = "<script>";

      if(sizeof($this->polyline->getPolylinePoint()) > 0){
        $JS = $JS.$this->getPolylinePointsJS();
      }
      if(sizeof($this->polygon->getpolygonPoint()) > 0){
        $JS = $JS.$this->getPolygonPointsJS();
      }

      $JS = $JS."function initialize() {
          var mapCanvas = document.getElementById('".$this->getID()."');
          var mapOptions = {
            center: new google.maps.LatLng(".$this->getCenter()."),
            zoom: ".$this->getZoom().",
            mapTypeId: google.maps.MapTypeId.".$this->getMapTypeId()."
          }
          var map = new google.maps.Map(mapCanvas, mapOptions);";
      $JS = $JS.$this->getPointsJS();
      if(sizeof($this->polyline->getPolylinePoint()) > 0){
        $JS = $JS.$this->getPolylineJSScript();
      }

      if(sizeof($this->polygon->getPolygonPoint()) > 0){
        $JS = $JS.$this->getPolygonJSScript();
      }


       $JS = $JS." }

        google.maps.event.addDomListener(window, 'load', initialize);
      </script>";
      return $JS;
    }


public function getPolylineJSScript() {
  $settings = $this->polyline->getPolylineSetting();
  
  $JS ='var '.$settings['Name'].'=[';
  $i = 1;
  foreach ($this->polyline->getPolylinePoint() as $point) {
    $JS =$JS.$point['Title'];
    if(sizeof($this->polyline->getPolylinePoint()) > $i){
      $JS =$JS.',';
    }
    $i++;
  }
  $JS =$JS.'];';


  $JS =$JS.'var '.$settings['Name'].'map=new google.maps.Polyline({
  path:'.$settings['Name'].',
  strokeColor:"'.$settings['Color'].'",
  strokeOpacity:'.$settings['Opacity'].',
  strokeWeight:'.$settings['Weight'].'
  });';

 $JS =$JS.$settings['Name'].'map.setMap(map);';
return $JS;
}



public function getPolygonJSScript() {
  $settings = $this->polygon->getPolygonSetting();
 
  $JS ='var '.$settings['Name'].'=[';
  $i = 1;
  foreach ($this->polygon->getPolygonPoint() as $point) {
    $JS =$JS.$point['Title'];
    if(sizeof($this->polygon->getPolygonPoint()) > $i){
      $JS =$JS.',';
    }
    $i++;
  }
  $JS =$JS.'];';


  $JS =$JS.'var '.$settings['Name'].'map=new google.maps.Polygon({
  path:'.$settings['Name'].',
  strokeColor:"'.$settings['Color'].'",
  strokeOpacity:'.$settings['Opacity'].',
  strokeWeight:'.$settings['Weight'].',
  fillColor:"'.$settings['FillColor'].'",
  fillOpacity:'.$settings['FillOpacity'].'
  });';

 $JS =$JS.$settings['Name'].'map.setMap(map);';
return $JS;
}




    /**
     * create the map css
     * @return string raw css
     */
    public function getMapCSS() {
      $CSS ='<style> #'.$this->getID().' {';
      if(isset($this->map['Width']) && $this->map['Width'] !== Null){
        $CSS =$CSS."width:".$this->getCanvasWidth()."px;";
      };
      if(isset($this->map['Height']) && $this->map['Height'] !== Null){
        $CSS =$CSS."height: ".$this->getCanvasHeight()."px;";
      }
      if(isset($this->map['Color']) && $this->map['Color'] !== Null){
        $CSS =$CSS."background-color: ".$this->getCanvasColor().";";
      }
      $CSS =$CSS. " }</style>";
      return $CSS;
    }

    /**
     * output the object as markup
     * @param string $type type of markup
     * @return string raw markup
     */
    public function render( $type ) {
      if ( mb_strtolower($type) == 'html' ) {
        $content = $this->renderHTML();
      } else {
        throw $this->createNotFoundException( 'type not found for'.$type );
      }
      return $content;
    }

    /**
     * render the map as raw html
     * @return string html raw markup
     */
    private function renderHTML() {
      $content = '';
      // create the canvas //
      $content = $content.'<div ';
      $content = $content.$this->renderClass();
      $content = $content.$this->renderID();
      $content = $content.' ></div> ';
      // create the css //
      $content = $content.$this->getMapCSS(); 
       // create the css //
      $content =  $content.$this->getMapJS();
      return $content;
    }
  }
