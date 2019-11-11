<br/>
<br/>
<?php if(isset($_SESSION["error_message"])){ ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?php echo $_SESSION["error_message"]; ?></strong>
    </div>

<?php
    unset($_SESSION["error_message"]);
} ?>

<?php if(isset($_SESSION["success_message"])){ ?>
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong><?php echo $_SESSION["success_message"]; ?></strong>
    </div>
<?php
    unset($_SESSION["success_message"]);
} ?>
<h2 class="mt-4">Список задач.</h2>
<a href="/tasks/add" class="btn btn-info btn-lg active" role="button" aria-pressed="true">Добавить новый</a>
<table class="table">
    <thead class="thead-light">
    <tr>
        <?php
        $sort_field = "";
        $sort_direction = "";
        $page = 1;
        if(!empty($data["sort"])){
            $sort_field = $data["sort"];
        }
        if(!empty($data["direction"])){
            $sort_direction = $data["direction"];
        }
        if(!empty($_GET["page"])){
            $page = intval($_GET["page"]);
        }
        echo make_th("Имени пользователя", "user_name", $sort_field, $sort_direction, $page);
        echo make_th("е-mail", "email", $sort_field, $sort_direction, $page);
        echo make_th("Текста задачи", "task", $sort_field, $sort_direction, $page);
        ?>
        <?php if(isset($_SESSION["is_logged"])){ ?>
            <th scope="col">Выполнено</th>
            <th scope="col">Редактыровано</th>
            <th scope="col">Операции</th>
        <?php }?>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($data) && !empty($data["records"])){
        $records = $data["records"];
        foreach($records as $key => $record){
            if($record["status"] == 1){
                echo "<tr class=\"table-success\">";
            } else {
                echo "<tr>";
            }
            echo "<td>{$record["user_name"]}</td>";
            echo "<td>{$record["email"]}</td>";
            echo "<td>" . htmlentities($record["task"]) . "</td>";
            if(isset($_SESSION["is_logged"])){
                if($record["status"] == 1){
                    echo "<td><i class=\"fas fa-check\"></i></td>";
                } else {
                    echo "<td></td>";
                }
                if($record["is_edited"] == 1){
                    echo "<td><i class=\"fas fa-check\"></i></td>";
                } else {
                    echo "<td></td>";
                }
                echo "<td>
                    <div class=\"btn-group\" role=\"group\" aria-label=\"First group\">
                        <a href=\"/tasks/edit?id={$record["id"]}\" class=\"btn btn-primary btn-sm\" tabindex=\"-1\" role=\"button\" ><i class=\"far fa-edit\"></i></a>
                        <a href=\"/tasks/delete?id={$record["id"]}\" class=\"btn btn-primary btn-sm\" tabindex=\"-1\" role=\"button\" ><i class=\"fas fa-trash-alt\"></i></a>
                    </div>
                </td>";
            }
            echo "</tr>";
        }
    }
    ?>
    </tbody>
</table>
<?php
if(!empty($data) && !empty($data["paging"])){
    echo $data["paging"];
}
?>