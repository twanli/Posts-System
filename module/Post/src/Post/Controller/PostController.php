<?php
namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent; 
use Zend\Json\Json;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

 
use Post\Model\Post;
use Post\Model\PostFiles;
use Post\Form\PostForm;

class PostController extends AbstractActionController
{                            
    const FIRST_ITEMS_PER_GROUP = 2;
    const ITEMS_PER_GROUP = 3;
    
    protected $postTable;
    protected $postFilesTable;
    
    private $userSession;
    
    private $postType = array("normal" => "n",
                              "reply" => "r");
                              
    public function onDispatch(MvcEvent $e )
    {
        $this->userSession = new Container('user');
        
        return parent::onDispatch( $e ); 
    }
    
    public function indexAction()
    {
        //Display a form for adding new post
        $form = new PostForm();
        $post = new Post();                     
        $form->get('submit')->setValue('Add Post');

        
        //Find users who likes this post
        /*$completePosts = array();
        foreach ($allPosts as $msg) {
            $likes = $this->getPostLikeTable()->fetchAllLikes($msg['post_id']);
            
            $msg['post_like'] = array();
            $msg['post_liked_you'] = false;
            foreach ($likes as $like) {
               $msg['post_like'][] = $like;
               
               if ($like == $this->userSession->username) {
                   $msg['post_liked_you'] = true;
               }
            }
            
            if (is_array($msg['post_children'])) {
                $children = $msg['post_children'];
                $completeChildren = array();
                
                foreach($children as $child) {
                    $likes = $this->getPostLikeTable()
                                  ->fetchAllLikes($child['post_id']);
                    
                    foreach ($likes as $like) {
                        $child['post_like'][] = $like;
               
                        if ($like == $this->userSession->username) {
                            $child['post_liked_you'] = true;
                        }
                    }
                    
                    $completeChildren[] = $child;
                }
                
                $msg['post_children'] = $completeChildren; 
                
                 
            }
            
            $completePosts[] = $msg;
        }*/
        
              
        return new ViewModel(array(
             'form' => $form,
             'userSession' => $this->userSession, 
        ));    
    }

    
    public function addAction()
    {
        //DebugBreak();
        $request = $this->getRequest();
        
        if ($request->isPost()) {

            //$response = $this->getResponse();
            //$message = $request->getPost('files');
            /*$response->getHeaders()
                     ->addHeaderLine( 'X-FILENAME', 'application/json' );*/
            $post = new Post();
            $message = $request->getPost('message');

            $parentId = $request->getPost('postParentId');
            $replyId = $request->getPost('postReplyId');
            
            $parentId = explode('-',$parentId);
            $parentId = end($parentId);
            $replyId = explode('-',$replyId);
            $replyId = end($replyId);
                        
            if(empty($message)) {
                $result = array('error' => 1, 
                                'message' => "Post is empty! Enter a post ..",
                                'postParentId' => $parentId,
                                'postReplyId' => $replyId,
                                );
            } else {
                try {
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);  
                    $validatorSize = new \Zend\Validator\File\Size(600000);
                    $files = array();
                    
                    foreach($_FILES as $file)
                    {
                        /*if(!$validatorSize->isValid($file['tmp_name'])) {
                            throw new \Exception(
                                "Exceeded Allowed File Size 600KB"
                            );
                        }*/
                        $fileMimeType = finfo_file($finfo, $file['tmp_name']);
                        
                        if (   $fileMimeType != "image/jpeg"
                            && $fileMimeType != "image/png"
                            && $fileMimeType != "image/gif"
                            && $fileMimeType != "text/plain"
                            && $fileMimeType != "application/pdf"
                        ) {
                            throw new \Exception("Unallowed File Extension in ".
                            basename($file['name'])."!");
                        }
                        
                        $uniqueToken = md5(uniqid(mt_rand(), true));
                        $fileExt = pathinfo(basename($file['name']),PATHINFO_EXTENSION);
                        $newFileName = $uniqueToken .'.'.$fileExt;
                        $oldFileName = basename($file['name']);
                        $tmpFileName = $file['tmp_name'];
                        
                        $files[] = array('new' => $newFileName,
                                         'old' => $oldFileName,
                                         'tmp' => $tmpFileName);                         
                    }
                    finfo_close($finfo);
                    
                    $data['post_parent_id'] = 
                        (!empty($parentId)) ? $parentId : null;
                    $data['post_replyto_id'] = 
                        (!empty($replyId)) ? $replyId : null;
                    $data['post_user_id'] = $this->userSession->id;
                    $data['post_message'] = $message;
                    $data['post_type'] = 
                        (!empty($parentId)) ? $this->postType['reply']:
                        $this->postType['normal'];
                    $data['post_time'] = time();
                    
                    $post->exchangeArray($data);
                    $data['post_id'] = $this->getPostTable()->savePost($post);
                    $data['post_username'] = $this->userSession->username;
                    $data['post_username_img'] = $this->userSession->img;
                    
                    if((!empty($replyId))) {
                        $replyToUser = 
                            $this->getPostTable()->findPostUser($replyId);
                        $data['post_reply_to'] = $replyToUser['post_username'];                        
                    }

                    //Upload attached files if exist
                    
                    $uploaddir = ROOT_PATH . '/public/posts/';
                    foreach($files as $file)
                    {
                        if(move_uploaded_file($file['tmp'], $uploaddir.$file['new']))
                        {
                            $postFile = new PostFiles();
            
                            $fileData['file_post_id'] = $data['post_id'];
                            $fileData['file_new_name'] = $file['new'];
                            $fileData['file_old_name'] = $file['old'];
                            $postFile->exchangeArray($fileData);
                            $this->getPostFilesTable()->savePostFile($postFile);
                        }
                    }
                    

                    
                    /*$viewModel = new ViewModel(array(
                        'data'     => $data,
                        'postType' => $this->postType,
                        'files' => $files
                    ));
                    
                    $viewModel->setTemplate("partial/loadPost");
                    $viewRender = $this->getServiceLocator()->get('ViewRenderer');
                    $view = $viewRender->render($viewModel);*/
                    
                    $postArray = array(
                                    'id'       => $data['post_id'],
                                    'userImg'  => $data['post_username_img'],
                                    'userName' => $data['post_username'],
                                    'userId'   => $data['post_user_id'],                                    
                                    'type'     => $data['post_type'],
                                    'message'  => $data['post_message']
                    );
                    
                    if(isset($data['post_reply_to'])) {
                        $postArray['reply']   = true;
                        $postArray['replyTo'] = $data['post_reply_to'];        
                    } else {
                        $postArray['reply']   = false;
                    }
                    
                    if ($data['post_type'] == $this->postType['normal']) {
                        $postArray['normalPost'] = true;
                    } else {
                        $postArray['normalPost'] = false;
                    }
                    if(count($files > 0)) {
                        foreach ($files as $file) {
                            $fileExt = strtolower(pathinfo(basename($file['new']),
                                        PATHINFO_EXTENSION));
                            $fileJSON = array(
                                'new' => $file['new'],
                                'old' => $file['old'],
                                'type' => $fileExt
                            );
                            $postArray['files'][] = $fileJSON;

                            
                        }    
                        
                    }
                    
                    $result = array('error' => 0, 
                                    'post' => $postArray, 
                                    'postParentId' => $parentId,
                                    'postReplyId' => $replyId,
                                    );
                } catch(\Exception $ex) {

                    $test = $replyId;
                    
                    $result = array('error' => 1, 
                                    'message' => $ex->getMessage(),
                                    'postParentId' => $parentId,
                                    'postReplyId' => $replyId,
                                    );    
                }
            }
        }

