<?php
namespace Album\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\InputFilter\FileInput;
use Zend\Validator\File\UploadFile;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Validator\Identical;
use Album\Model\AlbumFiles;

use \Zend\Validator\NotEmpty;

class Import implements InputFilterAwareInterface
{
    
    protected $inputFilter; 

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                  'name' => 'zipupload',
                  'required' => false,            
                  'validators' => array(
                      
                      new Extension(array(
                                'extension' => array('zip'),
                            )
                      ),
                  )
            ));
            

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
