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
            <button type="submit">Ajouter Tâche</button>
        </form>
        
        <ul class="task-list">
            <?php
            require 'includes/functions.php';
            $tasks = getTodos();
            
            // Trier les tâches : non terminées en haut, terminées en bas
            usort($tasks, function($a, $b) {
                return $a['completed'] - $b['completed'];
            });

            foreach ($tasks as $task) {
                $class = $task['completed'] ? 'task-completed' : '';
                echo "<li class='$class'>";
                echo htmlspecialchars($task['name']);
                echo $task['completed'] ? ' <span class="badge badge-success">Réalisée</span>' : ' <span class="badge badge-warning">Non Réalisée</span>';
                echo '<span class="task-actions">';
                echo " <a href='controllers/toggle.php?id={$task['id']}' class='btn btn-sm btn-secondary'>Terminer</a>";
                echo " <a href='controllers/edit.php?id={$task['id']}' class='btn btn-sm btn-info'>Editer</a>";
                echo " <a href='controllers/delete.php?id={$task['id']}' class='btn btn-sm btn-danger'>Supprimer</a>";
                echo '</span>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>