<?php   
  /**
   * TwigJavaScript
   * 
   * Custom twig extension for javascript script tags
   * By Nick Mullen
   * 18/June/2015
   */

  namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity\Twig; 

   use Symfony\Component\DependencyInjection\ContainerInterface;

  /**
   * @author Nick Mullen
   * @version v1.0
   */
  class TwigJavascript  extends \Twig_Extension {

	
    public function  __construct(ContainerInterface $container) {
      $this->container = $container;
      $this->javascript =  $this->container->get('MB.JavascriptHeader');
    }
  
    public function getFunctions() {
      return array(
        new \Twig_SimpleFunction('Javascript', array($this, 'js'), array('is_safe' => array('html'))),
      );
    }

  public function js()
    {
      return $this->javascript->render('html');
    }

   public function getName()
    {
        return 'Javascript';
    }
}