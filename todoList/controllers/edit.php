<?php
require '../includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $todos = getTodos();
    foreach ($todos as &$task) {
        if ($task['id'] == $id) {
            if (isset($_POST['task'])) {
                $task['name'] = $_POST['task'];
            }
            break;
        }
    }
    saveTodos($todos);
    header('Location: ../index.php');
    exit;
}

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
        <form action="edit.php?id=<?php echo $id; ?>" method="post" class="form-inline">
            <input type="text" class="form-control" name="task" value="<?php echo htmlspecialchars($taskToEdit['name']); ?>" required>
            <button type="submit" class="btn btn-primary mb-2">Mettre à jour</button>
        </form>
    </div>
</body>
</html>