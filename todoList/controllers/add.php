<?php
date_default_timezone_set('Europe/Paris'); // Définir le fuseau horaire par défaut
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
    $todos = getTodos();
    $id = count($todos) ? max(array_column($todos, 'id')) + 1 : 1;
    $todos[] = ['id' => $id, 'name' => $task, 'completed' => false, 'completion_date' => $completion_datetime, 'priority' => $priority];
    saveTodos($todos);
}

header('Location: ../index.php');
exit;
?>