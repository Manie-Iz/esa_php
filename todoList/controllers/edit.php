<?php
require '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && isset($_POST['task'])) {
        $id = $_POST['id'];
        $task_name = $_POST['task'];
        $completion_date = $_POST['completion_date'] ? $_POST['completion_date'] : '';
        $priority = $_POST['priority'];

        $todos = getTodos();
        foreach ($todos as &$task) {
            if ($task['id'] == $id) {
                $task['name'] = $task_name;
                $task['completion_date'] = $completion_date;
                $task['priority'] = $priority;
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
            <input type="datetime-local" class="form-control ml-2" name="completion_date" value="<?php echo htmlspecialchars($taskToEdit['completion_date']); ?>">
            <select name="priority" class="form-control ml-2">
                <option value="urgent" <?php echo $taskToEdit['priority'] == 'urgent' ? 'selected' : ''; ?>>Urgente</option>
                <option value="important" <?php echo $taskToEdit['priority'] == 'important' ? 'selected' : ''; ?>>Importante</option>
                <option value="any" <?php echo $taskToEdit['priority'] == 'any' ? 'selected' : ''; ?>>Quelconque</option>
            </select>
            <button type="submit" class="btn btn-primary mb-2">Mettre à jour</button>
        </form>
    </div>
</body>
</html>