<?php
session_start();
include "../config/db.php";

$error = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id,username,role_id,password FROM users WHERE username=?");
    $stmt->bind_param("s",$username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user && password_verify($password,$user['password'])){

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role_id'] = $user['role_id'];

        header("Location: ../hospital/dashboard.php");
        exit();

    }else{
        $error = "Invalid Username or Password";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hospital Management System</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="video-bg-container">
    <!-- Hospital Video Background -->
    <video class="video-bg" autoplay muted loop playsinline preload="auto">
        <source src="../hospital-background.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <div class="video-overlay"></div>

    <div class="glass-card">
        <div class="glass-card-header">
            <div class="glass-card-logo">
                <i class="fa-solid fa-hospital-user"></i>
            </div>
            <h1>CarePulse Hospital</h1>
            <p class="subtitle" style="color: #64748b; margin-top: 0.25rem;">Sign in to access medical portal</p>
        </div>

        <?php if($error): ?>
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label" for="username"><i class="fa-solid fa-user"></i> Username</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="password"><i class="fa-solid fa-lock"></i> Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>

            <button type="submit" name="login" class="btn btn-primary btn-block" style="margin-top: 1.5rem; padding: 0.85rem;">
                <i class="fa-solid fa-right-to-bracket"></i> Login to Portal
            </button>
        </form>

        <div style="text-align: center; margin-top: 1.75rem;">
            <a href="register.php" style="font-weight: 600;">
                Don't have an account? Create Account <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <p style="text-align: center; margin-top: 1.5rem; font-size: 0.8rem; color: #64748b;">
            <i class="fa-solid fa-lock"></i> Protected by 256-bit HIPAA compliant security
        </p>
    </div>
</div>

</body>
</html>