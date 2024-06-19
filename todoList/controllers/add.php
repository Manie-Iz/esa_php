<?php
require '../includes/functions.php';

if (isset($_POST['task'])) {
    $task = $_POST['task'];
    $todos = getTodos();
    $id = count($todos) ? max(array_column($todos, 'id')) + 1 : 1;
    $todos[] = ['id' => $id, 'name' => $task, 'completed' => false];
    saveTodos($todos);
}

header('Location: ../index.php');
exit;
?>