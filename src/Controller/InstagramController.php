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

    public function beforeFilter(Event $event){
        $this->instagram = new Instagram([
            'apiKey'      => 'ac288b4f814a4cc2a738fbde35926970',
            'apiSecret'   => 'b4ae52f374b341beb098a51f63e3d0b0',
            'apiCallback' => 'http://localhost:8765'
        ]);
    }

    public function index(){
        $usersFollowedByMe = [];
        $usersIAmFollowing = [];

        if($code = Hash::get($this->request->query, 'code')){
            $igData = $this->instagram->getOAuthToken($code);
            $this->request->session()->write('igdata', $igData);
            return $this->redirect([
                'controller' => 'Instagram',
                'action' => 'index'
            ]);
        }

        if($igData = $this->request->session()->read('igdata')){
            $this->instagram->setAccessToken($igData);

            $usersFollowedByMe = $this->instagram->getUserFollows();
            $usersIAmFollowing = $this->instagram->getUserFollower();
        }

        $this->set(compact('usersFollowedByMe', 'usersIAmFollowing'));
    }

    public function login(){
        return $this->redirect($this->instagram->getLoginUrl([
            'basic',
            'follower_list',
            'relationships'
        ]));
    }

    public function cleanup(){
        debug($this->request->data);
    }
}
