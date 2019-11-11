<br/>
<br/>
<?php
if(!empty($data) && !empty($data["error_message"])){
    echo "<h1>" . $data["error_message"] . "</h1>";
} else {
    echo "<h1>Запрашиваемая страница не найдено!</h1>";
}
?>