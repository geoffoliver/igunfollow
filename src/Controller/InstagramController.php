<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use MetzWeb\Instagram\Instagram;

/**
 * Instagram Controller
 *
 * @property \App\Model\Table\InstagramTable $Instagram
 */
class InstagramController extends AppController
{
    private $instagram;
    private $loggedIn = false;

    public function beforeFilter(Event $event){
        $this->instagram = new Instagram([
            'apiKey'      => 'ac288b4f814a4cc2a738fbde35926970',
            'apiSecret'   => 'b4ae52f374b341beb098a51f63e3d0b0',
            'apiCallback' => 'http://igunfollow.dev.plan8home.com'
        ]);

        if($igData = $this->request->session()->read('igdata')){
            $this->loggedIn = true;
            $this->instagram->setAccessToken($igData);
        }

        $this->set('loggedIn', $this->loggedIn);
    }

    public function index(){
        $usersFollowedByMe = [];
        $usersIAmFollowing = [];
        $user = [];

        if($code = Hash::get($this->request->query, 'code')){
            $igData = $this->instagram->getOAuthToken($code);
            $this->request->session()->write('igdata', $igData);
            return $this->redirect([
                'controller' => 'Instagram',
                'action' => 'index'
            ]);
        }

        if($this->loggedIn){
            try{
                $user = $this->instagram->getUser();
                if(isset($user->meta->code) && $user->meta->code == 400){
                    return $this->redirect('/logout');
                }

                $follower = $this->instagram->getUserFollower();
                do{
                    foreach($follower->data as $f){
                        $usersIAmFollowing[]= $f;
                    }
                }while($follower = $this->instagram->pagination($follower));

                $follows = $this->instagram->getUserFollows();
                do{
                    foreach($follows->data as $f){
                        $usersFollowedByMe[]= $f;
                    }
                }while($follows = $this->instagram->pagination($follows));
                $this->set('media', $this->instagram->getUserMedia());
            }catch(Exception $ex){
                return $this->redirect('/logout');
            }
        }
        $this->set(compact('user', 'usersFollowedByMe', 'usersIAmFollowing'));
    }

    public function login(){
        return $this->redirect($this->instagram->getLoginUrl([
            'basic',
            'follower_list',
            'relationships'
        ]));
    }

    public function logout(){
        $this->request->session()->delete('igdata');
        return $this->redirect('/');
    }

    public function cleanup(){
        if(!$this->request->is('post')){
            return $this->redirect('/');
        }

        debug($this->request->data);
    }
}
