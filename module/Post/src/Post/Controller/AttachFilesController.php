<?php
namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use Post\Model\PostFiles;
 
class AttachFilesController extends AbstractActionController
{
    protected $postFilesTable;
    private $userSession;
                              
    public function onDispatch(MvcEvent $e )
    {
        $this->userSession = new Container('user');
        
        return parent::onDispatch( $e ); 
    }
    
    public function uploadAction()
    {
        //DebugBreak();
        $fn = (isset($_SERVER['HTTP_X_FILENAME']) ? 
                $_SERVER['HTTP_X_FILENAME'] : false);
        
        //$request = $this->getRequest();
        //$soubory = $request->getPost('f');
        
        if ($fn) {
            $uniqueToken = md5(uniqid(mt_rand(), true));
            $fileType = pathinfo(basename($fn),PATHINFO_EXTENSION);
            $newFileName = $uniqueToken .'.'.$fileType;
            $oldFileName = $fn;
            
            
            $postId = $this->params()->fromQuery('id');
                            
            // AJAX call
            file_put_contents(
                ROOT_PATH . '/public/posts/' . $newFileName,
                file_get_contents('php://input')
            );
            
            $postFile = new PostFiles();
            
            $data['file_post_id'] = $postId;
            $data['file_new_name'] = $newFileName;
            $data['file_old_name'] = $oldFileName;
            $postFile->exchangeArray($data);
            $this->getPostFilesTable()->savePostFile($postFile);
            
            //echo "$fn uploaded";
            exit();

        } else {

            // form submit
            $files = $_FILES['fileselect[]'];

            foreach ($files['error'] as $id => $err) {
                if ($err == UPLOAD_ERR_OK) {
                    $fn = $files['name'][$id];
                    move_uploaded_file(
                        $files['tmp_name'][$id],
                        'uploads/' . $fn
                    );
                    echo "<p>File $fn uploaded.</p>";
                }
            }

            
        }

    }
    
    // module/Album/src/Album/Controller/AlbumController.php:
    public function getPostFilesTable()
    {
        if (!$this->postFilesTable) {
            $sm = $this->getServiceLocator();
            $this->postFilesTable = $sm->get('Post\Model\PostFilesTable');
        }
        return $this->postFilesTable;
    }
    
    


    



}  
?>
