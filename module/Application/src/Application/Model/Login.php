<?php
namespace Application\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\InputFilter\FileInput;
use Zend\Validator\File\UploadFile;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Validator\Identical;


use Zend\Validator\NotEmpty;

class Login implements InputFilterAwareInterface
{
    
    protected $inputFilter; 


    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getInputFilter()
    {
        $isEmpty = \Zend\Validator\NotEmpty::IS_EMPTY;

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();



            $inputFilter->add(array(
            'name' => 'username',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'User Name can not be empty.'
                        )
                    ),
                ),
            ),

             /*'validators' => array(
                 array(
                     'name'    => 'StringLength',
                     'options' => array(
                         'encoding' => 'UTF-8',
                         'min'      => 1,
                         'max'      => 100,
                     ),
                 ),
             ),*/
            ));

            $inputFilter->add(array(
                'name' => 'password',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                $isEmpty => 'Password can not be empty.'
                            )
                        )
                    )
                )
            ));
            /*$inputFilter->add(array(
                'name' => 'rememberme',
                'required' => false,
            ));*/
 
/*
            /*$inputFilter->add(
                array(
                    'name' => 'fileupload',
                    'required' => false,
                    'validators' => array(
                        
                        array(
                            'name' => 'Extension',
                            'options' => array(
                                'extension' => 'png',
                                'messages' => array(
                                    \Zend\Validator\File\Extension::FALSE_EXTENSION => 'Please enter a valid file.',
                                ),
                            ),

                        )
                    )
                )
            );*/
            
           $this->inputFilter = $inputFilter;
        }
        
        return $this->inputFilter;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }


  
}
?>
