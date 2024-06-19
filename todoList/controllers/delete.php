<?php
require '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $todos = getTodos();
    foreach ($todos as $key => $task) {
        if ($task['id'] == $id) {
            unset($todos[$key]);
            break;
        }
    }
    saveTodos(array_values($todos));
}

header('Location: ../index.php');
exit;
?>