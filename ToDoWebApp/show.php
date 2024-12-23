<?php
session_start();

if (!isset($_SESSION['user'])) {
  
    header('Location: login.php');
    exit();
}

include('conn.php');
date_default_timezone_set('Asia/karachi');

if (isset($_REQUEST['btn'])) {
    $name = $_SESSION['user'];
    $status = $_REQUEST['status'];
    $tmn = $_REQUEST['tmn'];
    $st = $_REQUEST['st'];
    $pre = $_REQUEST['pre'];

    if (preg_match('/^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/', $st) && preg_match('/^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/', $tmn)) {
        $add = "INSERT INTO task (user, task, st, tme, pre) VALUES ('$name', '$status', '$st', '$tmn', '$pre')";
        $res = $conn->query($add);

        if ($res) {
            echo "<script>alert('Insertion réussie'); window.location = 'show.php';</script>";
        } else {
            echo "<script>alert('Impossible d\'insérer'); window.location = 'show.php';</script>";
        }
    } else {
        echo "<script>alert('Veuillez entrer des valeurs valides'); window.location = 'show.php';</script>";
    }
}

$user = $_SESSION['user'];
$s = "SELECT * FROM task WHERE user='$user' ORDER BY st";
$res = $conn->query($s);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste de tâches</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<style type="text/css">

/* Fond d'écran */
body {
    background-image: url(discipine.jpg);
    background-size: cover;
    background-position: center;
    color: white;
    font-family: Arial, sans-serif;
}

h1 {
    color: white;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    text-align: center;
    margin-top: 30px;
}

.navbar-brand {
    color: white !important;
    font-size: 20px;
}

.container {
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    padding: 30px;
    margin: 20px auto;
}

table {
    width: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    border-radius: 10px;
    color: white;
    margin-top: 20px;
}

table th,
table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #444;
}

table th {
    background-color: rgba(0, 0, 0, 0.9);
    color: #ffcc00;
}

table td {
    color: black;
    background-color: rgba(0, 0, 0, 0.8);
}

tr.info {
    background-color: rgba(0, 255, 255, 0.3);
    color: black;
}

tr.success {
    background-color: rgba(0, 255, 0, 0.3);
    color: black;
}

tr.warning {
    background-color: rgba(255, 255, 0, 0.3);
    color: black;
}

tr.danger {
    background-color: rgba(255, 0, 0, 0.3);
    color: white;
}

button, .btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover, .btn:hover {
    background-color: #0056b3;
}

.form-control {
    background-color: rgba(255, 255, 255, 0.1);
    color: white;
    border-radius: 5px;
    border: 1px solid #444;
    padding: 10px;
    font-size: 16px;
}

.form-control:focus {
    background-color: rgba(255, 255, 255, 0.2);
    outline: none;
}

#myfirst_div, #second_div {
    background-color: rgba(0, 0, 0, 0.7);
    margin: 20px 0;
    padding: 40px;
    border-radius: 10px;
}

.alert {
    background-color: #333;
    color: white;
    border: 1px solid #444;
    border-radius: 5px;
    padding: 10px;
}

.third_div {
    padding: 20px;
    margin-top: 20px;
}

#abc {
    text-align: left;
    font-size: 28px;
}



</style>
</head>
<body>

<div class="container">
    <h1>Bienvenue  <?php echo $_SESSION['user']; ?> Sur MyToDo-List Journalier</h1>
    <a href="logout.php" class="btn btn-danger">Déconnexion</a>
    <br><br>
</div>

<!-- Affichage des tâches -->
<div class="container">
    <form method="POST">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Index</th>
                    <th>Tâche</th>
                    <th>Heure de début</th>
                    <th>Heure de fin</th>
                    <th>Priorité</th>
                    <th>Marquer comme terminé</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $y = 1;
                while ($fe = $res->fetch_object()) {
                    $str = '';
                    switch ($fe->pre) {
                        case 0: $str = 'info'; break;
                        case 1: $str = 'success'; break;
                        case 2: $str = 'warning'; break;
                        case 3: $str = 'danger'; break;
                    }
                    echo "<tr class='$str'>
                            <td>{$y}</td>
                            <td>{$fe->task}</td>
                            <td>{$fe->st}</td>
                            <td>{$fe->tme}</td>
                            <td><button>{$fe->pre}</button></td>
                            <td><a href='done.php?cid={$fe->id}' class='btn btn-success'>Terminé</a></td>
                            <td><a href='edit.php?eid={$fe->id}' class='btn btn-warning'>Modifier</a></td>
                            <td><a href='delete.php?did={$fe->id}' class='btn btn-danger'>Supprimer</a></td>
                          </tr>";
                    $y++;
                }
                ?>
            </tbody>
        </table>

        <!-- Formulaire d'ajout de tâche -->
        <div class="form-group">
            <label for="status">Tâche :</label>
            <input type="text" name="status" class="form-control" placeholder="Entrez votre tâche" required>
        </div>
        <div class="form-group">
            <label for="st">Heure de début :</label>
            <input type="text" name="st" class="form-control" placeholder="hh:mm:ss" required>
        </div>
        <div class="form-group">
            <label for="tmn">Heure de fin :</label>
            <input type="text" name="tmn" class="form-control" placeholder="hh:mm:ss" required>
        </div>
        <div class="form-group">
            <label for="pre">Priorité :</label>
            <select name="pre" class="form-control" required>
                <option value="" disabled selected>Choisir la priorité</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
        <button type="submit" name="btn" class="btn btn-primary">Ajouter la tâche</button>
    </form>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</body>
</html>
