<?php
namespace Album\Form;

use Zend\Form\Form;
use Zend\Form\Element;
/**
* Form for searching Titles, Artists records
*/
class SearchForm extends Form
{
    
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('search');

        $this->add(array(
         'name' => 'searchform',
         'type' => 'Hidden',
         'attributes' => array(
             'value' => '1',
         ),
        ));
        $this->add(array(
         'name' => 'search',
         'type' => 'Text',
        ));
        

        $this->add(array(
         'name' => 'submit',
         'type' => 'Submit',
         'attributes' => array(
             'value' => 'Search',             
         ),
        ));
    }
    


}    
?>
