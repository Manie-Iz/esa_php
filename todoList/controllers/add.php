<?php
require '../includes/functions.php';

if (isset($_POST['task'])) {
    $task = $_POST['task'];
    $todos = getTodos();
    $todos[] = ['name' => $task, 'completed' => false];
    saveTodos($todos);
}

header('Location: ../index.php');
exit;
?>