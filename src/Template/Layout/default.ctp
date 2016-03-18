<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>
        <?= $this->Html->css('//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') ?>
        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <div class="container">
            <div class="header clearfix">
                <nav>
                    <ul class="nav nav-pills pull-right">
                    <li role="presentation" class="active"><a href="#">Home</a></li>
                    <li role="presentation"><a href="#">About</a></li>
                    <li role="presentation"><a href="#">Contact</a></li>
                    </ul>
                </nav>
                <h3 class="text-muted">igunfollow</h3>
            </div>
            <div class="jumbotron">
                <h1>Hey there</h1>
                <p class="lead">Do your shit</p>
                <?php
                if(!$loggedIn){
                    echo $this->Html->link('Let\'s Do It!', [
                        'controller'=>'Instagram', 'action'=>'login'
                    ], [
                        'class' => 'btn btn-lg btn-success'
                    ]);
                }
                ?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
            <footer class="footer">
                <p>&copy; 2015 Company, Inc.</p>
            </footer>
        </div>
    </body>
</html>
