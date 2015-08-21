<?php 
/** 
 * Polyline.
 * 
 * A service for creating polyline, 
 * by Nick Mullen 24/April/2015 
 * 
 */

  namespace LAuth\MagicBoxBundle\Services\Business\BusinessEntity;
  use LAuth\MagicBoxBundle\Services\Business\BusinessEntity\Coordinate;

  /**
   * polyline 
   * 
   * @author Nick Mullen 
   * @version 1.0.0
   */

class Polyline  {

  /**
   * @var array $polyline arry to hold all details about the polyline 
   */
	private $polyline = array();

  /**
   * @var array details about the polyine 
   */
  private $polylineMeta = array();

	public function  __construct() {

  }

	 /**
     * add a polyline point to the map
     *  @param tring $title the name of the point
     *  @param numeric $lat Latitude
     *  @param numeric $lng Longitude
     *  @return array of polyline points to be added
     */
    public function addPolylinePoint($title,$lat,$lng){
      $myCenter = new coordinate;
      $myCenter->setLat($lat);
      $myCenter->setLng($lng);
      $point['Coordinate'] = $myCenter;
      $point['Title'] = $title;
      
      $points = $this->polyline;
      array_push($points ,$point);
      return $this->polyline = $points ;
    }

    /**
     *  get polyline points
     *  @param numeric $Lat Latitude
     *  @param numeric $Lng Longitude
     *  @return array of polyline points to be added
     */
    public function getPolylinePoint(){
      return $this->polyline;
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
    
      $this->polylineMeta['Name'] = $name;
      $this->polylineMeta['Color'] = $color;
      $this->polylineMeta['Opacity'] = $opacity;
      $this->polylineMeta['Weight'] = $weight;

      return $this->polylineMeta;
    }

    public function getPolylineSetting(){
      return $this->polylineMeta;
    }
 
}