<?php
    namespace Album\Model;

    use Zend\Filter\Compress\Zip;
    use Album\Model\AlbumTable;
    use Album\Model\Album;
    use Zend\Config\Config;
    use Zend\Validator\File\MimeType;
    use Zend\Validator\File\Exists;
    use Zend\Validator\File\Size;
    use Zend\ServiceManager\ServiceLocatorAwareInterface;
    use Zend\ServiceManager\ServiceLocatorInterface; 
    use Zend\Db\TableGateway\AbstractTableGateway;
    use ZipArchive;
    
    use Imagine\Image\Box as ImageBox;
    use Imagine\Image\Point as ImagePoint;
    use Imagine\Image\ImageInterface;
    use Imagine\Gd\Imagine as GdImagine; 

    class AlbumFiles extends Zip implements ServiceLocatorAwareInterface
    {
        const ZIP_DIRECTORY = '/public/zip/';
        const CSV_XML_DIRECTORY = '/public/files/';
        const ALBUMS_DIRECTORY = '/public/img/albums/';
        const CSV_XML_ITEMS_NBR = 3;
        const RESIZEWIDTH = 200;
        
        private $serviceLocator;

        /**
         * Class constructor
         *
         * Inicialize the directory where to unzip files
         */
        public function __construct()
        {
            $this->options['target'] = ROOT_PATH.'/public/zip/';
        }        
        
        /**
         * Sets the archive to use for de-/compression
         *
         * @param  string $archive Archive to use
         * @return self
         */
        public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
            $this->serviceLocator = $serviceLocator;
        }

        public function getServiceLocator() {
            return $this->serviceLocator;
        }
        
        public function setZipArchive($archive=null)
        {
            //DebugBreak();
            $archive = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, (string) ROOT_PATH.self::ZIP_DIRECTORY.$archive);
            $this->options['archive'] = $archive;

            return $this;
        }
        
        /**
         * Compresses the given content
         *
         * @param  array $files
         * @return string Compressed archive
         */
        public function compress($files = array())
        {
        
            $valid_files = array();
            //if files were passed in...
            if(is_array($files)) {
                //cycle through each file
                foreach($files as $file) {
                    //make sure the file exists
                    if(file_exists($file)) {
                        $valid_files[] = $file;
                    }
                }
            }
            
            //if we have good files...
            if(count($valid_files)) {
                //create the archive
           
                $zip = new ZipArchive();
                $res = $zip->open($this->getArchive(), ZipArchive::CREATE | ZipArchive::OVERWRITE);

                if ($res !== true) {
                    return false;
                }

                
                //add the files
                foreach($valid_files as $file) {
                    /*DebugBreak();
                    $test = basename($file);*/
                    //DebugBreak();
                    $test = basename($file);
                    $zip->addFile($file, basename($file));
                }

        
                //close the zip -- done!
                $zip->close();

                //check to make sure the file exists
                return file_exists($this->options['archive']);
            }    
            else
            {
                return false;
            }
        }
        
        /**
        * Unzip given archive
        * 
        * @param mixed $rachive
        */
        public function unzip($archive = null) 
        {
           $this->decompress(ROOT_PATH.self::ZIP_DIRECTORY.$archive);
        }
        
        /**
        * Collect CSV/XML file and their related images in a file array to zip
        * 
        * @param mixed $sort
        * 
        * @return array
        */
        public function filesToZip($sort=null,$orderby=null, $way=null) 
        {
            //DebugBreak();
            $albumTable = $this->serviceLocator->get('Album\Model\AlbumTable');
            $albums = $albumTable->fetchAll(false, $orderby, $way);
            //$albumTable = new AlbumTable();
            //$album->
            switch ($sort) {
                case 'CSV':
                    $csvFileName = ROOT_PATH.self::CSV_XML_DIRECTORY."albums.csv";
                    $csvFile = fopen($csvFileName,"w");

                    $content = "";

                    //$albums = $this->getAlbumTable()->fetchAll();
                    
                    foreach ($albums as $album) {
                        $data = array($album->id, $album->artist, $album->title, $album->img);
                        //$content .= implode(",", $data).PHP_EOL;
                        if(!empty($album->img)) {
                            $zipFiles[] = ROOT_PATH . self::ALBUMS_DIRECTORY. $album->img;    
                        }
                        
                        fputcsv($csvFile, $data);
                    }

                    fclose($csvFile);
                    $zipFiles[] = $csvFileName;                
                break;
                
                case 'XML':
                    $xmlFileName = ROOT_PATH.self::CSV_XML_DIRECTORY."albums.xml";
                    foreach ($albums as $album) {
                        $albumArray["album"][] = array("id" => $album->id, "title" => $album->title, "artist" => $album->artist, "img" => $album->img);
                        
                        if(!empty($album->img)) {
                            $zipFiles[] = ROOT_PATH . self::ALBUMS_DIRECTORY. $album->img;    
                        }
                    }
                    $xmlWriter = new \Zend\Config\Writer\Xml();
                    $xml = $xmlWriter->toString($albumArray);
                    file_put_contents($xmlFileName,$xml);
                    
                    $zipFiles[] = $xmlFileName;
                break;

            }
            
            return $zipFiles;
  

        }
        
        /**
        * Upload a zip file from form
        * 
        * @param mixed $zip
        */
        public function uploadZip($zip=null) 
        {
            
            //Delete old files in zip directory
            $this->deleteOldFiles();
            $this->setZipArchive($zip);
            
            //First delete old files in directory
            $upload = new \Zend\File\Transfer\Adapter\Http();
            
            $uploadPath = ROOT_PATH . self::ZIP_DIRECTORY;
        
            $filterRename = new \Zend\Filter\File\Rename(array('target' => $uploadPath . $zip, 'overwrite' => false));
            $upload->addFilter($filterRename);

            if ($upload->receive()) {
                return $zip;

            } else {
                return false;
            }
        }
        
        /**
        * Read CSV file with upload and save in databse
        * 
        */
        public function readCSVFile($file) 
        {
            //print 'reading CSV file';
            //DebugBreak();
            $data = array();
            $album = new Album();
            
            $csvFile = fopen(ROOT_PATH.self::ZIP_DIRECTORY.$file,"r");
            while(!feof($csvFile))
            {
                $output =fgetcsv($csvFile);
                
                //There should be always 3 fields in CSV record, and no filed is empty 
                if ((count($output) != self::CSV_XML_ITEMS_NBR) || (array_search("",$output)!==false)) {
                    continue;
                }
                //Img CSV field should have an extension and it should be a valid image extension
                $ext = pathinfo($output[2], PATHINFO_EXTENSION);
                
                

                if(empty($ext) || ($ext!='jpg' && $ext!='png' && $ext!='gif' && $ext!='jpeg')) {
                    continue;
                }
                
                $path = ROOT_PATH.self::ZIP_DIRECTORY;
                $existValidator = new Exists($path);
                if ($existValidator->isValid($path.$output[2])) {
                    $mimeValidator = new MimeType(array('image/gif', 'image/jpg', 'magicFile' => null));
                   //$mimeValidator = new \Zend\Validator\File\IsImage();
                    $test = $path.$output[2];
                    $imageType = exif_imagetype($path.$output[2]); 
                    if($imageType == IMAGETYPE_GIF 
                    || $imageType == IMAGETYPE_JPEG 
                    || $imageType == IMAGETYPE_PNG
                    ) {
                        $sizeValidator = new Size(5000000);
                        if($sizeValidator->isValid($path.$output[2])) {
                            $data['artist'] = $output[0];
                            $data['title'] = $output[1];
                            
                            $uniqueToken = md5(uniqid(mt_rand(), true));
                            $imageFileType = pathinfo(basename($output[2]),PATHINFO_EXTENSION);
                            $filename = $uniqueToken .'.'.$imageFileType;
                            $data['img'] = $filename;
                            
                            rename($path.$output[2], ROOT_PATH.self::ALBUMS_DIRECTORY.$filename);
                            
                            $imagine = new GdImagine();
                            $image = $imagine->open(ROOT_PATH.self::ALBUMS_DIRECTORY.$filename);
                            $size  = $image->getSize()->widen(self::RESIZEWIDTH);
                            $image->resize($size)->save(ROOT_PATH.self::ALBUMS_DIRECTORY.$filename);
                            
                            $album->exchangeArray($data);
                            $albumTable = $this->serviceLocator->get('Album\Model\AlbumTable');
                            $albumTable->saveAlbum($album);
                            

                        }    
                    }
                }       
            }
            
            fclose($csvFile);    
        }

        /**
        * Read XML file with upload and save in databse
        * 
        */
        public function readXmlFile() 
        {
            //print 'reading CSV file';
            DebugBreak();
            $data = array();
            $album = new Album();
            
            $reader = new \Zend\Config\Reader\Xml();
            $output   = $reader->fromFile(ROOT_PATH.self::ZIP_DIRECTORY."albums.xml");
            $alba = $output['album'];
            
            foreach ($alba as $data) {
                $uniqueToken = md5(uniqid(mt_rand(), true));
                $imageFileType = pathinfo(basename($data['img']),PATHINFO_EXTENSION);
                $filename = $uniqueToken .'.'.$imageFileType;
                
                $data['img'] = $filename;
                
                $album->exchangeArray($data);
                
                $albumTable = $this->serviceLocator->get('Album\Model\AlbumTable');
                $albumTable->saveAlbum($album);
            }
   
        }
        
        public function checkFile()
        {
            $csvFiles = array();
            foreach (glob(ROOT_PATH.self::ZIP_DIRECTORY."*.csv") as $file) {
              $csvFiles[] = $file;
            }
            $xmlFiles = array();
            foreach (glob(ROOT_PATH.self::ZIP_DIRECTORY."*.xml") as $file) {
              $xmlFiles[] = $file;
            }
            
            if(count($xmlFiles) > 0 && count($csvFiles) > 0) {
                return false;    
            } else if (count($xmlFiles) == 0 && count($csvFiles) == 0) {
                return false;
            } else if(count($csvFiles) > 1) {
                return false;
            } else if(count($xmlFiles) > 1) {
                return false;
            }


            $finfo = finfo_open(FILEINFO_MIME_TYPE);            
            if (!empty($xmlFiles)) {
                //Check mime type
                $type = finfo_file($finfo, $xmlFiles[0]);
                finfo_close($finfo);
                if($type == "application/xml") {
                    return $xmlFiles[0];                    
                } else {
                    return false;
                }
            }
            if (!empty($csvFiles)) {
                //Check mime type
                $type = finfo_file($finfo, $csvFiles[0]);
                finfo_close($finfo);
                if($type == "text/csv" || $type == "text/plain") {
                    return $csvFiles[0];                    
                } else {
                    return false;
                }
            }
             
        }
        
        /**
        * Delete old files from zip directory
        * 
        */
        private function deleteOldFiles()
        {
            //DebugBreak();
            $files = glob(ROOT_PATH.self::ZIP_DIRECTORY.'*'); // get all file names
            foreach($files as $file){ // iterate files
              if(is_file($file))
                unlink($file); // delete file
            }   
        }
        
        
        
        /*public function getAlbumTable()
        {
            DebugBreak();
            $wawa = new \Album\Model\AlbumTable();
        }*/
    }
?>