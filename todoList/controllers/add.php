<?php
date_default_timezone_set('Europe/Paris'); // Définir le fuseau horaire par défaut
require_once __DIR__ . '/../includes/functions.php';

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
    
    // Trouver le plus grand identifiant sans addition directe
    $id = 1;
    if (!empty($todos)) {
        $max_id = 0;
        foreach ($todos as $todo) {
            if ($todo['id'] > $max_id) {
                $max_id = $todo['id'];
            }
        }
        $id = $max_id + 1;
    }

    $todos[] = ['id' => $id, 'name' => $task, 'completed' => false, 'completion_date' => $completion_datetime, 'priority' => $priority, 'category' => $category];
    saveTodos($todos);
}

header('Location: ../index.php');
exit;
?>