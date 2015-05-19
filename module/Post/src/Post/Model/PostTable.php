<?php
 namespace Post\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Expression;

 class PostTable
 {
     const FIRST_ITEMS_PER_GROUP = 2;
     const ITEMS_PER_GROUP = 4;
     
     protected $tableGateway;
     protected $adapter;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
         $this->adapter = $this->tableGateway->adapter;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     /**
     * select all main posts - type = 'n'
     * 
     */
     public function fetchMainJoinUsers($position = null, $items_per_page)
     {
 
         
         $test = $items_per_page;
         $pos = $position;
         /*if($test == 4 && $pos == 4) {
            DebugBreak();    
         }*/ 
         if($position === null) {
             throw new \Exception('A position/limit should be specified to extract from table!');
         }
         $select = new Select('posts');
        
        $select->columns(array('*'))
               ->order(array('post_time DESC'))
               ->where(array('post_type' => 'n'))
               ->limit($items_per_page)
               ->offset($position);
               
        
        $select->join('users', 'users.id = posts.post_user_id'
                     , array('post_username' => 'username', 
                             'post_username_img' => 'img'));
        $select->join('likes', 'likes.like_post_id = posts.post_id', array(), 'left')
               ->join(array('users_like' => 'users'), 
                      'likes.like_user_id = users_like.id', 
                      array('post_like_usernames' => 
                      new Expression('GROUP_CONCAT(DISTINCT users_like.username)')), 
                      'left')
               ->join('post_files', 'post_files.file_post_id = posts.post_id', 
                        array('post_file_new_names' => 
                      new Expression('GROUP_CONCAT(DISTINCT post_files.file_new_name)'),
                      'post_file_old_names' => 
                      new Expression('GROUP_CONCAT(DISTINCT post_files.file_old_name)')), 
                      'left')
               ->group(array('post_id'));                             
        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        
        $rowset = $statement->execute();
        
        /*if($test == 4 && $pos == 4) {
            foreach ($rowset as $row) {
                $res = $row;
            } 

        }*/
        
        return $rowset;
     }

     /**
     * select all reply posts of particular parent id - type = 'r'
     * 
     */
     public function fetchReplyJoinUsers($parentId = null)
     {
        if($parentId == null) {
            throw new \Exception(
                'You must specify a parent to find its replies.'
            );            
        }
        
        $select = new Select('posts');
        
        $select->columns(array('*'))
               ->order(array('post_time'))
               ->where(array('post_parent_id' => $parentId, 
                             'post_type' => 'r'));
        
        $select->join('users', 'users.id = posts.post_user_id'
                     , array('post_username' => 'username',
                             'post_username_img' => 'img' 
                            ));
        $select->join('likes', 'likes.like_post_id = posts.post_id', array(), 'left')
               ->join(array('users_like' => 'users'), 'likes.like_user_id = users_like.id',
                      array('post_like_usernames' => 
                      new Expression('GROUP_CONCAT(DISTINCT users_like.username)')),
                      'left')
               ->join('post_files', 'post_files.file_post_id = posts.post_id', 
                        array('post_file_new_names' => 
                      new Expression('GROUP_CONCAT(DISTINCT post_files.file_new_name)'),
                      'post_file_old_names' => 
                      new Expression('GROUP_CONCAT(DISTINCT post_files.file_old_name)')), 
                      'left')
               ->group('post_id');  

        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();

        return $rowset;
     }
          
     public function fetchAllJoinUsers($posts = null)
     {
        if($posts == null) {
            throw new \Exception('There are no posts.');
        }
         
        $postsArray = array();
        
        foreach ($posts as $post) {
            $postChildren = $this->findChildren($post['post_id']);
            
            if(is_array($postChildren)){
                $post['post_children'] = $postChildren;             
            } else {
                $post['post_children'] = null;
            }
            
            $postsArray[]= $post;    

            
            /*$postsArray[]['post_username'] = $post['post_username'];
            $postsArray[]['post_time'] = $post['post_time'];
            $postsArray[]['post_message'] = $post['post_message'];
            $postsArray[]['post_children'] = null;*/
            
                 
        }
        
        return $postsArray;
     }
     
     public function findPostUser($postId) {
        if($postId == null) {
            throw new \Exception(
                'You must specify a post to find its writer.'
            );            
        }

        $select = new Select('posts');
        
        $select->columns(array('*'))
               ->where(array('post_id' => $postId));
        
        $select->join('users', 'users.id = posts.post_user_id'
                     , array('post_username' => 'username'));

        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();
        $postRec = $rowset->current(); 
        return $postRec;        
                 
     }
     public function postsCount() {
          $select = new Select('posts');
        $select->columns(array('COUNT'=>new \Zend\Db\Sql\Expression('COUNT(*)')));
        
        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();
        $postsCount = $rowset->current(); 
        return $postsCount['COUNT'];       
     }
     
     public function getPost($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('post_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }
     

     public function savePost(Post $post)
     {
         $data = array(
             'post_id' => $post->post_id,
             'post_parent_id'  => $post->post_parent_id,
             'post_replyto_id'  => $post->post_replyto_id,
             'post_user_id'  => $post->post_user_id,
             'post_message'  => $post->post_message,
             'post_type'  => $post->post_type,
             'post_time'  => $post->post_time,
         );

         $id = (int) $post->post_id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
             return $this->tableGateway->lastInsertValue;
         } else {
             if ($this->getPost($id)) {
                 $this->tableGateway->update($data, array('post_id' => $id));
                 return $this->tableGateway->lastInsertValue;
             } else {
                 throw new \Exception('Post id does not exist');
             }
         }
     }

     public function deletePost($id = null)
     {
        if($id == null) {
            throw new \Exception('There is no post to delete.');
        }        
         
        $this->tableGateway->delete(array('id' => (int) $id));
     }
     
     public function updatePostMsg($postId = null, $msg = null)
     {
         if ($this->getPost($postId)) {
             $data['post_message'] = $msg;
             $this->tableGateway->update($data, array('post_id' => $postId));
             return $this->tableGateway->lastInsertValue;
         } else {
             throw new \Exception('Post id does not exist');
         }         
     }
     

     
     private function childExists($parentId = null)
     {

        /*$select->columns(array('*'))
                ->where(array('post_parent_id' => $parentId, 
                             'post_type' => 'r'));*/
        $result = $this->tableGateway->select(array('post_parent_id' => $parentId, 
                             'post_type' => 'r'));
        
        return $result;         
     }
     
     private function findChildren($parentId = null)
     {
         if($parentId == null) {
            throw new \Exception(
                'You must specify a parent to find its replies.'
            );            
         }
         
         
         $exists = $this->childExists($parentId);
         $counter = 0;
         foreach($exists as $exist)
         {
             ++$counter;
         }
         if($counter==0) return false;
         
         $replies = $this->fetchReplyJoinUsers($parentId);
         
         $postsArray = array();
         
         foreach ($replies as $reply) {
             $reply['post_parent_id'] = $parentId;
             $replyToUser = $this->findPostUser($reply['post_replyto_id']);
             $reply['post_replyto_name'] = $replyToUser['post_username'];  
             $postsArray[] = $reply;
            /*$postsArray[]['post_id']       = $reply['post_id'];
            $postsArray[]['post_username'] = $reply['post_username'];
            $postsArray[]['post_time']     = $reply['post_time'];
            $postsArray[]['post_message']  = $reply['post_message'];
            $postsArray[]['post_children'] = null;*/
            
                
         }
         
         return $postsArray; 
                
     }
 }   
?>
