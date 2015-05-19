<?php
namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface
{
    public $id;
    public $username;
    public $password;
    public $role;
    public $active;
    public $name;
    
    protected $inputFilter; 
    
    protected static $userRoles = array("superadmin" => "Super Administartor",
                                        "admin" => "Admin",
                                        "user" => "User");

    public static function getUserRoles() 
    {
        return self::$userRoles;
    } 
                       
    public function exchangeArray($data)
    {
        $this->id       = (!empty($data['id'])) ? $data['id'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->password = (!empty($data['password'])) ? ($data['password']) : null;
        $this->role     = (!empty($data['role'])) ? $data['role'] : null;
        $this->active   = ($data['active']!=null) ? $data['active'] : null;        
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
                 'name'     => 'username',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'password',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 7,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'repeat_password',
                 'required' => false,
                 /*'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),*/
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 7,
                         ),
                     ),
                     
                     array(
                        'name'    => 'Identical',
                        'options' => array(
                            'token' => 'password',
                        ),
                     ),
                     
                 ),
             ));
             $inputFilter->add(array(
                 'name'     => 'role',
                 'required' => false,
             ));
          
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }
     
         // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}  
?>
