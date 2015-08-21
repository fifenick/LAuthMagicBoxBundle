<?php namespace team\coreBundle\Services\Elements;

/* 
 * coreBundle\Services\Elements\PageCSS
 * this file is part of team/corebundle/pageCollection
 * for managing style sheets
 * By Nick Mullen 14/April/2015 
 *
 */

Class CSS {	

  private $css;

	public function  __construct() {
    $this->css = array();
  }

 /**
  * check value is not in array 
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
  *  add a css item to the object   
  */
  public function additem($url,$media=Null,$order=Null) {
    $item['url'] = $url;
    $item['order'] = $order;
    $item['media'] = $media;
    if ($this->not_in_array($url, $this->css)){
      if ($order !== NULL){
        $this->css[$order] = $item;
      }else{
        array_push($this->css, $item);
      }
    }
    return  $this->css;
  }

 /**
  *  remove a css itme from the object   
  */
  public function removeItem($order){
    unset($this->css[$order]);
    return  $this->css;
  }

 /**
  *  output the object   
  */
  public function render($type){
    if ($type == 'html') {
      $content = $this->renderHTML();
    }else{
      throw $this->createNotFoundException( 'type not found for'.$type);
    } 
    return $content;
  }

 /**
  * render the ouput as html   
  */
  private function renderHTML(){
    $content = "";
    foreach ($this->css  as $item) {
      $content = $content.'<link rel="stylesheet" type="text/css" href="'.$item['url'].'" ';
      if(isset($item['media']) && $item['media'] != Null){
        $content = $content.' media="'.$item['media'].'"';
      }
      $content = $content.'/>';      
    }
    return $content;
  }  
}