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
        $select->join('user_roles', 'users.role = user_roles.user_roles_id');
        
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
        $rowset = $this->tableGateway->select(array('id' => $id));
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
        $select->join('user_roles', 'users.role = user_roles.user_roles_id', array('user_roles_name'));
        $select->where(array('id' => $id));
        
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
        $select->join('user_roles', 'users.role = user_roles.user_roles_id');
        $select->where(array('username' => $username));
        
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
        if(empty($user->password)) {
            $data = array(
                'username'  => $user->username,
                'role'      => $user->role,
                'active'    => $user->active,
            );
            
        } else {
            $data = array(
                'username'  => $user->username,
                'password'  => md5($user->password),
                'role'      => $user->role,
                'active'    => $user->active,
            );
        }
        
        if (empty($data['password'])) {
            unset($data['password']); 
        }
        if (empty($data['role'])) {
            unset($data['role']);  
        }
        if (empty($data['active'])) {
            unset($data['active']);  
        }        
        $id = (int) $user->id;
        if ($id == 0) {
   
            try {
                $this->tableGateway->insert($data);                
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
    
        } else {
            if ($this->getUser($id)) {
                
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('User id does not exist');
            }
        }
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
 }  
?>
