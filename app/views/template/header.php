<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Test BeeJee</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="/public/stylesheets/app.css">
        <script src="https://kit.fontawesome.com/e258fa67ed.js" crossorigin="anonymous"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand navbar-nav mr-auto mt-2 mt-lg-0" href="/">Test task for BeeJee</a>

            <form class="form-inline my-2 my-lg-0">
                <?php
                if(isset($_SESSION["is_logged"])){
                    echo "<a href=\"/users/logout\" class=\"btn btn-outline-success my-2 my-sm-0\" tabindex=\"-1\" role=\"button\">Выйты</a>";
                } else {
                    echo "<a href=\"/users/login\" class=\"btn btn-outline-success my-2 my-sm-0\" tabindex=\"-1\" role=\"button\">Логин</a>";
                }
                ?>

            </form>
        </div>
    </nav>

