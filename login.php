<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "cotemag");

// Check for saved credentials in cookies
if (!isset($_POST['login']) && isset($_COOKIE['remembered_user'])) {
    $username = $_COOKIE['remembered_user'];
    $password = $_COOKIE['remembered_pass'];
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;

    $query = "SELECT * FROM usuarios WHERE username = '$username'";
    $result = mysqli_query($conexion, $query);

    if($row = mysqli_fetch_assoc($result)) {
        if(password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Set cookies if remember me is checked
            if($remember) {
                setcookie('remembered_user', $username, time() + (30 * 24 * 60 * 60), '/');
                setcookie('remembered_pass', $password, time() + (30 * 24 * 60 * 60), '/');
            } else {
                // Clear cookies if not checked
                setcookie('remembered_user', '', time() - 3600, '/');
                setcookie('remembered_pass', '', time() - 3600, '/');
            }

            header("Location: dashboard.php");
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cotemag</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Cotemag/assets/css/login.css">
    <link rel="icon" href="/Cotemag/assets/img/logo5.png" type="image/png">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Administrador Blog</h3>
                    </div>
                    <div class="text-center mt-4 mb-3">
                        <img src="/Cotemag/assets/img/logo5.png" alt="Cotemag Logo" class="login-logo">
                    </div>
                    <div class="card-body">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form method="POST" action="">
                            <div class="form-group">
                                <label>Usuario</label>
                                <input type="text" name="username" class="form-control" 
                                    value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control" 
                                    value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember" 
                                        <?php echo isset($_COOKIE['remembered_user']) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label" for="remember">Recordar mis datos</label>
                                </div>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary btn-block">Iniciar Sesión</button>
                        </form>
                        <p class="text-center mt-3">
                            ¿No tienes una cuenta? <a href="registro.php">Regístrate</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>