        $response = $this->getResponse();
        /*$response->getHeaders()
                 ->addHeaderLine( 'Content-Type', 'application/json' );*/
        $response->setContent(json_encode($result));
        return $response;    
    }
    
    public function autoloadAction() {

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            //sanitize post value
            $group_number = filter_var($_POST["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
            
            //throw HTTP error if group number is not valid
            if(!is_numeric($group_number)){
                header('HTTP/1.1 500 Invalid number!');
                exit();
            }
            
            //get current starting point of records
            
            
            //DebugBreak();
            if ($group_number == 0) {
                $position = ($group_number * self::FIRST_ITEMS_PER_GROUP);
                $mainPosts = $this->getPostTable()->fetchMainJoinUsers(
                    $position, self::FIRST_ITEMS_PER_GROUP);
            } else {
                $position = ($group_number * self::ITEMS_PER_GROUP);
                $mainPosts = $this->getPostTable()->fetchMainJoinUsers(
                    $position, self::ITEMS_PER_GROUP);                
            }

            $allPosts  = $this->getPostTable()->fetchAllJoinUsers($mainPosts);

                    
            $viewModel = new ViewModel(array(
                'messages' => $allPosts,
                'userSession' => $this->userSession,                
            ));
            $viewModel->setTemplate("post/post/autoload");
            $viewRender = $this->getServiceLocator()->get('ViewRenderer');
            $view = $viewRender->render($viewModel);
            
            $response = $this->getResponse();
            /*$response->getHeaders()
                     ->addHeaderLine( 'Content-Type', 'application/json' );*/
            $response->setContent($view);
            return $response;
        }        
    }
    public function editAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $post = new Post();
            $message = $request->getPost('msg');

            $postId = $request->getPost('postId');
            
            $postId = explode('-',$postId);
            $postId = end($postId);
            
            if(empty($message)) {
                $result = array('error' => 1, 
                                'message' => "Post is empty! Enter a post ..",
                                'postId' => $postId,                                
                                );
            } else {
                $this->getPostTable()->updatePostMsg($postId, $message);
                $result = array('error' => 0,
                                'message' => $message
                    /*essage' => "Post is empty! Enter a post ..",
                    'postId' => $postId,*/                            
                    );
            }
            
            
            $response = $this->getResponse();
            /*$response->getHeaders()
                     ->addHeaderLine( 'Content-Type', 'application/json' );*/
            $response->setContent(json_encode($result));
            return $response;        
        }    
    }    

    public function loadAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            try {
                
                $postId = $request->getPost('postId');
                
                $post = $this->getPostTable()->getPost($postId);
                
                $view = new ViewModel(array(
                    'post' => $post,
                    'userSession' => $this->userSession
                ));
                $view->setTerminal(true);
                return $view;                
            
            } catch(\Exception $ex) {
                
                $response = $this->getResponse();
                $response->getHeaders()
                         ->setContent($ex->getMessage());
                return $response;         
                            
            }

        }    
    }

    public function deleteAction()
    {
    }
    public function getGroupsCountAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $totalRecords = $this->getPostTable()->postsCount();
            $totalGroups = ceil(($totalRecords - self::FIRST_ITEMS_PER_GROUP)
                                /self::ITEMS_PER_GROUP);

            $response = $this->getResponse();
            $response->setContent(
                json_encode(array('totalGroups' => $totalGroups)));
            return $response;          
        }        
    }
    
    public function getPostTable()
    {
        if (!$this->postTable) {
            $sm = $this->getServiceLocator();
            $this->postTable = $sm->get('Post\Model\PostTable');
        }
        return $this->postTable;
    }
    
    public function getUserTable()
    {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('Application\Model\UserTable');
        }
        return $this->userTable;
    }
    
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
