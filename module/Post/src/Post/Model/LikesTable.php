<?php
 namespace Post\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\Sql\Select;
 use Zend\Db\Sql\Sql;
 use Zend\Db\Sql\Expression;

 class LikesTable
 {
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
     
     public function fetchPostLikes($postId = null)
     {
        if($postId == null) {
            throw new \Exception(
                'You must specify a post to find its likes.'
            );            
        }

        $select = new Select('likes');

        $select->where(array('like_post_id' => $postId));

        $select->join('users', 'users.user_id = likes.like_user_id'
                 , array('post_like_usernames' => 
                  new Expression('GROUP_CONCAT(users.user_name)'))
                 );
  

        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();
        $rec = $rowset->current();
        
        if(empty($rec['post_like_usernames'])) {
            return false;
        } else {
            $likes = explode(",",$rec['post_like_usernames']);
            return $likes;       
        }
     
     }

     public function getLike($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('like_id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }
          
     public function saveLike(Like $like)
     {
         $data = array(
             'like_user_id' => $like->like_user_id,
             'like_post_id'  => $like->like_post_id,
         );

         $id = (int) $like->like_id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getLike($id)) {
                 $this->tableGateway->update($data, array('like_id' => $id));
             } else {
                 throw new \Exception('Like id does not exist');
             }
         }
     }

     public function deleteLike($data)
     {
         $this->tableGateway
            ->delete(array('like_post_id' => (int) $data['like_post_id'], 
                           'like_user_id' => (int) $data['like_user_id']));
     }
 }

    
?>
