<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 70%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            cursor: not-allowed;
        }

        button[disabled] {
            background-color: #ccc;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .completed .todo-title {
            text-decoration: line-through;
            color: #999;
        }

        .todo-title {
            flex-grow: 1;
        }

        .todo-actions button {
            margin-left: 5px;
            padding: 3px 8px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: not-allowed;
        }

        .todo-actions button:first-child {
            background-color: #5bc0de;
        }

        .todo-actions button:nth-child(2) {
            background-color: #f0ad4e;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>To-Do List</h1>
        <form id="todo-form">
            <input type="text" id="todo-input" placeholder="Ajouter une tâche" disabled>
            <button type="button" disabled>Ajouter</button>
        </form>
        <ul id="todo-list">
            <li class="todo-item">
                <span class="todo-title">Acheter du lait</span>
                <div class="todo-actions">
                    <button disabled>Terminé</button>
                    <button disabled>Modifier</button>
                    <button disabled>Supprimer</button>
                </div>
            </li>
            <li class="todo-item completed">
                <span class="todo-title">Faire du sport</span>
                <div class="todo-actions">
                    <button disabled>Non terminé</button>
                    <button disabled>Modifier</button>
                    <button disabled>Supprimer</button>
                </div>
            </li>
        </ul>
    </div>
</body>
</html>