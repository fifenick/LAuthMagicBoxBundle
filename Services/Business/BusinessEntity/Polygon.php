<?php 
/** 
 * Polygon.
 * 
 * A service for creating polygon, 
 * by Nick Mullen 24/April/2015 
 */

  namespace LAuth\MagicBoxBundle\Services\Business\BusinessEntity;
  use LAuth\MagicBoxBundle\Services\Business\BusinessEntity\Coordinate;

  /**
   * polygon 
   * 
   * @author Nick Mullen 
   * @version 1.0.0
   */

class Polygon  {

  /**
   * @var array $polygon arry to hold all details about the polygon 
   */
	private $polygon = array();

  /**
   * @var array details about the polygon
   */
  private $polygonMeta = array();

	public function  __construct() {

  }

	 /**
     * add a polygon point to the map
     *  @param tring $title the name of the point
     *  @param numeric $lat Latitude
     *  @param numeric $lng Longitude
     *  @return array of polygon points to be added
     */
    public function addPolygonPoint($title,$lat,$lng){
      $myCenter = new coordinate;
      $myCenter->setLat($lat);
      $myCenter->setLng($lng);
      $point['Coordinate'] = $myCenter;
      $point['Title'] = $title;
      
      $points = $this->polygon;
      array_push($points ,$point);
      return $this->polygon = $points;
    }

    /**
     *  get polygon points
     *  @param numeric $Lat Latitude
     *  @param numeric $Lng Longitude
     *  @return array of polygon points to be added
     */
    public function getPolygonPoint(){
      return $this->polygon;
    }

   /**
     *  set polygon settings 
     *  @param string $name name of line
     *  @param string $color the color of the line
     *  @param string $opacity the opacity of the line
     *  @param string $weight the weight of the line
     *  @return array of polyline settings 
     */
    public function setPolygonSetting($name,$color,$opacity,$weight,$fillColor,$fillOpacity){

        
      $this->polygonMeta['Name'] = $name;
      $this->polygonMeta['Color'] = $color;
      $this->polygonMeta['Opacity'] = $opacity;
      $this->polygonMeta['Weight'] = $weight;
      $this->polygonMeta['FillColor'] = $fillColor;
      $this->polygonMeta['FillOpacity'] = $fillOpacity;


      return $this->polygonMeta;
    }

    public function getPolygonSetting(){
      return $this->polygonMeta;
    }
 
}