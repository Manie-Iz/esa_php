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
            <input type="datetime-local" name="completion_date" class="form-control ml-2">
            <select name="priority" class="form-control ml-2">
                <option value="urgent">Urgente</option>
                <option value="important">Importante</option>
                <option value="any">Quelconque</option>
            </select>
            <button type="submit">Ajouter Tâche</button>
        </form>

        <?php
        require 'includes/functions.php';
        $tasks = getTodos();

        // Trier les tâches par priorité et état de complétion
        usort($tasks, function($a, $b) {
            if ($a['priority'] == $b['priority']) {
                return $a['completed'] - $b['completed'];
            }
            return ($a['priority'] == 'urgent') ? -1 : (($a['priority'] == 'important') ? -1 : 1);
        });

        function displayTasks($tasks, $priority, $title) {
            echo "<h2>$title</h2>";
            echo '<ul class="task-list">';
            $hasTasks = false;
            foreach ($tasks as $task) {
                if ($task['priority'] == $priority) {
                    $hasTasks = true;
                    $class = $task['completed'] ? 'task-completed' : '';
                    echo "<li class='$class'>";
                    echo "<span class='task-name'>" . htmlspecialchars($task['name']) . "</span>";
                    if ($task['completion_date']) {
                        $date = DateTime::createFromFormat('Y-m-d\TH:i', $task['completion_date']);
                        if ($date) {
                            $formattedDate = $date->format('d-m-Y H:i');
                            if ($task['completed']) {
                                echo "<br><small>A été accomplie le: " . htmlspecialchars($formattedDate) . "</small>";
                            } else {
                                echo "<br><small>A accomplir pour le: " . htmlspecialchars($formattedDate) . "</small>";
                            }
                        } else {
                            echo "<br><small>Date non valide: " . htmlspecialchars($task['completion_date']) . "</small>";
                        }
                    }
                    echo '<span class="task-actions">';
                    echo $task['completed'] ? ' <span class="badge badge-success">Réalisée</span>' : ' <span class="badge badge-warning">Non Réalisée</span>';
                    echo " <a href='controllers/toggle.php?id={$task['id']}' class='btn btn-sm btn-secondary'>Terminer</a>";
                    echo " <a href='controllers/edit.php?id={$task['id']}' class='btn btn-sm btn-info'>Editer</a>";
                    echo " <a href='controllers/delete.php?id={$task['id']}' class='btn btn-sm btn-danger'>Supprimer</a>";
                    echo '</span>';
                    echo '</li>';
                }
            }
            if (!$hasTasks) {
                echo "<p class='no-tasks'>Aucune tâche ici pour l'instant</p>";
            }
            echo '</ul>';
        }

        displayTasks($tasks, 'urgent', 'Tâches Urgentes');
        displayTasks($tasks, 'important', 'Tâches Importantes');
        displayTasks($tasks, 'any', 'Tâches Quelconques');
        ?>
    </div>
</body>
</html>