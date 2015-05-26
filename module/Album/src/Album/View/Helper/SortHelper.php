<?php
    namespace Album\View\Helper;
    use Zend\View\Helper\AbstractHelper;
     
    class SortHelper extends AbstractHelper
    {
        public function __invoke($orderby, $order, $way)
        {
             if ($orderby == $order) {
                 switch ($way) {
                    case 'asc':
                      $url = $this->view->url('sort', 
                                              array('orderby'=>$order, 
                                                        'way'=>'desc'));
                      $title = "SORT IN DESCENDING ORDER";
                      break;
                    case 'desc':
                      $url = $this->view->url('sort', 
                                                array('orderby'=>$order, 
                                                          'way'=>'asc'));
                      $title = "SORT IN ASCENDING ORDER";
                      break;
                    default:
                      $url = $this->view->url('sort', 
                                                array('orderby'=>$order, 
                                                    'way'=>'asc'));
                      $title = "SORT IN ASCENDING ORDER";
                      break;                 
                 }
             } else {
                 $url = $this->view->url('sort',
                                                array('orderby'=>$order, 
                                                      'way'=>'asc'));
                 $title = "SORT IN ASCENDING ORDER";
             }
             
             return array('url'   => $url,
                          'title' => $title
                         );
        }
    }  
?>
