<?php  
  /** 
    * Meta
    *   
    * Common functions for all extensions
    * By Nick Mullen 14/April/2015 
    *
    */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;

  /**
   * @author nick mullen
   * @link http://getbootstrap.com/css/#responsive-utilities-classes bootstrap options
   * @version 1.0
   */ 
  class Meta  {

    /**
     * @var array hold responsive settings 
     */
    private $responsiveSettings= array();


    /**
     * @var string for holding print settings
     */
    private $printSettings = Null;

    /**
     * @var string the id to be added 
     */
    private $Id;

    /**
     *  @var striing class name to be added 
     */
    private $className;

    /**
      * init
      */
	  public function  init() {}

    /**
     *  
     */
    public function setRenderAs($RenderAs){
      $this->RenderAs = $RenderAs;
      return $this->RenderAs;
    }

    /**
     *  
     */
    public function getRenderAs(){
     return $this->RenderAs;
    }

    /**
     * hide when viewed by tablet
     * @return array  responsiveSettings
     */
    public function setTabDisabled(){
      $this->responsiveSettings['tabdisabled'] = 'hidden-sm';
      return  $this->responsiveSettings;
    }

    /**
     * show when viewed tablet
     * @return array  responsiveSettings
     */
    public function setTabEnabled(){
      $this->responsiveSettings['tabenabled'] = 'visible-sm';
      return  $this->responsiveSettings;
    }

    /**
     * hide when viewed mobile
     * @return array  responsiveSettings 
     */
    public function setMobDisabled(){
      $this->responsiveSettings['mobdisabled'] = 'hidden-xs';
      return  $this->responsiveSettings;
    }

    /**
     * show when viewed mobile
     * @return array  responsiveSettings 
     */
    public function setMobEnabled(){
      $this->responsiveSettings['mobenabled'] = 'visible-xs';
      return  $this->responsiveSettings;
    }

    /**
     * @return array  responsiveSettings 
     */
    private function getresponsiveSettings(){
      return $this->responsiveSettings;
    }

    /**
     * @param string $className name of class to be added
     * @return string class name
     */
    public function setClass($className) {
       return $this->className = $className;
    }

    /**
     * @return string class name
     */
    public function getClass() {
      return $this->className;
    }

    /**
     * @param string $id id to be added
     * @return string the id to be added 
     */
    public function setId($id) {
      return $this->Id = $id;
    }

    /**
     * @return string the id to be added  
     */
    public function getId() {
      return $this->Id;
    }


    /**
     * print block 
     */
    public function setPrintBlock(){
     $this->printSettings = '.visible-print-block';
    }

    /**
     * print inline 
     */
    public function setPrintInline(){
      $this->printSettings = '.visible-print-inline';
    }

    /**
     * print linline block 
     */
    public function setPrintInlineBlock(){
      $this->printSettings ='.visible-print-inline-block';
    }

    /**
     * print hidden 
     */
    public function setPrintHidden(){
      $this->printSettings ='.hidden-print';
    }


    /**
     * get the print settings  
     */
    public function getPrintSettings(){
      return $this->printSettings;
    }

    /**
     * For rendering ID as html
     * @param string $myId add an extra
     * @return string raw html
     */
    public function renderID($myId = Null) { 
      $content = "";
      if ($this->getId() !== Null && $this->getId() !== ''){
        $content = $content.' id="'.$this->getId().'" ';
      }
      return $content;
    }

    /**
     * For rendering class as html
     * @param string $myclass 
     * @return string raw html
     */
    public function renderClass($myclass = Null) { 
      $content = "";

      if (($this->getClass() !== '' && $this->getClass() !== Null) or 
          (sizeof($this->getresponsiveSettings()) > 0) or
          ($myclass !== Null)) {
            $content = $content.' class=" ';
            if ($myclass !== Null){
              $content = $content.$myclass.' ';
            }
            if ($this->getresponsiveSettings() !== Null){
              foreach ($this->getresponsiveSettings() as $setting) {
                $content = $content.' '.$setting ;
              }        
            }
            if ($this->getClass() !== Null && $this->getClass() !== ''){
              $content = $content.' '.$this->getClass();
            }
            if($this->getPrintSettings() !==Null){
                $content = $content.' '.$this->getPrintSettings();
            }
           $content = $content.' "';
          }
      return $content;
    }
  }