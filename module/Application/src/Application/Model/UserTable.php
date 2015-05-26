<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class UserTable
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
    
    public function fetchAllJoinRoles()
    {
        $select = new Select('users');
        $select->columns(array('*'));
        $select->join('user_roles', 
        'users.user_role = user_roles.user_roles_id');
        
        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();

        return $rowset;
    }
    
    /**
    * Return Id of last inserted user
    * @return int
    * 
    */
    public function lastAddedUser()
    {
        return $this->tableGateway->lastInsertValue;
    }

    public function getUser($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('user_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getUserJoinRole($id)
    {
        $id  = (int) $id;
        
        $select = new Select('users');
        $select->columns(array('*'));
        $select->join('user_roles', 'users.user_role = user_roles.user_roles_id'
                    , array('user_roles_name'));
        $select->where(array('user_id' => $id));
        
        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }    
    
    public function getUserByName($username)
    {
        
        /*$select = new Select('users');
        $select->columns(array('*'));
        $select->join('user_roles', 'users.role = user_roles.id');
        $select->where */
        $select = new Select('users');
        $select->columns(array('*'));
        $select->join('user_roles', 'users.user_role = user_roles.user_roles_id');
        $select->where(array('user_name' => $username));
        
        $sql = new Sql($this->adapter);
        $statement = $sql->prepareStatementForSqlObject($select);
        $rowset = $statement->execute();
        
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $username");
        }
        return $row;
    }
    
    public function saveUser(User $user)
    {
        if(empty($user->user_password)) {
            $data = array(
                'user_name'      => $user->user_name,
                'user_role'      => $user->user_role,
                'user_active'         => $user->user_active,
            );
            
        } else {
            $data = array(
                'user_name'  => $user->user_name,
                'user_password'  => md5($user->user_password),
                'user_role'      => $user->user_role,
                'user_active'    => $user->user_active,
            );
        }
        
        if (empty($data['user_password'])) {
            unset($data['user_password']); 
        }
        if (empty($data['user_role'])) {
            unset($data['user_role']);  
        }
        if (empty($data['user_active'])) {
            unset($data['user_active']);  
        }        
        $id = (int) $user->user_id;
        if ($id == 0) {
   
            try {
                $this->tableGateway->insert($data);                
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
    
        } else {
            if ($this->getUser($id)) {
                
                $this->tableGateway->update($data, array('user_id' => $id));
            } else {
                throw new \Exception('User id does not exist');
            }
        }
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('user_id' => (int) $id));
    }
 }  
?>
