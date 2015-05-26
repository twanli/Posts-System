<?php
    namespace Album\View\Helper;
    use Zend\View\Helper\AbstractHelper;
     
    class ErrorHelper extends AbstractHelper
    {
        public function __invoke($msg)
        {
            $msgErr = "";
            foreach ($msg as $key => $value) {
                $msgErr .= $value."<br>";
            }

            $outputHTML = '<div class="col-sm-offset-2 col-sm-5">'."\n".
            '<span class="alert">'.$msgErr.'</span></div>';
            
            return $outputHTML;
        }
    }  
?>
