<?php
    namespace Album\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;
    use Zend\Filter\Compress\Zip;
    use Zend\Http\Headers;
    use Zend\Http\Response\Stream;
    use Zend\Config\Writer\Xml;
    use Zend\Session\Container;
    use Zend\Mvc\MvcEvent;
    use Album\Model\Album;
    use Album\Model\Login;
    use Album\Model\Import;      
    use Album\Model\AlbumFiles;
    use Album\Form\AlbumForm;
    use Album\Form\LoginForm;
    use Album\Form\SelectExportForm; 
    use Album\Form\SearchForm; 
    use Album\Form\ImportForm; 
    use Application\Model\UserRole;      

    class AlbumController extends AbstractActionController
    {
        const COUNTONPAGE = 50;
        
        protected $albumTable;
        protected $authservice;
        protected $storage;

        public function onDispatch(MvcEvent $e )
        {
            $userRole = new UserRole();
            $acl = $userRole->initAcl();
            $e->getViewModel()->acl = $acl;
            
            return parent::onDispatch( $e );           
        }
        
        
        public function indexAction()
        {
            $exportForm = new SelectExportForm();
            $exportForm->get('submit')->setValue('Confirm');
            $importForm = new ImportForm();
            $importForm->get('submit')->setValue('Confirm');
            $searchForm = new SearchForm();
            $searchForm->get('submit')->setValue('Search');
            
            //set a session for storing different selecting criteria
            $searchStr = "";
            $selectParamsSession = new Container('criteria');
            
            $orderby=$this->params('orderby');
            $way=$this->params('way');
            $page = (int) $this->params()->fromQuery('page', 1);
                        
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                //If User wants to export files
                if($request->getPost('exportform')) {
                    $exportFormat = $request->getPost('exportformat'); 
                    
                    switch ($exportFormat) {
                        case 'CSV':
                            return $this->downloadCSV($orderby, $way);                            
                            break;
                        case 'XML':
                            return $this->downloadXML($orderby, $way);    
                            break;
                        default:
                            return $this->downloadCSV($orderby, $way);
                            break;
                    }                    
                }

                //If User wants to import files -IN ZIP FORMAT
                if($request->getPost('importform')) {
                    $import = new Import();
                    
                    $sm = $this->getServiceLocator();
                    $albumFiles = $sm->get('Album\Model\AlbumFiles');
                    
                    $importForm->setInputFilter($import->getInputFilter());
                    $files = $request->getFiles()->toArray();
                    $importForm->setData($files);
                    
                    if ($importForm->isValid()) {
                        $uploadZip = $albumFiles->uploadZip(
                            $files['zipupload']['name']
                        );
                        
                        if($uploadZip != false) {
                            //Unzip Files
                            $albumFiles->unzip($uploadZip);
                        
                            //Check Content of zip file if it is OK
                            $file = $albumFiles->checkFile();
                            if($file != false) {
                                $ext = pathinfo(basename($file), 
                                        PATHINFO_EXTENSION);
                                switch (strtolower($ext)) {
                                   case 'xml':
                                        //store content of xml file in database
                                        $albumFiles->readXmlFile(basename($file));
                                        break;
                                   case 'csv':
                                        //store content of csv file in database
                                        $albumFiles->readCSVFile(basename($file));
                                        break;
                                } 
                            }
                            
                            $importForm->get('zipupload')->setMessages(
                                array('File has been successfuly uploaded!')
                            );             
                        }
                    }
                } 
                
                if($request->getPost('searchform')) {
                    $searchStr = $request->getPost('search');
                    $selectParamsSession->searchStr = $searchStr;
                    
                }
                
                
            }

            $searchForm->get('search')->setValue($selectParamsSession->searchStr); 
            
            $paginator = $this->getAlbumTable()->fetchAll(true,$orderby,$way);
            // set the current page to what has been passed in query string, or to 1 if none set
            $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
            // set the number of items per page to 10
            $paginator->setItemCountPerPage(self::COUNTONPAGE);

            return new ViewModel(array(
                'paginator' => $paginator,
                'exportForm' => $exportForm,
                'importForm' => $importForm,
                'searchForm' => $searchForm,
                'orderby' => $orderby,
                'way' => $way,
                'page' => $page
            ));
        }

        public function addAction()
        {
            $form = new AlbumForm();
            $form->get('submit')->setValue('Add');

            $request = $this->getRequest();
            if ($request->isPost()) {
                $album = new Album();
                $form->setInputFilter($album->getInputFilter());
                
                $files = $request->getFiles()->toArray();
                $req = $request->getPost()->toArray(); 
                $post = array_merge_recursive(
                    $files,
                    $req
                );
                $form->setData($post);

                if ($form->isValid()) {
                    //Uploading image
                    $uploadFile = $form->uploadImage(
                        $files['fileupload']['name']
                    );
                    if($uploadFile != false) {
                        $req['album_img'] = $uploadFile;

                        $album->exchangeArray($req);
                        $this->getAlbumTable()->saveAlbum($album);
                            
                        return $this->redirect()->toRoute('album');               
                    } else {
                        $form->get('fileupload')->setMessages(
                                array('Image doesn\'t exist, you should upload one!')
                            ); 
                    }
                }
            }
            return array('form' => $form);
        }

        public function editAction()
        {
            $id = (int) $this->params()->fromRoute('id', 0);
            if (!$id) {
                 return $this->redirect()->toRoute('album', array(
                     'action' => 'add'
                 ));
            }

            // Get the Album with the specified id.  An exception is thrown
            // if it cannot be found, in which case go to the index page.
            try {
                 $album = $this->getAlbumTable()->getAlbum($id);
                }
                catch (\Exception $ex) {
                 return $this->redirect()->toRoute('album', array(
                     'action' => 'index'
                 ));
            }

            $form  = new AlbumForm();
            $form->setValues($album);
            $form->get('submit')->setAttribute('value', 'Edit');

            $request = $this->getRequest();
            if ($request->isPost()) {
                 $form->setInputFilter($album->getInputFilter());
                 
                 $files = $request->getFiles()->toArray();
                 $req = $request->getPost()->toArray();
                 $txtFields = array('album_id' => $req['album_id'], 'album_title' => $req['album_title'], 
                                    'album_artist' => $req['album_artist']);
                 
                 if(empty($files['fileupload']['name'])) {
                    $form->setData($req);

                    if ($form->isValid()) {
                        if(file_exists(ROOT_PATH . '/public/img/albums/'. $album->album_img) 
                            &&(!empty($album->album_img))) {
                            $album->exchangeArray($form->getData());
                            $this->getAlbumTable()->saveAlbum($album);
                        
                            return $this->redirect()->toRoute('album');
                        } else { 
                            $form->get('album_img')->setMessages(
                                array('Image doesn\'t exist, you should upload one!')
                            );
                        }
                    }
                 } else {
                     //If we have image file to upload
                     $post = array_merge_recursive(
                        $txtFields,
                        $files
                    );

                    $form->setData($post);

                    if ($form->isValid()) {
                        $uploadFile = $form->uploadImage(
                            $files['fileupload']['name']
                        );
                        if($uploadFile != false) {
                            $txtFields['album_img'] = $uploadFile;

                            $album->exchangeArray($txtFields);
                            $this->getAlbumTable()->saveAlbum($album);
                                
                            return $this->redirect()->toRoute('album');               
                        }
                    }
                 }
            }
            return array(
             'id' => $id,
             'form' => $form,
            );     
        }
        
        /**
        * Function for export CSV
        * 
        * @param mixed $orderby  //way of ordering data in CSV file
        * @param mixed $way      //ASC or DESC records 
        * @return \Zend\Http\Response\Stream
        */
        private function downloadCSV($orderby, $way) 
        {
            $sm = $this->getServiceLocator();
            $albumFiles = $sm->get('Album\Model\AlbumFiles');
           
            $zipFiles = $albumFiles->filesToZip('CSV', $orderby, $way);
            
            $albumFiles->setZipArchive('albums-csv.zip');
            $zip = $albumFiles->getArchive();
            $albumFiles->compress($zipFiles);
            /*$albumFiles->setArchive('albumarchive.zip');
            $zipname = $albumFiles->getArchive();
            $res = $albumFiles->compress($zipFiles);
            $test = basename($zipname);*/
            
            $response = new Stream();
            $response->setStream(fopen($zip, 'r'));
            $response->setStatusCode(200);
            $response->setStreamName(basename($zip));
            $headers = new Headers();
            $headers->addHeaders(array(
                  'Content-Disposition' => 'attachment; filename="' . 
                  basename($zip) .'"',
                  'Content-Type' => 'application/zip',
                  'Content-Length' => filesize($zip)
            ));
            $response->setHeaders($headers);
            return $response;
        }

        /**
        * Function for export XML
        * 
        * @param mixed $orderby  //way of ordering data in CSV file
        * @param mixed $way      //ASC or DESC records 
        * @return \Zend\Http\Response\Stream
        */        
        private function downloadXML($orderby, $way) {
            $sm = $this->getServiceLocator();
            $albumFiles = $sm->get('Album\Model\AlbumFiles');
            $zipFiles = $albumFiles->filesToZip('XML', $orderby, $way);
            
            $albumFiles->setZipArchive('albums-xml.zip');
            $zip = $albumFiles->getArchive();
            $albumFiles->compress($zipFiles);
            /*$albumFiles->setArchive('albumarchive.zip');
            $zipname = $albumFiles->getArchive();
            $res = $albumFiles->compress($zipFiles);
            $test = basename($zipname);*/
            
            $response = new Stream();
            $response->setStream(fopen($zip, 'r'));
            $response->setStatusCode(200);
            $response->setStreamName(basename($zip));
            $headers = new Headers();
            $headers->addHeaders(array(
                  'Content-Disposition' => 'attachment; filename="' . 
                  basename($zip) .'"',
                  'Content-Type' => 'application/zip',
                  'Content-Length' => filesize($zip)
            ));
            $response->setHeaders($headers);
            return $response;
        }
                
        public function deleteAction()
        {
            $id = $this->params('id');
            $this->getAlbumTable()->deleteAlbum($id);
            return $this->redirect()->toRoute('album');
        }
        
        public function getAlbumTable()
        {
            if (!$this->albumTable) {
                $sm = $this->getServiceLocator();
                $this->albumTable = $sm->get('Album\Model\AlbumTable');
            }
            return $this->albumTable;
        }

        private function getAuthService()
        {
            if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
            }
            return $this->authservice;
        }        
    }  
?>
