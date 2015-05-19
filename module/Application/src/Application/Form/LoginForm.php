<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class LoginForm extends Form {
 
    public function __construct($name = null) {
        
        parent::__construct('login');
        $this->setAttribute('method', 'post');
 
        $this->add(array(
            'name' => 'username',
            'type' => 'text',
            'options' => array(
                'label' => 'User Name',
                'id' => 'username',
                'placeholder' => 'User Name'            
            )
        ));
 
       $this->add(array(
            'name' => 'password',
            'type' => 'password',
            'options' => array(
                'label' => 'Password',
                'id' => 'password',
                'placeholder' => 'Password'
            )
       ));

       /*$this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox',
            'options' => array(
                'label' => 'Remember Me ?',
            )
       ));*/      
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
            ),
        ));
    }
}