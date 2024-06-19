<?php

function getTodos() {
    $file_path = __DIR__ . '/../todos.csv'; // Chemin absolu vers le fichier CSV

    if (!file_exists($file_path)) {
        return [];
    }
    
    $file = fopen($file_path, 'r');
    $todos = [];
    while (($data = fgetcsv($file)) !== FALSE) {
        $todos[] = ['id' => $data[0], 'name' => $data[1], 'completed' => $data[2] == '1'];
    }
    fclose($file);
    return $todos;
}

function saveTodos($todos) {
    $file_path = __DIR__ . '/../todos.csv'; // Chemin absolu vers le fichier CSV

    $file = fopen($file_path, 'w');
    foreach ($todos as $task) {
        fputcsv($file, [$task['id'], $task['name'], $task['completed'] ? '1' : '0']);
    }
    fclose($file);
}
?>