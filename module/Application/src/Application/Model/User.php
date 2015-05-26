<?php
namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class User implements InputFilterAwareInterface
{
    const GEN_PASS_LENGHT = 8;
    
    public $user_id;
    public $user_name;
    public $user_password;
    public $user_role;
    public $user_active;

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
        $this->user_id       = (!empty($data['user_id'])) ? 
                                $data['user_id'] : null;
        $this->user_name     = (!empty($data['user_name'])) ? 
                                $data['user_name'] : null;
        $this->user_password = (!empty($data['user_password'])) ? 
                                ($data['user_password']) : null;
        $this->user_role     = (!empty($data['user_role'])) ? 
                                $data['user_role'] : null;
        $this->user_active   = ($data['user_active']!=null) ? 
                                $data['user_active'] : null;        
    }
    
    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    public static function genPassword()
    {
        return substr(md5(uniqid(mt_rand(), true)), 
                        0, self::GEN_PASS_LENGHT);
    }
    public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'user_name',
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
                 'name'     => 'user_password',
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
                            'token' => 'user_password',
                        ),
                     ),
                     
                 ),
             ));
             $inputFilter->add(array(
                 'name'     => 'user_role',
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
