<?php

if($loggedIn){

    echo $this->Html->tag('h2', __('Hi, {0}', [$user->data->username]));
    echo $this->Html->para('lead', __('These are the people you are following that aren\'t following you back.'));

    foreach($usersIAmFollowing as $user){
        echo $this->Html->div('media', implode('', [
            $this->Html->div('media-left', $this->Html->image($user->profile_picture)),
            $this->Html->div('media-body', implode('', [
                $this->Html->div('media-heading', $user->username),
                $this->Html->div('', $this->Form->postLink(__('Unfollow'), [
                    'controller' => 'Instagram',
                    'action' => 'remove',
                    $user->id
                ]))
            ])),
        ]));
    }

}else{
    echo $this->Html->tag('h2', __('Unfollow people who don\'t follow you back.'));
    echo $this->Html->para('lead', __('This will show you a list of people who you follow but do not follow you back. You can then unfollow those people selectively or all at once. Enjoy.'));
    echo '<hr>';
    echo $this->Html->div('text-center', $this->Html->link('Let\'s Do It!', [
        'controller'=>'Instagram', 'action'=>'login'
    ], [
        'class' => 'btn btn-lg btn-success'
    ]));
}

