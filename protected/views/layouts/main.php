<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Non-responsive Template for Bootstrap</title>
</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">
                <li><a><?= User::getLoggedUser()->name; ?></a></li>
                <li><a class="logout" href="/logout">Выйти</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>

<div class="container">

    <?= $content; ?>

</div> <!-- /container -->

</body>
</html>
