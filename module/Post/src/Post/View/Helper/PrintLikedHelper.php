<?php
    namespace Post\View\Helper;
    
    use Zend\View\Helper\AbstractHelper;
    use Post\Model\Like;
    
    class PrintLikedHelper extends AbstractHelper
    {
        
        public function __invoke($liked = null, $postType = "n")
        {
            $like = new Like();
            
            $likedBy = $like->getLikedBy($liked, $postType);
            
            return $likedBy; 
        }
    }       
?>
