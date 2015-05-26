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

class Album implements InputFilterAwareInterface
{
    public $album_id;    
    public $album_artist;
    public $album_title;
    public $album_img;

    protected $inputFilter; 

    public function exchangeArray($data)
    {
        $this->album_id     = (!empty($data['album_id'])) ? $data['album_id'] : null;
        $this->album_artist = (!empty($data['album_artist'])) ? $data['album_artist'] : null;
        $this->album_title  = (!empty($data['album_title'])) ? $data['album_title'] : null;
        $this->album_img    = (!empty($data['album_img'])) ? 
                                    $data['album_img']: null;        
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
             'name'     => 'album_artist',
             'required' => true,
             'filters'  => array(
                 array('name' => 'StripTags'),
                 array('name' => 'StringTrim'),
             ),

            ));

            $inputFilter->add(array(
             'name'     => 'album_title',
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
