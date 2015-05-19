<?php
namespace Album\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Validator\File\Size; 
use Zend\Validator\File\Extension;

use Imagine\Image\Box as ImageBox;
use Imagine\Image\Point as ImagePoint;
use Imagine\Image\ImageInterface;
use Imagine\Gd\Imagine as GdImagine; 

class AlbumForm extends Form
{
    const RESIZEWIDTH = 200;
    
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('album');

        $this->add(array(
         'name' => 'id',
         'type' => 'Hidden',
        ));
        $this->add(array(
         'name' => 'title',
         'type' => 'Text',
         'options' => array(
             'label' => 'Title',
         ),
        ));
        $this->add(array(
         'name' => 'artist',
         'type' => 'Text',
         'options' => array(
             'label' => 'Artist',
         ),
        ));
        $this->add(array(
         'name' => 'img',
         'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'fileupload',
            'type' => 'file',
            'options' => array(
                'label' => 'Upload Image',
            ),
        )); 
        $this->add(array(
         'name' => 'submit',
         'type' => 'Submit',
         'attributes' => array(
             'value' => 'Go',
             'id' => 'submitbutton',
         ),
        ));
        
        
        

    }
    
    public function setValues($rec)
    {
        foreach ($rec as $field => $value) {
            //if($field != "img")
                $this->get($field)->setValue($value);
        }  
    }
    
    public function uploadImage($img=null) {
        $uniqueToken = md5(uniqid(mt_rand(), true));
        $imageFileType = pathinfo(basename($img),PATHINFO_EXTENSION);
        $filename = $uniqueToken .'.'.$imageFileType;
        

        $upload = new \Zend\File\Transfer\Adapter\Http();
        
        $uploadPath = ROOT_PATH . '/public/img/albums/';
    
        $filterRename = new \Zend\Filter\File\Rename(array('target' => $uploadPath . $filename, 'overwrite' => false));
        $upload->addFilter($filterRename);

        if ($upload->receive()) {
            $this->resizeImage($uploadPath.$filename, $uploadPath.$filename);
            return $filename;

        } else {
            return false;
        }
    }  

    
    
    private function resizeImage($source = '', $destination = '')
    {
        if (empty($source)) {
            return $this;
        }

        $imagine = new GdImagine();
        $image = $imagine->open($source);
        $size  = $image->getSize()->widen(self::RESIZEWIDTH);
        $image->resize($size)->save($destination);
    }

}    
?>
