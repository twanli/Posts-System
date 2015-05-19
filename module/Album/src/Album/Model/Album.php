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

class Album implements InputFilterAwareInterface
{
    public $id;
    public $artist;
    public $title;
    public $img;
    
    protected $inputFilter; 

    public function exchangeArray($data)
    {
        //DebugBreak();
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->artist = (!empty($data['artist'])) ? $data['artist'] : null;
        $this->title  = (!empty($data['title'])) ? $data['title'] : null;
        $this->img    = (!empty($data['img'])) ? $data['img']: null;        
        //......
        //$this->img
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }


    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();



            $inputFilter->add(array(
             'name'     => 'artist',
             'required' => true,
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
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
             'name'     => 'title',
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
                  'name' => 'fileupload',
                  'required' => false,
                  //'allow_empty' => true,
                  'validators' => array(
                      
                      new Extension(array(
                                'extension' => array('gif', 'png', 'jpg'),
                            )
                      ),
                      new Size(array(
                                'max' => 5000000,                                
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
