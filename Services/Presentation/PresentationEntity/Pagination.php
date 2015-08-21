<?php 
  /** 
   * Pagination
   * 
   * for creating bootstrap Pagination
   * By Nick Mullen 26/May/2015 
   *
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * @author nick mullen
   * @version v1.0
   */ 
  class Pagination extends Meta {

	 /**
    * @var array holds details about pagination
    */ 
   private $pagination = array();

	 public function  __construct() {}

	/**
	 * set the Pagination settings.
   * 
   * @param Boolean $controls display Previous and next options
   * @param string $size the display size
   * @param string $URL the post url
   * @param numeric $pages description the total number of pages
   * @param numeric $totalRecords the total number of rows
   * @param numeric $recordsPerPage number for rows per page
	 */
	public function setPagination($controls,$URL,$size=Null,$pages =Null,$totalRecords =Null, $recordsPerPage = Null,$currentPage=1) {
    if(isset($totalRecords) && $totalRecords !== Null && isset($recordsPerPage) && $recordsPerPage !== Null){
      $this->setPageCount($totalRecords, $recordsPerPage);
    }else{
      $this->pagination['pages'] = $pages;
    }

    $this->setSize($size);
    $this->pagination['controls'] = $controls;
    $this->pagination['url'] = $URL;
    $this->currentPage = $currentPage;
    return $this->pagination;
  }

  /**
   * set the total nmber of pages
   * 
   * @param numeric $totalRecords total number of records
   * @param numeric $recordsPerPage number of records to be shown per page
   */
  public function setPageCount($totalRecords, $recordsPerPage){
   return $this->pagination['pages']  = ceil($totalRecords / $recordsPerPage);
  }

   
  /**
   * set the display size
   * 
   * @param string $size the display size 
   */
  public function setSize($size){
    switch (strtolower ($size)) {
      case 'large':
        $this->setClass($this->getClass().' pagination-lg');
        break;
      case 'small':
        $this->setClass($this->getClass().' pagination-sm');
        break;
    }
  }

 	/**
  	*  output the object   
    * @param string $type the markup type 
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
   * render the alert as html
   * 
   * @return string pagination as html
   */
	private function renderHTML() {
    $content = ' <nav><ul ';
    $content = $content.$this->renderClass(' pagination');
    $content = $content.$this->renderID();
    $content = $content.' >';

    if($this->pagination['controls']){
      $content = $content.' 
        <li>
          <a href="'.$this->pagination['url'].'/page/1" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>';
    }

    $i = 1;
    for ($i = 1; $i <= $this->pagination['pages']; $i++) {
      $content = $content.' <li';
    
        if($this->currentPage == $i){
         $content = $content.' class="active" ';
        }

        $content = $content.' ><a href="'.$this->pagination['url'].'/page/'.$i.'">'.$i.'</a></li>';
    }
   
    if($this->pagination['controls']){
      $content = $content.' <li>
          <a href="'.$this->pagination['url'].'/page/'.($i - 1).'" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>';
    }
    $content = $content.' </ul></nav>';
		return $content;
	}
}