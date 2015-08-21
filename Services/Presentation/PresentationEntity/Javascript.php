<?php 
  /** 
    * JavaScript
    * 
    * for managing javaScript files
    * By Nick Mullen 14/April/2015 
    * 
    *  @todo Include file compression
    */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * Javascript
   * 
   * @author Nick Mullen <nick.mullen@fife.gov.uk>
   * @version 1.0
  */
 class Javascript {

  /**
    * @var array $JS hold paths to the required js files
    */ 
  private $JS = array();

	public function  __construct() {}

 /**
  * check value is not in array 
  * 
  * @param string $needle string to search for
  * @param array $haystack the array to search
  */
  private function not_in_array($needle, $haystack) {
    $notfound = true;
    if (empty($haystack)){
      $notfound = true;
    }else{
      foreach ($haystack as $item) {
        if($item['url'] == $needle){
            return false;
          }else{
            $notfound = true;
          }
       }
    }
    return $notfound;
  }

 /**
  *  add a javaScript item to the object 
  * 
  * @param string $url the path to the js file
  * @param numeric $order the display order
  * @param string $browser Wrap the script tag with browser comments
  */
  public function additem($url,$order=Null,$browser=Null)  {
    $item['url'] = $url;
    $item['order'] = $order;
    $item['browser'] = $browser;

    if ($this->not_in_array($url,$this->JS)){
        if ($order !== NULL && $order !== 'Na'){
          $this->JS[$order] = $item;
        }else{
          array_push($this->JS, $item);
        }
      }
    return  $this->JS;
  }

  /**
  *  add a css item to the object   
  * 
  * @param numeric $order array position
  */
  public function removeItem($order) {
    unset($this->JS[$order]);
    return  $this->JS;
  }

  /**
  *  output the object   
  * 
  * @param string $type the type of mark-up to render
  */
  public function render($type) {
    if ($type == 'html') {
      $content = $this->renderHTML();
    } else {
      throw $this->createNotFoundException( 'type not found for'.$type);
    }
    return $content;
  }
  
  /**
  * render the ouput as html  
  * @return string script tags as html 
  */
  private function renderHTML(){
    $content = "";
    foreach ($this->JS  as $item) {
    
      if( isset($item['browser'])) {
         //die(var_dump($item));
        $content = $content.'<!-- [if '.$item['browser'].']><!-->
';
      }

      $content = $content.'<script type="text/javascript" src="'.$item['url'].'"></script>';
      
      if (isset($item['browser'])){
        $content = $content.' <![endif] -->';
      }
    }
    return $content;
  } 


}