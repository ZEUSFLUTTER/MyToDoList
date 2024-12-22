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
.grad1 {
    height: 200px;
    background: red; 
    background: -webkit-linear-gradient(red, yellow);
    background: -o-linear-gradient(red, yellow); 
    background: -moz-linear-gradient(red, yellow); 
    background: linear-gradient(red, yellow); 
}
.grad1 {
    height: 200px;
    background: yellow; 
    background: -webkit-linear-gradient( yellow,red);
    background: -o-linear-gradient( yellow,red); 
    background: -moz-linear-gradient(yellow,red); 
    background: linear-gradient(yellow,red); 
}
#myfirst_div{
	display: block;
background-color: #99ff66;
margin: 0px;
padding: 90px;	

}
#second_div{
	display: block;
background-color: #ff3300;
margin: 0px;
padding:120px;	

}
.navbar-brand {
  float: left;
  height: 50px;
  padding: 15px 15px;
  font-size: 18px;
  line-height: 20px;
}
.third_div{

}

#abc{

	text-align: left;
  	font-size: 28px;
}
	

</style>
</head>
<body>

<div class="container">
    <h1>Bienvenue  <?php echo $_SESSION['user']; ?>Sur MyToDo-List</h1>
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
