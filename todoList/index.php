<!DOCTYPE html>
<html>
<head>
    <title>Liste de Tâches</title>
    <link href="public/css/styles.css" rel="stylesheet">
</head>
<body class="<?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'dark-mode' : ''; ?>">
    <div class="container">
        <h1 class="mt-5">Liste de Tâches</h1>

        <!-- Bouton pour basculer entre les modes -->
        <form action="toggle_theme.php" method="post" style="margin-bottom: 20px;">
            <button type="submit" name="toggle-theme" class="btn btn-secondary">
                <?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'Mode Clair' : 'Mode Sombre'; ?>
            </button>
        </form>

        <!-- Formulaire pour ajouter une nouvelle tâche -->
        <form action="controllers/add.php" method="post" class="form-inline mb-3">
            <input type="text" name="task" placeholder="Nouvelle tâche" required>
            <input type="date" name="completion_date" class="form-control ml-2">
            <input type="time" name="completion_time" class="form-control ml-2">
            <select name="priority" class="form-control ml-2">
                <option value="urgent">Urgente</option>
                <option value="important">Importante</option>
                <option value="any">Quelconque</option>
            </select>
            <input type="text" name="category" placeholder="Catégorie (optionnelle)" class="form-control ml-2">
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

        // Groupes de tâches par catégorie et séparer les tâches terminées
        $groupedTasks = [];
        $completedTasks = [];
        foreach ($tasks as $task) {
            if ($task['completed']) {
                $completedTasks[] = $task;
            } else {
                $category = $task['category'];
                if (!isset($groupedTasks[$category])) {
                    $groupedTasks[$category] = [];
                }
                $groupedTasks[$category][] = $task;
            }
        }

        // Fonction pour afficher les tâches par catégorie
        function displayTasks($tasks, $category) {
            echo "<h2>$category</h2>";
            echo '<ul class="task-list">';
            foreach ($tasks as $task) {
                $class = $task['completed'] ? 'task-completed' : '';
                $colorClass = '';
                $priorityText = '';
                $dateClass = '';
                if ($task['completion_date']) {
                    $currentDate = new DateTime();
                    $taskDate = DateTime::createFromFormat('Y-m-d H:i', $task['completion_date']) ?: DateTime::createFromFormat('Y-m-d', $task['completion_date']);
                    if ($taskDate && $taskDate < $currentDate && !$task['completed']) {
                        $dateClass = 'date-overdue';
                    }
                }
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
                    $formattedDate = $taskDate->format(strpos($task['completion_date'], ' ') !== false ? 'd-m-Y H:i' : 'd-m-Y');
                    if ($task['completed']) {
                        echo "<br><small class='$dateClass'>A été accomplie le: " . htmlspecialchars($formattedDate) . "</small>";
                    } else {
                        echo "<br><small class='$dateClass'>A accomplir pour le: " . htmlspecialchars($formattedDate) . "</small>";
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

        // Afficher les tâches par catégorie
        foreach ($groupedTasks as $category => $tasks) {
            displayTasks($tasks, $category);
        }

        // Afficher les tâches terminées
        if (!empty($completedTasks)) {
            echo "<h2>Tâches Terminées</h2>";
            echo '<ul class="task-list">';
            foreach ($completedTasks as $task) {
                echo "<li class='task-completed'>";
                echo "<div class='task-content'>";
                echo "<span class='task-name'>" . htmlspecialchars($task['name']) . "</span>";
                if ($task['completion_date']) {
                    $taskDate = DateTime::createFromFormat('Y-m-d H:i', $task['completion_date']) ?: DateTime::createFromFormat('Y-m-d', $task['completion_date']);
                    $formattedDate = $taskDate->format(strpos($task['completion_date'], ' ') !== false ? 'd-m-Y H:i' : 'd-m-Y');
                    echo "<br><small>A été accomplie le: " . htmlspecialchars($formattedDate) . "</small>";
                }
                echo '</div>';
                echo '<span class="task-actions">';
                echo ' <span class="badge badge-success">Réalisée</span>';
                echo " <a href='controllers/toggle.php?id={$task['id']}' class='btn btn-sm btn-secondary'>Non terminée</a>";
                echo " <a href='controllers/edit.php?id={$task['id']}' class='btn btn-sm btn-info'>Editer</a>";
                echo " <a href='controllers/delete.php?id={$task['id']}' class='btn btn-sm btn-danger'>Supprimer</a>";
                echo '</span>';
                echo '</li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
</body>
</html>