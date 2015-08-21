<?php 
  /** 
    * Carousel.
    * 
    * for creating a bootstrap Carousel 
    * By Nick Mullen 14/April/2015 
    */
  
  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;
  use Symfony\Component\DependencyInjection\ContainerInterface as Container;

  /**
   * @author nick mullen
   * @version v1.0
   */ 
class Carousel extends Meta {
	
  /**
   * @var array hold the Carousel settings
   */
  private $settings = array();

   /**
   * @var array hold the Carousel content
   */
  private $content = array();


  private $container;

	public function  __construct(Container $container) {
    $this->id ='myCarousel'; 
    $this->class ='myCarousel'; 
    $this->container = $container;
    $this->int($container,$this->id, $this->class );
  }

  /**
    * int
    * @param object $container hold the container scope
    * @param string $id the id of the container
    * @param string $class the class of the container
    */
  public function int($container,$id,$class) {
   // Lazy loading page
   // $this->setRenderAs($container -> get('teamcore.Options') ->getDspMode());
    $this->setRenderAs('load');
    $this->setID($id);
    $this->setClass($class);
  } 

  /**
  * add an item to the slider
  * 
  * @param string $item the html to be displayed
  * @param numeric $order the display order
  * @param string $titel the display title
  * @param string $caption the caption to be displayed
  */
  public function addItem($item,$order=Null,$title=Null,$caption=Null) {
    $slide['item'] = $item;
    $slide['order'] = $order;
    $slide['title'] = $title;
    $slide['caption'] = $caption;

    if ($order !== NULL && is_numeric($order)){
        $this->content[$order] = $slide;
    }else{
        array_push($this->content, $slide);
    }
    return  $this->content;
  }

  public function addContent($content){
    return  $this->content = $content;
  }


  /**
   * create the JS script to call the slider
   * 
   * @return string js to load the carousel
   */
  public function getJavaScriptLoader() {
     /* create the jquery to load the slider */
    $jsload = '$(".cr").carousel()';
    return $jsload;
  }
    
  /**
  * render the slider
  * @param string $tyoe the mark - up be be used
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
  * render the slider as html
  * @return string return the carasel as html
  */
  public function renderHTML() {

    if($this->getRenderAs() == 'IL'){
      $content = '<style>.carousel-inner > .item > img, .carousel-inner > .item > a > img { width: 100%; margin: auto; } </style>';
      /** add to the JS call that loads secondary content once the page has loaded */
      $this->container->get('teamcore.Options')->addJSclassHolders('cr');
      $this->container->get('teamcore.Options')->addJSloaders($this->getJavaScriptLoader());
      $content = $content.'<div  id="myCarousel" data-ride="carousel"  class=" cr carousel slide   myCarousel ></div>';


   }else{
      $content = '<style>.carousel-inner > .item > img, .carousel-inner > .item > a > img { width: 100%; margin: auto; } </style>';

      $content = $content.'<div   data-ride="carousel" ';
      $content = $content.$this->renderClass('cr carousel slide ');
      $content = $content.$this->renderID();
      $content = $content.' ">';

      /**  Indicators */
      $content = $content.'<ol class="carousel-indicators">';
      $i = 0;
      foreach ($this->content  as $item) {
        $content = $content.'<li data-target="#myCarousel" data-slide-to="'.$i.'"';
        if($i == 0){
          $content = $content.'class="active"';
        }
        $content = $content.'></li>';
        $i++;
      }
      $content = $content.'</ol>';

      /**  Wrapper for slides */
      $content = $content.'<div class="carousel-inner" role="listbox">';
      $x = 0;
      foreach ($this->content  as $slide) {
        $content = $content.'<div class="item';
        if($x == 0){
          $content = $content.' active"';
        }
        $x++;
        $content = $content.'">';
        $content = $content.$slide['item'];
        if($slide['title'] !==Null | $slide['caption'] !==Null ){
          $content = $content.'<div class="carousel-caption">';
          if($slide['title'] !==Null  ){
           $content = $content.'<h3>'.$slide['title'].'</h3>';
          }
          if($slide['caption'] !==Null  ){
           $content = $content.'<p>'.$slide['caption'].'</p>';
          }
          $content = $content.' </div>';
        }
        $content = $content.'</div>';
      }
      $content = $content.'</div>';
      
      /** Left and right controls */
      $content = $content.'
          <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>';

      $content = $content.'</div>';
  
    }
    return $content;
  } 
}