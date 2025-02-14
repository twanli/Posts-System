<?php
    namespace Application\View\Helper;
    use Zend\View\Helper\AbstractHelper;
     
    class ErrorHelper extends AbstractHelper
    {
        public function __invoke($msg)
        {
            //DebugBreak();
            $msgErr = "";
            foreach ($msg as $key => $value) {
                $msgErr .= $value."<br>";
            }

            $outputHTML = '<div class="col-sm-offset-2 col-sm-3">'."\n".
            '<span class="alert">'.$msgErr.'</span></div>';
            
            return $outputHTML;
        }
    }  
?>
