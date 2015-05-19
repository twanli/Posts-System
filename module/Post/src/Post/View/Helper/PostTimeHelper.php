<?php
    namespace Post\View\Helper;
    
    use Zend\View\Helper\AbstractHelper;
    use Post\Model\Post;
     
    class PostTimeHelper extends AbstractHelper
    {
        public function __invoke($msgTime = null)
        {
            $post = new Post();
            
            return $post->getPostAge($msgTime);
        }
    }       
?>
