<?php
namespace Album\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\InputFilter\FileInput;
use \Zend\Validator\File\UploadFile;
use \Zend\Validator\File\Size;
use \Zend\Validator\File\Extension;
use Zend\Validator\Identical;
use Album\Model\AlbumFiles;

use \Zend\Validator\NotEmpty;

class Import implements InputFilterAwareInterface
{
    
    protected $inputFilter;
    
    //Different Change
    public $test12; 

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();




 
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
            
            $inputFilter->add(array(
                  'name' => 'zipupload',
                  'required' => false,
                  //'allow_empty' => true,
                  'validators' => array(
                      
                      new Extension(array(
                                'extension' => array('zip'),
                            )
                      ),
    
                      )
                      

                )
                   
             );
             /*$inputFilter->add(array(
                  'name' => 'img',
                  //'required' => false,
                  //'allow_empty' => true,
                  'validators' => array(
                      
                      new Identical('default.png')
                      ),
                      /*new Size(array(
                                'max' => 5000000,                                
                            )
                      ),
    
                      
                      

                )
                   
             ); */

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
