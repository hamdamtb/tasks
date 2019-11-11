<br/>
<br/>
<br/>
<br/>
<br/>
<?php
if(!empty($data)){
    if(!empty($data["form_data"])) extract($data["form_data"]);
    if(!empty($data["error_message"])) $error_message = $data["error_message"];
}
if(!empty($error_message)){
    echo "<div class=\"alert alert-danger\" role=\"alert\">
        $error_message
    </div>";
}
?>
<form class="form-signin" action = "/users/login" method = "post">
    <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>
    <label for="login" class="sr-only">Логин</label>
    <input type="text" id="login" class="form-control" name = "login" <?php if(!empty($login)) echo "value= \"$login\""?>placeholder="Логин" required="" autofocus="">
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" id="inputPassword" class="form-control" name = "password" <?php if(!empty($password)) echo "value= \"$password\""?> placeholder="Пароль" required="">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
</form>