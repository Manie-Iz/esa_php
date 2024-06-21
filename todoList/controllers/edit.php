<?php
date_default_timezone_set('Europe/Paris'); // Définir le fuseau horaire par défaut
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['task'])) {
        $id = $_POST['id'];
        $task_name = $_POST['task'];
        $completion_date = $_POST['completion_date'];
        $completion_time = $_POST['completion_time'];
        $completion_datetime = $completion_date;
        if (!empty($completion_time)) {
            $completion_datetime .= " $completion_time";
        }
        $priority = $_POST['priority'];
        $category = isset($_POST['category']) && $_POST['category'] !== '' ? $_POST['category'] : 'Sans Catégorie';

        $todos = getTodos();
        foreach ($todos as &$task) {
            if ($task['id'] == $id) {
                $task['name'] = $task_name;
                $task['completion_date'] = $completion_datetime;
                $task['priority'] = $priority;
                $task['category'] = $category;
                break;
            }
        }
        saveTodos($todos);
        header('Location: ../index.php');
        exit;
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $todos = getTodos();
        foreach ($todos as $task) {
            if ($task['id'] == $id) {
                $taskToEdit = $task;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editer Tâche</title>
    <link href="../public/css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Editer Tâche</h1>
        <form action="edit.php" method="post" class="form-inline">
            <input type="hidden" name="id" value="<?php echo $taskToEdit['id']; ?>">
            <input type="text" class="form-control" name="task" value="<?php echo htmlspecialchars($taskToEdit['name']); ?>" required>
            <input type="date" class="form-control ml-2" name="completion_date" value="<?php echo htmlspecialchars(substr($taskToEdit['completion_date'], 0, 10)); ?>">
            <input type="time" class="form-control ml-2" name="completion_time" value="<?php echo htmlspecialchars(substr($taskToEdit['completion_date'], 11)); ?>">
            <select name="priority" class="form-control ml-2">
                <option value="urgent" <?php echo $taskToEdit['priority'] == 'urgent' ? 'selected' : ''; ?>>Urgente</option>
                <option value="important" <?php echo $taskToEdit['priority'] == 'important' ? 'selected' : ''; ?>>Importante</option>
                <option value="any" <?php echo $taskToEdit['priority'] == 'any' ? 'selected' : ''; ?>>Quelconque</option>
            </select>
            <input type="text" class="form-control ml-2" name="category" value="<?php echo htmlspecialchars($taskToEdit['category']); ?>" placeholder="Catégorie (optionnelle)">
            <button type="submit" class="btn btn-primary mb-2">Mettre à jour</button>
        </form>
    </div>
</body>
</html>