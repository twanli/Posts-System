<?php
    namespace Post\View\Helper;
    
    use Zend\View\Helper\AbstractHelper;
    use Zend\Session\Container;
    
    class PrintRepliesHelper extends AbstractHelper
    {
        public function __invoke($children = null)
        {
            $userSession = new Container('user');
            
            print "<ul class='children'>";
                foreach($children as $child) {
                    print "<li id='post-".$child['post_id']."'>";
                    print "<div class='post-message'>";
                    print "<div class='message-head row'>";
                    print "<div class='col-sm-2'>";
                    print "<img src='/img/users/".$child['post_username_img'].
                          "' alt='".$child['post_username']."' />"; 
                    print "</div>";
                    print "<div class='col-sm-10'>";
                    print "<span class='author'>".$child['post_username'].
                          "</span><span> in reply to </span>
                          <span class='reply-to'>".
                          $child['post_replyto_name']."</span>";
                    print "<span class='time'>".
                        $this->view->postTime($child['post_time']).
                    "</span>";      
                    print "</div>";
                    print "</div>";
                    print "<div class='message'>"
                        .$child['post_message'].
                    "</div>";
                    $likes = explode(',',$child['post_like_usernames']);
                    $likeString = LIKE;
                    $spanString = "";
                    if ((!empty($child['post_like_usernames']))           
                            && count($likes) > 0) {
                            if (in_array($userSession->username, 
                                $likes)) {
                                $likeString = UNLIKE;                        
                            }
                            
                            $spanString = $this->view->printLikedBy(
                                    $likes, 
                                    $child['post_type']
                            );                                
                    }

                    print "<a class='post-like' href='javascript:void(0)'
                            rel='".strtolower($likeString)."'
                            data-userid='".$userSession->id."'
                            data-postid='".$child['post_id']."'
                            data-posttype='r'
                            >".
                            $likeString."</a>";
                    print "<a class='post-reply' href='javascript:void(0)'>
                            Reply</a>";
                    print $spanString;         
                    print "</div>";
                    /*if(is_array($child['post_children'])) {
                        $this->__invoke($child['post_children']);
                    }*/
                    print "</li>";
                }
            print "</ul>";
                    

        }
    }       
?>
