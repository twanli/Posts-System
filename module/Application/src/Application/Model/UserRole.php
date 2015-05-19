<?php
namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Permissions\Acl\Acl;
 
class UserRole 
{
    public $user_roles_id;
    public $user_roles_role;
    public $user_roles_name;

    protected $inputFilter;
    
    const ROLE_SUPERADMIN = "superadmin";
    const ROLE_ADMIN = "admin";  
    const ROLE_USER = "user";
    
    const USERS_INDEX = "user:index";
    const USERS_DEL = "user:delete";
    const USERS_EDIT = "user:edit";
    const USERS_ADD = "user:add";
    const USERS_GEN_PASSWORD = "user:genPassword";
    
    
    const USERS_ACTIVE = "users:active";
    const ROLES_SELECT = "roles:select";
        
    const ALBUMS_DEL = "album:delete";
    const ALBUMS_ADD = "album:add";
    const ALBUMS_EDIT = "album:edit";
    const ALBUMS_IMPORT = "album:import";
    
    public function initAcl()
    {
        $acl = new Acl();
        $acl->addRole(self::ROLE_SUPERADMIN)
             ->addRole(self::ROLE_ADMIN)
             ->addRole(self::ROLE_USER);

        
        $acl->addResource(self::USERS_INDEX)
             ->addResource(self::USERS_ADD)
             ->addResource(self::USERS_EDIT)
             ->addResource(self::USERS_DEL)
             ->addResource(self::ALBUMS_ADD)
             ->addResource(self::ALBUMS_EDIT)
             ->addResource(self::ALBUMS_DEL)
             ->addResource(self::ALBUMS_IMPORT)
             ->addResource(self::USERS_ACTIVE)
             ->addResource(self::ROLES_SELECT);
        
        $acl->allow(self::ROLE_SUPERADMIN, self::USERS_INDEX);
        $acl->deny(self::ROLE_ADMIN, self::USERS_INDEX);
        $acl->deny(self::ROLE_USER, self::USERS_INDEX);        

        $acl->allow(self::ROLE_SUPERADMIN, self::USERS_ADD);
        $acl->deny(self::ROLE_ADMIN, self::USERS_ADD);
        $acl->deny(self::ROLE_USER, self::USERS_ADD);
        
        $acl->allow(self::ROLE_SUPERADMIN, self::USERS_DEL);
        $acl->deny(self::ROLE_ADMIN, self::USERS_DEL);
        $acl->deny(self::ROLE_USER, self::USERS_DEL);


        $acl->allow(self::ROLE_SUPERADMIN, self::USERS_ACTIVE);
        $acl->deny(self::ROLE_ADMIN, self::USERS_ACTIVE);
        $acl->deny(self::ROLE_USER, self::USERS_ACTIVE);              

        $acl->allow(self::ROLE_SUPERADMIN, self::ROLES_SELECT);
        $acl->deny(self::ROLE_ADMIN, self::ROLES_SELECT);
        $acl->deny(self::ROLE_USER, self::ROLES_SELECT);    

        $acl->allow(self::ROLE_SUPERADMIN, self::ALBUMS_ADD);
        $acl->allow(self::ROLE_ADMIN, self::ALBUMS_ADD);
        $acl->deny(self::ROLE_USER, self::ALBUMS_EDIT);
        
        $acl->allow(self::ROLE_SUPERADMIN, self::ALBUMS_EDIT);
        $acl->allow(self::ROLE_ADMIN, self::ALBUMS_EDIT);
        $acl->deny(self::ROLE_USER, self::ALBUMS_EDIT);
        
        $acl->allow(self::ROLE_SUPERADMIN, self::ALBUMS_IMPORT);
        $acl->allow(self::ROLE_ADMIN, self::ALBUMS_IMPORT);
        $acl->deny(self::ROLE_USER, self::ALBUMS_IMPORT);

        $acl->allow(self::ROLE_SUPERADMIN, self::ALBUMS_DEL);
        $acl->allow(self::ROLE_ADMIN, self::ALBUMS_DEL);
        $acl->deny(self::ROLE_USER, self::ALBUMS_DEL);
        
        return $acl;
    }
         
    public function exchangeArray($data)
    {
        $this->user_roles_id       = (!empty($data['user_roles_id'])) ? $data['user_roles_id'] : null;
        $this->user_roles_role     = (!empty($data['user_roles_role'])) ? $data['user_roles_role'] : null;
        $this->user_roles_name     = (!empty($data['user_roles_name'])) ? $data['user_roles_name'] : null;
    }
    
    
}  
?>
