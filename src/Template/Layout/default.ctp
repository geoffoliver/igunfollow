<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>The Unfollowing</title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <style type="text/css">
            body{
                margin-top: 70px;
            }
        </style>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <span class="navbar-brand">The Unfollowing</span>
                </div>
                <?php if($loggedIn): ?>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                    <li role="presentation"><a href="/logout">Logout
                        <?= $this->Html->image($user->data->profile_picture, [
                            'class' => 'img-circle',
                            'style' => 'width: 16px; display: inline-block; margin-left: 10px;'
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
    </body>
</html>
