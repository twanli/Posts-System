<?php
    namespace Post\Model;
    
    class PostFiles
    {
        public $file_id;
        public $file_post_id;
        public $file_new_name;
        public $file_old_name;
        
        public function exchangeArray($data)
        {
            $this->file_id = 
            (!empty($data['file_id'])) ? $data['file_id'] : null;
            $this->file_post_id  = 
            (!empty($data['file_post_id'])) ? $data['file_post_id'] : null;
            $this->file_new_name  = 
            (!empty($data['file_new_name'])) ? $data['file_new_name'] : null;
            $this->file_old_name  = 
            (!empty($data['file_old_name'])) ? $data['file_old_name'] : null;
        }
        
    }    
?>
