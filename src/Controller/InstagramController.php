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

    public function initialize(){
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(Event $event){
        $this->instagram = new Instagram([
            'apiKey'      => 'ac288b4f814a4cc2a738fbde35926970',
            'apiSecret'   => '7e6c4e85e9084ec1bbc1b5c017b27af5',
            'apiCallback' => 'http://unfollow.plan8studios.com'
        ]);

        if($igData = $this->request->session()->read('igdata')){
            $this->loggedIn = true;
            $this->instagram->setAccessToken($igData);
        }

        $this->set('loggedIn', $this->loggedIn);
    }

    public function index(){
        $usersFollowingMe = [];
        $usersIAmFollowing = [];
        $notFollowingBack = [];
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
                        $usersFollowingMe[$f->id]= $f;
                    }
                }while($follower = $this->instagram->pagination($follower));

                $follows = $this->instagram->getUserFollows();
                do{
                    foreach($follows->data as $f){
                        $usersIAmFollowing[$f->id]= $f;
                    }
                }while($follows = $this->instagram->pagination($follows));
                $this->set('media', $this->instagram->getUserMedia());
            }catch(Exception $ex){
                return $this->redirect('/logout');
            }

            $notFollowingBack = array_diff_key($usersIAmFollowing, $usersFollowingMe);
        }
        $this->set(compact('user', 'notFollowingBack'));//'usersIAmFollowing', 'usersFollowingMe'));
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

    public function unfollow($id){
        if(!$this->request->is('post') || !$this->request->is('ajax')){
            return $this->redirect('/');
        }

        $deleted = false;
        $message = false;

        $limit = 60;
        $history = $this->request->session()->read('unfollowed');
        if(!$history){
            $history = [];
        }

        $now = time();
        $earliest = $now;
        if($history){
            $earliest = $history[0];
        }

        if(count($history) >= $limit && $earliest > ($now - HOUR)){
            $message = __('You\'ve reached your hourly limit ({0}). Try again soon.', $limit);
        }else{
            $unfollow = $this->instagram->modifyRelationship('unfollow', $id);
            if($unfollow->meta->code == 200 &&
                $unfollow->data->outgoing_status == 'none'
            ){
                $history[]= $now;
                $deleted = true;
            }else{
                $message = __('Unable to unfollow. Try again later.');
            }
        }

        $this->request->session()->write('unfollowed', array_slice($history, -60));

        $this->set([
            'deleted' => $deleted,
            't' => Hash::get($this->request->data, 't'),
            'message' => $message
        ]);

        $this->set('_serialize', ['deleted', 't', 'message']);
    }
}
