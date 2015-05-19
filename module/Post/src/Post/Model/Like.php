<?php
    namespace Post\Model;
    
    use Zend\Session\Container;
    
    class Like
    {
        const YOU = "you";
        
        public $like_id;
        public $like_post_id;
        public $like_user_id;
        
        private $postType = array("normal" => "n",
                                  "reply" => "r");

       
        public function exchangeArray($data)
        {
            $this->like_id = 
            (!empty($data['like_id'])) ? $data['like_id'] : null;
            $this->like_post_id  = 
            (!empty($data['like_post_id'])) ? $data['like_post_id'] : null;
            $this->like_user_id  = 
            (!empty($data['like_user_id'])) ? $data['like_user_id'] : null;
        }
        
        public function getLikedBy($liked = null, $postType = "n")
        {
            $userSession = new Container('user');
            $likedBy = "";
            
            if ($postType == $this->postType['normal']) {
                if (($key = array_search($userSession->username, $liked)) 
                            !== false) {
                            $firstPerson = self::YOU;
                            unset($liked[$key]);               
                } else {
                    $firstPerson = array_shift($liked);    
                }
                
                if(count($liked) == 0) {
                    $likedBy = "<span>".$firstPerson."</span>";        
                } elseif(count($liked) == 1) {
                    $secondPerson = array_shift($liked);
                    $likedBy = "<span>".$firstPerson.
                               "</span> and <span>".$secondPerson."</span>";  
                } elseif(count($liked) == 2) {
                    $secondPerson = array_shift($liked);
                    $likedBy = "<span>".$firstPerson."</span>, <span>".$secondPerson.
                    "</span> and <span title='".$liked[0]."'>other person </span>";
                } else {
                    $secondPerson = array_shift($liked);
                    $likedBy = "<span>".$firstPerson."</span>, <span>".$secondPerson.
                    "</span> and <span title='".implode(", ",$liked)."'>other "
                    .count($liked).
                    " people </span>";       
                }
                $likedBy = "<div class='liked-info'>Liked by ".$likedBy."</div>";
            } else {   //$this->postType['reply']
                $likedBy = "<span class='post-like' title='".implode(", ",$liked)."'>"
                .count($liked)."</span>";
            }
            
            return $likedBy;
            
        }
    }    
?>
