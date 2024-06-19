<?php
require '../includes/functions.php';

if (isset($_POST['task'])) {
    $task = $_POST['task'];
    $completion_date = $_POST['completion_date'] ? $_POST['completion_date'] : '';
    $priority = $_POST['priority'];
    $todos = getTodos();
    $id = count($todos) ? max(array_column($todos, 'id')) + 1 : 1;
    $todos[] = ['id' => $id, 'name' => $task, 'completed' => false, 'completion_date' => $completion_date, 'priority' => $priority];
    saveTodos($todos);
}

header('Location: ../index.php');
exit;
?>