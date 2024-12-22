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

    $query = "INSERT INTO users (username, password) VALUES (?, ?)";
    
    $stmt = $conn->prepare($query);
    
    $stmt->bind_param("ss", $new_username, $new_password);
    
  
    if ($stmt->execute()) {
        echo "<script>alert('Inscription réussie! Vous pouvez maintenant vous connecter.');</script>";
    } else {
        echo "<script>alert('Erreur lors de l\'inscription.');</script>";
    }

  
    $stmt->close();
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
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }

      
        .login-container, .register-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            display: none; 
        }

        .active {
            display: block; 
        }

       
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"], input[type="password"] {
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


<div class="login-container active" id="login-form">
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


<div class="register-container" id="register-form">
    <h2>Inscription</h2>
    <form method="POST">
        <label for="new_username">Nom d'utilisateur:</label>
        <input type="text" id="new_username" name="new_username" required>
        
        <label for="new_password">Mot de passe:</label>
        <input type="password" id="new_password" name="new_password" required>
        
        <button type="submit" name="register">S'inscrire</button>
    </form>
    <div class="link">
        <p>Déjà un compte? <a href="javascript:void(0);" onclick="toggleForm()">Se connecter ici</a></p>
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
