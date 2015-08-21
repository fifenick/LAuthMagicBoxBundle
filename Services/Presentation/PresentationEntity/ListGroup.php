<?php   
  /** 
    * ListGroup 
    * for creating a bootstrap lists
    * By Nick Mullen 14/April/2015 
    *
    */

    namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

    /**
     * @author nick mullen
     * @version 1.0
     */
  class ListGroup extends Meta {

   /**
    * @var array list items
    */
	 private $list = array();

  /**
   * @var boolean is the list group
   * @link http://getbootstrap.com/components/#list-group text
   */
	 private $listGroup;

    /**
     * @var string order by 
     */
   private $sortBy;

   public function  __construct() {
      $this->listGroup = true;
      $this->sortBy = 'N';
    }

	/**
	 *  add an item to the list
   * 
   *  @param array $params list options
   * label = the display text
   * order = the display order
   * link = the post url
   * itemClass = il class
   * itemId = il id
   * linkClass = <a  class
   * linkId = <a id
	 */
	public function addItem(array $params) {
		$defaults = array('label'=>Null, 'order'=>Null, 'link'=>Null, 'itemClass'=>Null, 'itemId'=>Null, 'linkClass'=>Null, 'linkId'=>Null);
		$args = array_merge($defaults, array_intersect_key($params, $defaults));
		list($label,$order,$link,$itemClass,$itemId,$linkClass,$linkId) = array_values($args);
    
    // create the list item 
    $item = array();
    $item['label'] = $label;
    $item['link'] = $link;
    $item['order'] = $order;
    $item['itemClass'] = $itemClass;
		$item['itemId'] = $itemId;
		$item['linkClass'] = $linkClass;
		$item['linkId'] = $linkId;
		
		if ($order !== Null && is_numeric($order) == false) {
      echo "'{$order}' is not numeric", PHP_EOL;
      break;
    }

    // add item to list
		if ($order !== NULL){
			$this->list[$order] = $item;
		}else {
			array_push($this->list, $item);
		}	

    return  $this->list;
  }

  /**
    * remove an item from the list
    * @param numeric $order array position
    * @return array items
    */
 	public function removeItem($order) {
		unset($this->list[$order]);
		return  $this->list;
  }

  /**
    *  Make the list a list group 
    *  @param boolean $listGroup use list group
    *  @return boolean use list group
    */
  public function setListGroup($listGroup) {
     return $this->listGroup = $listGroup;
  }

  /**
    *  get the list group setting
    *  @return boolean use list group
    */
  public function getListGroup() {
     return $this->listGroup;
  }

  /**
   * get the sort by setting
   * @return string N or A 
   * 
   */
  public function getSortBy() {
    return $this->sortBy;
  }

  /**
   * Set the sort by 
   * @param string $sortBy A or N
   * @return string the sort by option
   */
  public function setSortBy($sortBy) {
    return $this->sortBy = $sortBy;
  }


  /**
    * return the list 
    * @return array list items
    */
	public function getList() {
    // sote the array
    if ($this->getSortBy() == 'N'){
      usort($this->list, function($a, $b) {
      return $a['order'] - $b['order'];
      });
    }else{
     usort($this->list, function($a, $b) {
        return strnatcmp($a['label'], $b['label']);
      });
    }
		return  $this->list;
  }

 	/**
  	* output the list   
    * @param string $type the markup type
    * @return string raw mark-up 
  	*/
	public function render($type) {
    if (strtolower($type) == 'html') {
    	$content = $this->renderHTML();
    }else{
      throw $this->createNotFoundException( 'type not found for'.$type);
    }
		return $content;
  }

  /**
   * render the list as html 
   * @return string raw html
   */
	public function renderHTML()
	{
   	$content = '<ul';
   	if($this->getListGroup()){
    	$content = $content.$this->renderClass('list-group ');
    }else{
    	$content = $content.$this->renderClass();
    }
	  $content = $content.$this->renderID();
   	$content = $content.'>';

   	foreach ($this->getList()  as $item) {
   		$content = $content.'<li  class="';

   		if($this->listGroup){
   			$content = $content.'  list-group-item';
   		}
			if($item['itemClass'] !== Null){
				$content = $content.$item['itemClass'];
			}
			$content = $content.'" ';
   			
			if($item['itemId'] !== Null) {
   				$content = $content.' Id="'.$item['itemId'].'" ';
   		}
      $content = $content.">";
			if($item['link'] !== Null) {
				$content = $content.'<a';
				if($item['linkClass'] !== Null) {
       				$content = $content.' class="'.$item['linkClass'].'" ';
       			}
				if($item['linkId'] !== Null) {
       				$content = $content.' Id="'.$item['linkId'].'" ';
       			}
				$content = $content.' href="'.$item["link"].'">'.$item["label"].'</a> </li>';
			}else{
			 	$content = $content."".$item["label"].'</li>';
			} 	
    }
		$content = $content.'</ul>';    	
		return $content;
	}
}