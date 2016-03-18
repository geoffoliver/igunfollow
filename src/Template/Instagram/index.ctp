<?php

if($loggedIn){
    echo $this->Html->tag('h2', __('Hi, {0}', [$user->data->full_name ? $user->data->full_name : $user->data->username]));
    echo $this->Html->para('lead', __('These are the people that aren\'t following you back.'));
    echo '<hr>';

    echo '<div class="not-following-back">';
    if($notFollowingBack){
        foreach($notFollowingBack as $user){
            echo $this->Html->div('media', implode('', [
                $this->Html->div('media-left', $this->Html->image($user->profile_picture, [
                    'class' => 'img-rounded'
                ])),
                $this->Html->div('media-body', implode('', [
                    $this->Html->tag('h4', $user->full_name ? $user->full_name : $user->username, [
                        'class' => 'media-heading'
                    ]),
                    $this->Html->div('', $this->Html->link(__('Unfollow'), [
                        'controller' => 'Instagram',
                        'action' => 'unfollow',
                        $user->id
                    ], [
                        'class' => 'btn btn-danger unfollow'
                    ]))
                ])),
            ]));
        }
    }
    echo '</div>';
    echo $this->Html->div('none-to-unfollow', $this->Html->div('alert alert-success', implode('', [
        $this->Html->tag('h4', __('Congratulations!')),
        $this->Html->para('', __('Balance has been achieved. Everything is right with the world.'))
    ])));
}else{
    echo $this->Html->tag('h2', __('Do you follow a lot of people?'));
    echo $this->Html->para('lead', __('Let us show who isn\'t following you back so you can easily unfollow them.'));
    echo '<hr>';
    echo $this->Html->div('text-center', $this->Html->link('OK, let\'s do it!', [
        'controller'=>'Instagram', 'action'=>'login'
    ], [
        'class' => 'btn btn-lg btn-success'
    ]));
}

