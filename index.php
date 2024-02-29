<?php 
    include("./connectDB.php");

    session_start();

    $message = null;

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $rol = null;

        if($username == "admin"){
            $rol = 0;
        }else{
            $rol = 1;
        }

        $conn = connectDB();

        if($conn){
            $query = "INSERT INTO usuarios (user, password, rol) VALUES (:username, :password, :rol)";
            $statement = $conn->prepare($query);

            $statement->bindParam(":username", $username);
            $statement->bindParam(":password", $password);
            $statement->bindParam(":rol", $rol);

            if($statement->execute() && !empty($username) && !empty($password)){
                $message = "Usuario registrado";
                echo $message;
                header("Refresh: 3; url=./login.php");
                exit();
            }else{
                $message = "Error al registrar al usuario";
                echo $message;
                header("Refresh: 3; url=" . $_SERVER['PHP_SELF']); 
            }
        }else{
            echo "Error al conectar a la Base de Datos";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <header>
    <nav class="bg-gray-800">
    <ul class="flex">
        <li class="mr-6">
            <a href="#" class="text-white">Inicio</a>
        </li>
        <li class="mr-6">
            <a href="#" class="text-white">Sobre nosotros</a>
        </li>
        <li>
            <a href="#" class="text-white">Términos y privacidad</a>
        </li>
    </ul>
</nav>
    </header>
    <form method="post">
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password">
        <button>Registrarse</button>
    </form>
    <a href="./login.php">Iniciar sesión</a>
</body>
</html>