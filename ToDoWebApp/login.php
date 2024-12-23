<?php
session_start();
include('conn.php');

if (isset($_SESSION['user'])) {

    header("Location: show.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ? AND password = ?";


    $stmt = $conn->prepare($query);

    $stmt->bind_param("ss", $username, $password);


    $stmt->execute();


    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        header("Location: show.php");
        exit();
    } else {
        echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect');</script>";
    }

    $stmt->close();
}
if (isset($_POST['register'])) {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $new_mail = $_POST['new_mail'];

    // Vérification si l'email existe déjà
    $check_email_query = "SELECT * FROM users WHERE email = ?";
    $check_stmt = $conn->prepare($check_email_query);
    $check_stmt->bind_param("s", $new_mail);
    $check_stmt->execute();
    $email_result = $check_stmt->get_result();

    if ($email_result->num_rows > 0) {
        echo "<script>alert('Cet email est déjà utilisé.');</script>";
    } else {
        $query = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $new_username, $new_password, $new_mail);

        if ($stmt->execute()) {
            echo "<script>alert('Inscription réussie! Vous pouvez maintenant vous connecter.');</script>";
        } else {
            echo "<script>alert('Erreur lors de l\'inscription.');</script>";
        }

        $stmt->close();
    }
    $check_stmt->close();
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion et Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url(images/hero-bg.jpg);
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .logo h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .login-container,
        .register-container {
            display: none;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .active {
            display: flex;
        }

        .image {
            position: relative;
            text-align: center;
            color: white;
        }

        .image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .text-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }

        .text-overlay h1 {
            margin: 0;
            font-size: 2em;
            font-weight: bold;
        }

        .text-overlay p {
            margin-top: 10px;
            font-size: 1.2em;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="password"],
        input[type="mail"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .link {
            text-align: center;
            margin-top: 10px;
        }

        .link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <header>
        <nav class="navbar">
            <div class="logo">
                <img src="images/logo.jpeg" alt="logo">
                <h2>ZeusFlutter</h2>
            </div>
        </nav>
    </header>

    <div class="login-container active" id="login-form">
        <div class="image">
            <div class="text-overlay">
                <h1>Heureux de vous revoir, cher client !</h1>
                <p>Connectez-vous pour accéder à vos tâches et rester organisé chaque jour.</p>
            </div>
            <img src="images/signup.jpg" alt="Image de connexion">
        </div>

        <div>
            <h2>Connexion</h2>
            <form method="POST">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" name="login">Se connecter</button>
            </form>
            <div class="link">
                <p>Pas encore de compte? <a href="javascript:void(0);" onclick="toggleForm()">S'inscrire ici</a></p>
            </div>
        </div>
    </div>

    <div class="register-container" id="register-form">
        <div class="image">
            <div class="text-overlay">
                <h1>Bienvenue sur MyToDo-List Journalier</h1>
                <p>Gérez efficacement vos tâches quotidiennes avec notre outil simple et intuitif.</p>
            </div>
            <img src="images/login-img.jpg" alt="Image d'inscription">
        </div>

        <div>
            <h2>Inscription</h2>
            <form method="POST">
                <label for="new_username">Nom d'utilisateur:</label>
                <input type="text" id="new_username" name="new_username" required>

                <label for="new_password">Mot de passe:</label>
                <input type="password" id="new_password" name="new_password" required>

                <label for="new_mail">Email:</label>
                <input type="mail" id="new_mail" name="new_mail" required>

                <button type="submit" name="register">S'inscrire</button>
            </form>
            <div class="link">
                <p>Déjà un compte? <a href="javascript:void(0);" onclick="toggleForm()">Se connecter ici</a></p>
            </div>
        </div>
    </div>

    <script>
        function toggleForm() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');

            loginForm.classList.toggle('active');
            registerForm.classList.toggle('active');
        }
    </script>

</body>

</html>