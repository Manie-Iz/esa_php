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
            foreach ($tasks as $index => $task) {
                echo '<li>';
                echo htmlspecialchars($task['name']);
                echo $task['completed'] ? ' <span class="badge badge-success">Réalisée</span>' : ' <span class="badge badge-warning">Non Réalisée</span>';
                echo '<span class="task-actions">';
                echo " <a href='controllers/toggle.php?index=$index' class='btn btn-sm btn-secondary'>Toggle</a>";
                echo " <a href='controllers/edit.php?index=$index' class='btn btn-sm btn-info'>Editer</a>";
                echo " <a href='controllers/delete.php?index=$index' class='btn btn-sm btn-danger'>Supprimer</a>";
                echo '</span>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>