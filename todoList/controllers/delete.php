<?php
require '../includes/functions.php';

if (isset($_GET['index'])) {
    $index = $_GET['index'];
    $todos = getTodos();
    if (isset($todos[$index])) {
        array_splice($todos, $index, 1);
        saveTodos($todos);
    }
}

header('Location: ../index.php');
exit;
?>