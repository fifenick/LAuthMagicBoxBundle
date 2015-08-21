<?php
  /**
   *  Navigation
   * for making a bootstrap navigation
   * By nick mullen
   * @todo a work in progress
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
  * @link http://getbootstrap.com/components/#navbar bootstrap site
  * @author nick mullen
  * @version 1.0
  */
  Class Navigation {

    /**
     * @var array the left side nav links 
     */ 
  	private $leftNav = array();

    /**
     *  @var array the right side nav links 
     */
    private $rightNav = array();

    /**
     * @var array holds the dropdowns
     */
    private $dropDown = array();
    
    /**
     * @var string $brandLink the url for the brandlink (logo in the top left)
     */
    private $brandLink  = Null;

    /**
     * @var string $brandText display text fo the brandLink (logo in the top left) 
     */
    private $brandText = Null;
 
    /**
     * @var string $navAlign the allingment of the navigation 
     */
    private $navAlign  = Null;

    /**
     *  @var boolean  $inverse use the inverse display style
     */ 
    private $inverse = Null;

    /**
     *@var boolean display the site searh 
     */
    private $withSearch = false;

    /**
     * @var string the post url of the  site search form 
     */
    private $searchURL = Null;

  	public function  __construct() { }

    /**
     * @param array $a array to sort
     * @param string $b key to sort on 
     * @return array sorted array
     */
    public function sortByOrder($a, $b) {
      return $a['order'] - $b['order'];
    }

    /**
     * @return boolean true:display the search form 
     */
    public function addSiteSearch() {
      return $this->withSearch  = true;
    }

    /**
     * @return  boolean display the search form 
     */
    public function getSiteSearch() {
      return $this->withSearch;
    }

    /**
     *  @return string the post url for the search form
     */
    public function getSearchURL() {
      return  $this->searchURL;
    }

    /**
     *  @param string $URL the post url for the search form 
     */
    public function setSearchURL($URL) {
      return   $this->searchURL = $URL;
    }

    
    /**
     * @return string search for html
     */
    private function renderSiteSearch() {
      $content = '<div class="sidebar-search" style="padding:8px;">
                              <div class="input-group custom-search-form">
                                  <input type="text" class="form-control" placeholder="Site Search...">
                                  <span class="input-group-btn">
                                  <button class="btn btn-default" type="button">
                                      <i class="fa fa-search"></i>
                                  </button>
                              </span>
                              </div>
                              <!-- /input-group -->
                          </div>';
      return  $content;
    }


    /**
     *  @param array $options array of option arrays
     */
    public function addOptions($options){
      foreach ($options as $params) {
        $this->addlink($params);
      }
    }

    /**
     * @todo split this into a number of funtions
     * 
     * @param array $params add a link to the navigation bar
     * 
     * url = the post url
     * text = text to displat
     * order = the item order
     * side = left|right
     * brandLink = post url for the logo
     * brandText = the brand html to display (for the logo)
     * dropTitle = title of the dropdown menu
     * dropDown =   the dropdown
     * dropDownOrder = the order of the item in the dropdown
     * divider = add a dropdown divider
     * header = add a dropdown header
     * linkClass = add an Icon class the the link
     * dropDownClass = add an icon class to the dropdown header
     */
    public function addlink(array $params) {
      $defaults = array( 'url'=>'','text'=>'','order'=>'','side'=>'left','brandLink'=>'','brandText'=>'','dropTitle'=>'','dropDown'=>'','dropDownOrder'=>'','divider'=>'','header'=>'','linkClass'=>'','dropDownClass'=>'');
      $args = array_merge($defaults, array_intersect_key($params, $defaults));
      list($url,$text,$order,$side,$brandLink,$brandText,$dropTitle,$dropDown,$dropDownOrder,$divider,$header,$linkClass,$dropDownClass) = array_values($args);
      
      $link = array();

      /** if is drop down */
      if($this->isDropDown($args)){
        $menu = $this->getMenu($side);
        /** get the menu */
        $myDropDown = $this->getMenuItem($menu,$order,$dropTitle,$dropDownClass);
        /** add dropdown menu item*/
        $myDropDown['links'][$dropDownOrder] = $this->createLink($url,$text,$dropDownOrder,$divider,$header,$linkClass);
        $item = $myDropDown;
      }else{
         $item = $this->createLink($url,$text,$order,$divider,$header,$linkClass);
      }
      
      /** add the item to a menu */
      $item = $this->addToMenu($order,$side,$item);
      /** set the brand */
      if ($brandLink !== NULL){
       $this->setBrandLink($brandLink);
      }
      if ($brandText !== NULL){
       $this->setBrandText($brandText);
      }
    }

  /**
    * add a link to a menu
    * 
    * @param number $order the display order
    * @param string $side left or right nav
    * @param array $item the item to be added
    */
   private function addToMenu($order=Null,$side,$item){
      if ($order !== NULL){
          if(strtolower($side) == 'right'){
            $this->rightNav[$order] = $item;
          }else{
            $this->leftNav[$order] = $item;
          }
      }else{
          if(strtolower($side) == 'right'){
            array_push($this->rightNav, $item);
          }else{
            array_push($this->leftNav, $item);
          }       
      }
    }

    /**
     *  make a link array
     * 
     *  @param string $url the post url
     *  @param string $text the display text of the link
     *  @param numeric $order the display order of the link
     *  @param boolean $divider is the item a menu divider
     *  @param boolean $header is the itme a menu header 
     *  @param string $linkClass class to be added to the link
     *  @return array link item
     */
    private function createLink($url,$text,$order,$divider,$header,$linkClass){
      $link['url'] = $url;
      $link['text'] = $text;
      $link['order'] = $order;
      $link['header'] = $header;
      $link['divider'] = $divider;
      $link['linkClass'] = $linkClass;

      return $link;
    }

    /**
     * check is link a dropdown
     * 
     * @param array $args link array 
     */
    private function isDropDown($args){
      if ((isset($args['dropDown']) && $args['dropDown'] !== Null  && $args['dropDown'] !=='')
        || (isset($args['links']) && isset($args['links']) !== Null)
       ){
        return true;
      }else{
        return false;
      }
    }

    /**
     * ??? 
     */
    private function getMenuItem($menu,$order,$dropTitle,$dropClass){
      if (isset($menu[$order]) && $menu[$order]){
        $myDropDown =  $menu[$order];
        $myDropDown['dropTitle'] = $dropTitle;
        $myDropDown['dropClass'] = $dropClass;
      }else{
        $myDropDown = array();
        $myDropDown['dropTitle'] = $dropTitle;
        $myDropDown['dropClass'] = $dropClass;
      }
      return $myDropDown;
    }

    /**
      * return a menu
      * @param string $side right or left
      */
    public function getMenu($side){
      if($side == 'right'){
        return $this->rightNav;
      }else{
        return $this->leftNav;
      }
    }

    /**
      * set the brand link (top left logo)
      *  @param string $brandLink post url for logo
      * 
      */
    public function setBrandLink($brandLink){

      $this->brandLink = $brandLink;
    }

    /**
      * get the brandlink
      * @return string post url for logo
      */
    private function getBrandLink(){
      return $this->brandLink;
    }

    /**
      * get the branding text
      * @param string $brandtext logo text
      */
    public function setBrandText($brandText){
      $this->BrandText = $brandText;
    }
    
    /**
      * get the brand text
      * @return string the logotext
      */
    public function getBrandText(){
      return $this->brandText;
    }

    /**
    * fix the navbar alignment ,options navbar-fixed-bottom , navbar-static-top , navbar-fixed-top
    * @param string $align set the css alignment class
    */
    public function setAlignNav ($align){
      return $this->navAlign = $align;
    }

    /**
      * get the navbar alignment
      * @return string return the alignment class
      */
    private function getAlignNav(){
      return $this->navAlign;
    }

    /**
    * set the inverse. ,options navbar-inverse.
    * @param boolen $inverse inverse the navbar style
    */
    public function setInverse($inverse){
      if($inverse == True){
         return $this->inverse = 'navbar-inverse';
      }else{
         return $this->inverse = Null;
      }
    }

    /**
      * get the navbar alignment
      * @return string the inverse style
      */
    private function getInverse(){
       return $this->inverse;
    }


    /**
    * render the nav bar
    * @param string $type return the navigation as mark up
    */
    public function render($type) {
      if ($type == 'html') {
          $content = $this->renderHTML();
      }else{
        throw $this->createNotFoundException( 'type not found for'.$type);
      }
      return $content;
    }

    /**
     * @return string html for dropdown divider 
     */
    private  function renderDivider(){
      return '<li class="divider"></li>';
    }

    /**
     * @return string html for a dropdown header 
     */
    private  function renderHeader($text){
      return '<li class="dropdown-header">'.$text.'</li>';
    }

    /**
     * @param array $link convert link array into html 
     */
    private  function renderLink($link){
      $content = '<li><a href="'.$link['url'].'">';
      if(isset($link['linkClass']) && $link['linkClass'] !== ''){
        $content = $content.'<i class="'.$link['linkClass'].'"></i> ';
      }
      $content = $content.$link['text'].'</a></li>';
      return $content;
    }

    /**
     * @param array $link render link as dropdown option
     * @param boolean $submenu is dropdown nested
     * @todo complete the nested dropdown option
     */
    private  function  renderDropDown($link,$submenu=Null){
      if ($submenu){
         $content ='<li class="menu-item dropdown dropdown-submenu">';
      }else{
         $content = '<li class="menu-item dropdown">';
      }
      
      $content = $content.'<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">';
      if(isset($link['dropClass']) && $link['dropClass'] !==''){
        $content = $content.'<i class="'.$link['dropClass'].'"></i>';
      }

      $content = $content.$link['dropTitle'].'<span class="caret"></span></a>';
      

      $content = $content.' <ul class="dropdown-menu" role="menu">';
      foreach ($link['links'] as $item) {
        //** nested dropdown */
       # if ($this->isDropDown($item)){
       #   $content = $content.$this->renderDropDown($item,true);
       # }else{
          if(isset($item['divider']) && $item['divider'] == True){
            $content = $content.$this->renderDivider();
          }elseif(isset($item['header']) && $item['header'] == True){
            $content = $content.$this->renderHeader($item['text']);
          }else{

            $content = $content.$this->renderLink($item);
        #  }
        }
      }
      $content = $content.'  </ul></li>';
      return $content;
    }

    /**
     * @param string $side render the left or right 
     */
    private  function renderMenu($side){
      // aligned right
      if ($side == 'right'){
        $content = '<ul class="nav navbar-nav navbar-right">';
      }else{
        // aligned left
        $content = '<ul class="nav navbar-nav">';
      }
    
      foreach ($this->getMenu($side) as $link) {
        if ($this->isDropDown($link)){
          $content = $content.$this->renderDropDown($link);
        }else{
          $content = $content.$this->renderLink($link);
        }
       }
       $content = $content.'</ul>';
       return $content;
    }

    /**
    * render the nav as html
    * @return string render menu as html
    */
    private  function renderHTML() {

  	 $content = '<nav class="navbar navbar-default '.$this->getAlignNav().' '.$this->getInverse().'">
  	  <div class="container-fluid">
  	    <div class="navbar-header">
  	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
  	        <span class="sr-only">Toggle navigation</span>
  	        <span class="icon-bar"></span>
  	        <span class="icon-bar"></span>
  	        <span class="icon-bar"></span>
  	      </button>
  	      <a class="navbar-brand" href="'.$this->getBrandLink().'">'.$this->getBrandText().'</a>
  	    </div>';

  	  $content = $content.' <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">';      
      // get the right menu
      $content = $content.$this->renderMenu('right');
    
      $useSiteSearch = $this->getSiteSearch();

      if(isset($useSiteSearch) && $useSiteSearch !==false){
        $content = $content.$this->renderSiteSearch();
      }   

      // get the left
      $content = $content.$this->renderMenu('left');
      $content = $content.'</div></div></nav>';
      return  $content;
    }	 
  }