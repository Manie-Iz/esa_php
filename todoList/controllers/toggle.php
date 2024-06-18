<?php
require '../includes/functions.php';

if (isset($_GET['index'])) {
    $index = $_GET['index'];
    $todos = getTodos();
    if (isset($todos[$index])) {
        $todos[$index]['completed'] = !$todos[$index]['completed'];
        saveTodos($todos);
    }
}

header('Location: ../index.php');
exit;
?>