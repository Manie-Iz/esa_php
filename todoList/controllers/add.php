<?php
date_default_timezone_set('Europe/Paris'); 
require '../includes/functions.php';

if (isset($_POST['task'])) {
    $task = $_POST['task'];
    $completion_date = $_POST['completion_date'];
    $completion_time = $_POST['completion_time'];
    $completion_datetime = $completion_date;
    if (!empty($completion_time)) {
        $completion_datetime .= " $completion_time";
    }
    $priority = $_POST['priority'];
    $category = isset($_POST['category']) && $_POST['category'] !== '' ? $_POST['category'] : 'Sans Catégorie';
    $todos = getTodos();
    $id = count($todos) ? max(array_column($todos, 'id')) + 1 : 1;
    $todos[] = ['id' => $id, 'name' => $task, 'completed' => false, 'completion_date' => $completion_datetime, 'priority' => $priority, 'category' => $category];
    saveTodos($todos);
}

header('Location: ../index.php');
exit;
?>