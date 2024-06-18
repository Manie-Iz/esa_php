<?php

function getTodos() {
    $file_path = __DIR__ . '/../todos.csv'; 

    if (!file_exists($file_path)) {
        return [];
    }
    
    $file = fopen($file_path, 'r');
    $todos = [];
    while (($data = fgetcsv($file)) !== FALSE) {
        $todos[] = ['name' => $data[0], 'completed' => $data[1] == '1'];
    }
    fclose($file);
    return $todos;
}

function saveTodos($todos) {
    $file_path = __DIR__ . '/../todos.csv'; 

    $file = fopen($file_path, 'w');
    foreach ($todos as $task) {
        fputcsv($file, [$task['name'], $task['completed'] ? '1' : '0']);
    }
    fclose($file);
}
?>