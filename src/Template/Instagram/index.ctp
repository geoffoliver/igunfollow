<?php

if($loggedIn){

    echo $this->Html->tag('h2', __('Hi, {0}', [$user->data->username]));
    echo $this->Html->para('lead', __('These are the people you are following that aren\'t following you back.'));

    echo $this->Form->create('Instagram', [
        'url' => '/cleanup'
    ]);

    debug($usersIAmFollowing);
    debug($usersFollowedByMe);

    echo $this->Form->submit('Bye, Felicia!', [
        'class' => 'btn btn-danger'
    ]);

    echo $this->Form->end();

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

