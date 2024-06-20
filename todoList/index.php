<?php
date_default_timezone_set('Europe/Paris'); // Définir le fuseau horaire par défaut
require 'includes/functions.php';
$tasks = getTodos();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Liste de Tâches</title>
    <link href="public/css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Liste de Tâches</h1>
        
        <form action="controllers/add.php" method="post" class="form-inline mb-3">
            <input type="text" name="task" placeholder="Nouvelle tâche" required>
            <input type="date" name="completion_date" class="form-control ml-2">
            <input type="time" name="completion_time" class="form-control ml-2">
            <select name="priority" class="form-control ml-2">
                <option value="urgent">Urgente</option>
                <option value="important">Importante</option>
                <option value="any">Quelconque</option>
            </select>
            <button type="submit">Ajouter Tâche</button>
        </form>

        <?php

        usort($tasks, function($a, $b) {
            if ($a['priority'] == $b['priority']) {
                return $a['completed'] - $b['completed'];
            }
            return ($a['priority'] == 'urgent') ? -1 : (($a['priority'] == 'important') ? -1 : 1);
        });

        function displayTasks($tasks) {
            echo '<ul class="task-list">';
            foreach ($tasks as $task) {
                $class = $task['completed'] ? 'task-completed' : '';
                $colorClass = '';
                $priorityText = '';
                switch ($task['priority']) {
                    case 'urgent':
                        $colorClass = 'priority-urgent';
                        $priorityText = 'Tâche Urgente';
                        break;
                    case 'important':
                        $colorClass = 'priority-important';
                        $priorityText = 'Tâche Importante';
                        break;
                    case 'any':
                        $colorClass = 'priority-any';
                        $priorityText = 'Tâche Quelconque';
                        break;
                }
                echo "<li class='$class'>";
                echo "<div class='task-content'>";
                echo "<span class='task-name'>" . htmlspecialchars($task['name']) . "</span>";
                if ($task['completion_date']) {
                    $date = DateTime::createFromFormat('Y-m-d H:i', $task['completion_date']) ?: DateTime::createFromFormat('Y-m-d', $task['completion_date']);
                    if ($date) {
                        $formattedDate = $date->format(strpos($task['completion_date'], ' ') !== false ? 'd-m-Y H:i' : 'd-m-Y');
                        if ($task['completed']) {
                            echo "<br><small>A été accomplie le: " . htmlspecialchars($formattedDate) . "</small>";
                        } else {
                            echo "<br><small>A accomplir pour le: " . htmlspecialchars($formattedDate) . "</small>";
                        }
                    } else {
                        echo "<br><small>Date non valide: " . htmlspecialchars($task['completion_date']) . "</small>";
                    }
                }
                echo "<div class='priority-indicator-container'>";
                echo "<span class='priority-indicator $colorClass'></span>";
                echo "<span class='priority-text'>$priorityText</span>";
                echo "</div>";
                echo '</div>';
                echo '<span class="task-actions">';
                echo $task['completed'] ? ' <span class="badge badge-success">Réalisée</span>' : ' <span class="badge badge-warning">Non Réalisée</span>';
                echo " <a href='controllers/toggle.php?id={$task['id']}' class='btn btn-sm btn-secondary'>Terminer</a>";
                echo " <a href='controllers/edit.php?id={$task['id']}' class='btn btn-sm btn-info'>Editer</a>";
                echo " <a href='controllers/delete.php?id={$task['id']}' class='btn btn-sm btn-danger'>Supprimer</a>";
                echo '</span>';
                echo '</li>';
            }
            echo '</ul>';
        }

        displayTasks($tasks);
        ?>
    </div>
</body>
</html>