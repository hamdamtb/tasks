<br/>
<br/>
<br/>
<?php
if(!empty($data)){
    if(!empty($data["form_data"])) extract($data["form_data"]);
    if(!empty($data["error_message"])) $error_message = $data["error_message"];
}
?>
<h3 class="mt-4">
<?php if(!isset($id) || empty($id)) echo "Добавить новый задача."; else echo "Редактировать задача.";?>
</h3>
<?php
if(!empty($error_message)){
    echo "<div class=\"alert alert-danger\" role=\"alert\">
        $error_message
    </div>";
}
?>
<form class="was-validated" action="/tasks/<?php if(!isset($id) || empty($id)) echo "add"; else echo "edit";?>" method="post">
    <?php if(!empty($id)) {?>
    <div class="form-group">
        <div class="col-sm-10">
            <input type="hidden" class="form-control" name = "id" <?php echo "value= \"$id\""?>>
        </div>
    </div>
    <?php }?>
    <div class="form-group">
        <label for="user_name" class="col-sm-2 col-form-label">Имя пользователь</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="user_name" name = "user_name" <?php if(!empty($user_name)) echo "value= \"$user_name\""?> required>
        </div>
    </div>
    <div class="form-group">
        <label for="user_email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="user_email" name = "email" <?php if(!empty($email)) echo "value= \"$email\""?> required>
        </div>
    </div>
    <div class="form-group">
        <label for="task_description" class="col-sm-2 col-form-label">Описания задача</label>
        <div class="col-sm-10">
            <textarea class="form-control is-invalid" id="task_description"  name = "task" required><?php if(!empty($task)) echo $task?></textarea>
        </div>
        <div class="invalid-feedback">
            Этот поля объязателно для заполнения.
        </div>
    </div>
    <?php if(isset($_SESSION["is_logged"])){?>
    <div class="form-group">
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck1" name = "status" <?php if(!empty($status)) echo "checked"?>>
                <label class="form-check-label" for="gridCheck1">
                    Рещено
                </label>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="form-group">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </div>
</form>