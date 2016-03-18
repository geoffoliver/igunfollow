<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>The Unfollowing</title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') ?>
        <style type="text/css">
            body{
                margin-top: 70px;
            }
            .navbar-header{
                float: left;
            }
            #navbar{
                float: right;
                margin: 0;
            }
            #navbar ul{
                margin: 0;
                padding: 0;
            }
            #navbar a{
                padding-top: 14px;
                padding-bottom: 14px;
                padding-right: 0;
            }
            #navbar li img{
                margin: -32px 0 -32px;
            }
            .media + .media{
                border-top: 1px solid #DDD;
                margin: 15px 0 0;
                padding: 15px 0 0;
            }
            .media img{
                max-width: 100px;
            }
            .media.removing{
                display: none;
            }
            .none-to-unfollow{
                display: none;
            }
            .not-following-back:empty + .none-to-unfollow{
                display: block;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <span class="navbar-brand">The Unfollowing</span>
                </div>
                <?php if($loggedIn): ?>
                <div id="navbar" class="navbar">
                    <ul class="nav navbar-nav navbar-right">
                    <li role="presentation"><a href="/logout">Logout
                        <?= $this->Html->image($user->data->profile_picture, [
                            'class' => 'img-rounded',
                            'style' => 'width: 32px; display: inline-block; margin-left: 10px;'
                        ]) ?></a>
                    </li>
                    </ul>
                </div>
                <? endif; ?>
            </div>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
        <?= $this->Html->script('//code.jquery.com/jquery-2.2.1.min.js'); ?>
        <?= $this->Html->script('/js/app.js'); ?>
    </body>
</html>
