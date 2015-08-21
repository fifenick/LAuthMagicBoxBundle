<?php 
  /**
   *  Breadcrumbs
   * 
   *  for creating bootstrap Breadcrumbs
   *  By Nick Mullen 5/May/2015 
   *
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * @author nick mullen
   * @version 1.0
   * @link http://getbootstrap.com/components/#breadcrumbs bootstrap site 
   */
  class Breadcrumb extends Meta {
    
   /**
    * @var array to hold the links 
    */
	 private $breadcrumbs = array();

	 public function  __construct() {
   }

	/**
	 * add Link array to breadcrumbs array
   *
   * @param string $url the post url
   * @param string $text the display text
   * @param numeric $order the display order of the link 
	 */
  	public function addLink($URL,$text,$order) {
      $link = '';
      $link['URL'] = $URL;
      $link['text'] = $text;
      $link['order'] = $order;
      $this->breadcrumbs[$order] = $link;
    }

    /**
     * return links array
     * 
     * @return array array of links
     */
    public function getLinks() {
      // sort the aray
      if(sizeof($this->breadcrumbs) > 1){
        usort($this->breadcrumbs, function($a, $b) {
         return $a['order'] - $b['order'];
        });
      }
      return $this->breadcrumbs;
    }

    /**
     * set link array 
     * 
     * @param array $breadcrumbs set the link array
     * @return array array of link arrays
     */
    public function setLinks($breadcrumbs) {
      return $this->breadcrumbs = $breadcrumbs;
    }

   	/**
    	* output the array as markup code
      * 
      * @param string $type description 
      * @return string raw code
    	*/
  	public function render($type) {
      	if (strtolower($type) == 'html') {
      		$content = $this->renderHTML();
      	} else{
        		throw $this->createNotFoundException( 'type not found for'.$type);
      	}
  		return $content;
    }

    /**
     * render the breadcrumb as html
     * 
     * @return string raw html
     */
  	private function renderHTML() {
      $content = ' <ol ';
      $content = $content.$this->renderClass(' breadcrumb');
      $content = $content.$this->renderID();
      $content = $content.' >';
      $i = 1 ; 
      foreach ($this->getLinks() as $Link) {
        $content = $content.'<li';
        if(sizeof($this->getLinks()) == $i){
          $content = $content.'  class="active"';
        } 
        $content = $content.'><a href="'.$Link['URL'].'">'.$Link['text'].'</a></li>';
        $i++;
      }
     $content = $content.' </ol>';
  		return $content;
  	}
  }