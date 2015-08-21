<?php 
    /** 
     * Accordion
     * 
     * for creating an accordion
     * By Nick Mullen 14/April/2015 
     * 
     */

   namespace LAuth\MagicBoxBundle\Services\Presentation\PresentationEntity;
   use Symfony\Component\DependencyInjection\ContainerInterface as Container;

  /**
   * @author nick mullen
   * @version v1.0
   */ 
    class Accordion extends Meta{

    /**
     * @var array for holding content
     */
	private $content = array();

    /**
     * @var string id of the container 
     */
    private $idName;

    /**
     * @var string root path of site 
     */
    private $webRoot; 

    /**
     * @var array to hold settings 
     */
    private $settings;

	public function  __construct($webRoot) {
        $this->idName = 'page-accordion';
        $this->settings  = array();
        $this->webRoot = $webRoot;
        $this->init();
    }

      /**
        * init
        */
      public function init() {
        $this->setID($this->idName);
      }
    

      /**
        * add an item to the accordion
        * @param strinf $item contain of panel
        * @param string $header the title of the panel
        * @param int $onder display order
        */
      public function addItem($item,$header,$order=Null)  {
        if ($order !== Null && is_numeric($order) == false) {
            echo "'{$order}' is not numeric", PHP_EOL;
            break;
        }
      
        $slide['item'] = $item;
        $slide['header'] = ucfirst($header);
        $slide['order'] = $order;
        $length = 5;
        $slide['id'] = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

        if ($order !== NULL){
          $this->content[$order] = $slide;
        }else{
          array_push($this->content, $slide);
        }
        return  $this->content;
      }

      public function addContent($content){
       $this->content= $content;
      }
 
    
      /**
        * render the accordion
        * 
        * @param string $type markup type to display 
        */
      public function render($type) {

        if (strtolower($type) == 'html') {
            $content = $this->renderHTML();
        } 
        return $content;
      }
  
      /**
        * render as html
        */
      public function renderHTML(){

       usort($this->content, function($a, $b) {
            return $a['order'] - $b['order'];
        });

        $content = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
        $i = 1;
        foreach ($this->content  as $item) {
          $content = $content.'
            <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading'.$this->convert_number_to_words($i).'">
              <h4 class="panel-title">
                <a data-toggle="collapse" ';
                if($i !== 1){
                  $content = $content.' class="collapsed"  aria-expanded="false" ';
                }else
                {
                  $content = $content.' aria-expanded="true"';
                }
                  $content = $content.' data-parent="#accordion" href="#collapse'.$this->convert_number_to_words($i).'" aria-controls="collapse'.$this->convert_number_to_words($i).'">
                  '.$item['header'].'
                </a>
              </h4>
            </div>
            <div id="collapse'.$this->convert_number_to_words($i).'" class="panel-collapse collapse';
            if($i == 1){
                $content = $content.' in ';
            }

             $content = $content.'" role="tabpanel" aria-labelledby="heading'.$this->convert_number_to_words($i).'">
              <div class="panel-body">
                '.$item['item'].'
              </div>
            </div>
          </div>
           ';   
           $i++;        
        }
        $content = $content.'</div>-';

        return $content;
      }

        /**
        * conver number into words 
        * @param number $number number to be converted
        */
      public function convert_number_to_words($number) {
        
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = array(
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'fourty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );
        
        if (!is_numeric($number)) {
            return false;
        }
        
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . convert_number_to_words(abs($number));
        }
        
        $string = $fraction = null;
        
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
        
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . convert_number_to_words($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= convert_number_to_words($remainder);
                }
                break;
        }
        
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }
        
        return ucfirst($string);
    }

}