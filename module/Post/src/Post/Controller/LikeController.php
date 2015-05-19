<?php
namespace Post\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent; 
use Zend\Json\Json;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

 
use Post\Model\Like;


class LikeController extends AbstractActionController
{
    protected $likesTable;
    
    private $userSession;
                              
    public function onDispatch(MvcEvent $e )
    {
        $this->userSession = new Container('user');
        
        return parent::onDispatch( $e ); 
    }
    

    public function likeAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $like = new Like();
            
            $likeClick            = (int) $request->getPost('like');  
            $post                 = $request->getPost('postId');
            $postType             = $request->getPost('postType');
            $data['like_post_id'] = $request->getPost('postId');
            $data['like_user_id'] = $request->getPost('sessionUserId');
            
            try {
                if($likeClick == true) { //User has clicked Like
                    $like->exchangeArray($data);
                    $this->getLikesTable()->saveLike($like);
                } else { //User has clicked Unlike
                    $this->getLikesTable()->deleteLike($data);
                }                

                $postLikes = $this->getLikesTable()->fetchPostLikes($post);
                
                /*The same method is called by view helper when loading page from
                  server*/
                if($postLikes !== false) {
                    $viewModel = new ViewModel(array(
                        'likes'       => $postLikes,
                        'userSession' => $this->userSession,
                        'postType'    => $postType
                    ));
                    $viewModel->setTemplate("partial/likes");
                    $viewRender = $this->getServiceLocator()->get('ViewRenderer');
                    $likedByView = $viewRender->render($viewModel);
                } else {
                    $likedByView = "";
                }
                
                $result = array('error' => 0, 'view' => $likedByView);
            } catch(\Exception $ex) {
                $result = array('error' => 1, 'message' => $ex->getMessage());    
            }

            $response = $this->getResponse();
                    $response->getHeaders()
                             ->addHeaderLine( 
                                'Content-Type', 'application/json' 
                             );

            $response->setContent(json_encode($result));
            return $response;
        }
    }
    
    public function getLikesTable()
    {
        if (!$this->likesTable) {
            $sm = $this->getServiceLocator();
            $this->likesTable = $sm->get('Post\Model\LikesTable');
        }
        return $this->likesTable;
    }
}  
?>
