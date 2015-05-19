<?php
    namespace Post\Model;
    
    use Zend\InputFilter\InputFilter;
    use Zend\InputFilter\InputFilterAwareInterface;
    use Zend\InputFilter\InputFilterInterface;

    class Post implements InputFilterAwareInterface
    {
        //times in seconds
        const ONE_SECOND = 1;
        const ONE_MINUTE = 60;
        const ONE_HOUR = 3600;
        const ONE_DAY = 86400;
        const ONE_MONTH = 2592000;
        const ONE_YEAR = 31104000; 
        
        public $post_id;
        public $post_parent_id;
        public $post_user_id;
        public $post_message;
        public $post_type;
        
        protected $inputFilter;

        public function exchangeArray($data)
        {
            $this->post_id = 
            (!empty($data['post_id'])) ? $data['post_id'] : null;
            $this->post_parent_id  = 
            (!empty($data['post_parent_id'])) ? $data['post_parent_id'] : null;
            $this->post_replyto_id  = 
            (!empty($data['post_replyto_id'])) ? $data['post_replyto_id'] : null;
            $this->post_user_id  = 
            (!empty($data['post_user_id'])) ? $data['post_user_id'] : null;
            $this->post_message  = 
            (!empty($data['post_message'])) ? $data['post_message'] : null;
            $this->post_type  = 
            (!empty($data['post_type'])) ? $data['post_type'] : null;
            $this->post_time  = 
            (!empty($data['post_time'])) ? $data['post_time'] : null;
        }
        
         // Add content to these methods:
        public function setInputFilter(InputFilterInterface $inputFilter)
        {
            throw new \Exception("Not used");
        }

        public function getInputFilter()
        {
            if (!$this->inputFilter) {
                $inputFilter = new InputFilter();

                $inputFilter->add(array(
                    'name'     => 'post_message',
                    'required' => true,
                ));

                $this->inputFilter = $inputFilter;
            }

            return $this->inputFilter;
        }
        
        /**
        * Determine how old post is (2 minutes ago, ... 3 days ago ...)
        * 
        * @param int $msgTime
        * 
        * @return string
        */
        public function getPostAge($msgTime = null)
        {
            $currentTime = time();
            
            $timeDiff = $currentTime - $msgTime;
                
            if($timeDiff == self::ONE_SECOND) {
               $howOld = self::ONE_SECOND." second ago"; 
            } else if($timeDiff < self::ONE_MINUTE) {
               $howOld = $timeDiff." seconds ago"; 
            } else if($timeDiff == self::ONE_MINUTE) {
               $howOld = self::ONE_MINUTE." minute ago";             
            } else if($timeDiff < self::ONE_HOUR) {
               if (($timeDiff % self::ONE_MINUTE) > 4)
                    $minutes = ceil($timeDiff / self::ONE_MINUTE);
               else
                    $minutes = floor($timeDiff / self::ONE_MINUTE);
               
               $howOld = $minutes." minutes ago";
            } else if($timeDiff == self::ONE_HOUR) {
               $howOld = self::ONE_HOUR." hour ago";
            } else if($timeDiff < self::ONE_DAY) {
               if (($timeDiff % self::ONE_HOUR) > 4)
                    $hours = ceil($timeDiff / self::ONE_HOUR);
               else
                    $hours = floor($timeDiff / self::ONE_HOUR);
               
               $howOld = $hours." hours ago";            
            }  else if($timeDiff == self::ONE_DAY) {
                $howOld = self::ONE_DAY." day ago";
            }  else if($timeDiff < self::ONE_MONTH) {
               if (($timeDiff % self::ONE_DAY) > 4)
                    $days = ceil($timeDiff / self::ONE_DAY);
               else
                    $days = floor($timeDiff / self::ONE_DAY);
               
               $howOld = $days." days ago";                
            }
            
            return $howOld;
        }
    }    
?>
