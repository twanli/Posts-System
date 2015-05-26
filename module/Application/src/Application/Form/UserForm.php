<?php
namespace Application\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('adduser');
        $this->setAttribute('method', 'post');
        //$this->setMethod('post');
        
        $this->add(array(
            'name' => 'user_id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'user_name',
            'type' => 'Text',
            'options' => array(
                'label' => 'User Name:',
            ),
        ));
        $this->add(array(
            'name' => 'user_role',
            'type' => 'Select',
            
            'attributes' =>  array(
                'id' => 'role',                
            ),
            
            'options' => array(
                'label' => 'Role:',
                'disable_inarray_validator' => true,
            ),
        ));
        $this->add(array(
            'name' => 'user_password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Password:',
            ),
        ));
        $this->add(array(
            'name' => 'repeat_password',
            'type' => 'Password',
            'options' => array(
                'label' => 'Repeat Password:',
            ),
        ));

        $this->add(array(
            'name' => 'user_active',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Active ?',
                'use_hidden_element' => true,
                'checked_value' => '1',
                'unchecked_value' => '0',
            ),
            /*'attributes' => array(
                'checked' => 'checked'
            )*/
        ));
        
        $this->add(array(
            'name' => 'gen_password',
            'type' => 'Checkbox',
            'options' => array(
                'label' => 'Generate Password ?',
                'use_hidden_element' => true,
                'checked_value' => 1,
                'unchecked_value' => 0          
            ),
        ));
             
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Add User',
                'id' => 'submitbutton',
            ),
        ));
    }
}  
?>
