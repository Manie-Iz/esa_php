<?php
require '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $todos = getTodos();
    foreach ($todos as &$task) {
        if ($task['id'] == $id) {
            $task['completed'] = !$task['completed'];
            break;
        }
    }
    saveTodos($todos);
}

header('Location: ../index.php');
exit;
?>