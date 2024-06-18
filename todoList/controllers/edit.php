<?php
require '../includes/functions.php';

if (isset($_GET['index'])) {
    $index = $_GET['index'];
    $todos = getTodos();
    if (isset($todos[$index])) {
        $task = $todos[$index];
    }
}

if (isset($_POST['task'])) {
    $newTask = $_POST['task'];
    $todos[$index]['name'] = $newTask;
    saveTodos($todos);
    header('Location: ../index.php');
    exit;
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
        <form action="edit.php?index=<?php echo $index; ?>" method="post" class="form-inline">
            <input type="text" class="form-control" name="task" value="<?php echo htmlspecialchars($task['name']); ?>" required>
            <button type="submit" class="btn btn-primary mb-2">Mettre à jour</button>
        </form>
    </div>
</body>
</html>