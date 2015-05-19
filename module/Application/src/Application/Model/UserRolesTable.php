<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class UserRolesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
       $resultSet = $this->tableGateway->select();
       return $resultSet;
    }
    
    /**
    * Return Id of last inserted user
    * @return int
    * 
    */
    public function lastAddedRole()
    {
        return $this->tableGateway->lastInsertValue;
    }

    public function getUserRole($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('user_roles_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    
    
    public function saveUserRole(UserRole $role)
    {
        $data = array(
            'users_roles_role'  => $role->user_roles_role,
            'users_roles_name'  => $role->user_roles_name
        );

        $id = (int) $role->id;
        if ($id == 0) {
            //DebugBreak();
            try {
                $this->tableGateway->insert($data);                
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
    
        } else {
            if ($this->getUserRole($id)) {
                $this->tableGateway->update($data, array('user_roles_id' => $id));
            } else {
                throw new \Exception('User id does not exist');
            }
        }
    }

    public function deleteUserRole($id)
    {
        $this->tableGateway->delete(array('id' => (int) $id));
    }
 }  
?>
