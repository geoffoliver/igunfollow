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
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <span class="navbar-brand">igunfollow</span>
                </div>
                <?php if($loggedIn): ?>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation" class="active"><a href="/logout">Logout</a></li>
                    </ul>
                </div>
                <? endif; ?>
            </div>
        </nav>
        <div class="container">
            <div class="header clearfix">
                <nav>
                </nav>
                <h3 class="text-muted">igunfollow</h3>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
    </body>
</html>
