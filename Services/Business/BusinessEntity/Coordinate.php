<?php 
/** 
 * Coordinate.
 * 
 * A service for creating geographic coordinates, 
 * by Nick Mullen 24/April/2015 
 */

  namespace LAuth\MagicBoxBundle\Services\Business\BusinessEntity;


  /**
   * Coordinate
   * 
   * @author Nick Mullen 
   * @version 1.0.0
   */

class Coordinate {

  /**
   * @var array $coordinate arry to hold all details about the Coordinate
   */
	private $coordinate;

	public function  __construct() {
    $this->coordinate['Lng'] = Null;
    $this->coordinate['Lat'] = Null;
  }

	/**
	 * set the Latitude
   * @param string $lat  Latitude
	 */
	public function setLat($lat) {
    $this->coordinate['Lat'] = $lat;
  }

  /**
   * get the Latitude
   * @return string $lat  Latitude
   */
  public function getLat() {
    return $this->coordinate['Lat'];
  }

  /**
   * set the Longitude
   * @param string $lng  Longitude
   */
  public function setLng($lng) {
    $this->coordinate['Lng'] = $lng;
  }

  /**
   * get the Longitude
   * @return string $lng  Longitude
   */
  public function getLng() {
    return $this->coordinate['Lng'];
  }

  /**
   * get the lat lng coordinate
   * @return string $point  Longitude,Longitude
   */
  public function getLatLng() {
    return $point = $this->getLat().','.$this->getLng();
  }
 
}