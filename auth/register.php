<?php
include "../config/db.php";

$message = "";
$error = "";

if(isset($_POST["register"])){

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id  = $_POST['role_id'];

    $stmt = $conn->prepare("INSERT INTO users(username,password,role_id) VALUES (?,?,?)");
    $stmt->bind_param("ssi",$username,$password,$role_id);

    if($stmt->execute()){
        header("Location: login.php?registered=1");
        exit();
    }else{
        $error = "Registration failed. Username may already exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Hospital Management System</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="video-bg-container">
        <!-- Hospital Background Video -->
        <video class="video-bg" autoplay muted loop playsinline preload="auto">
            <source src="../hospital-background.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        <div class="video-overlay"></div>

        <section class="glass-card" style="max-width: 520px;">
            <div class="glass-card-header">
                <div class="glass-card-logo">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <h1>Create Account</h1>
                <p class="subtitle" style="color: #64748b; margin-top: 0.25rem;">Register for CarePulse Hospital System</p>
            </div>

            <?php if($error): ?>
                <div class="alert alert-danger">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label class="form-label" for="username"><i class="fa-solid fa-user"></i> Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Choose a username" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password"><i class="fa-solid fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Create a strong password" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="role_id"><i class="fa-solid fa-id-badge"></i> Account Role</label>
                    <select id="role_id" name="role_id" class="form-control" required>
                        <option value="">Select your role</option>
                        <option value="1">Admin</option>
                        <option value="2">Doctor</option>
                        <option value="3">Nurse</option>
                        <option value="4">Patient</option>
                        <option value="5">Accountant</option>
                    </select>
                </div>

                <button class="btn btn-primary btn-block" type="submit" name="register" style="margin-top: 1.5rem; padding: 0.85rem;">
                    <i class="fa-solid fa-user-check"></i> Register Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.75rem;">
                <a class="login-link" href="login.php" style="font-weight: 600;">
                    Already have an account? Login here <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <p style="text-align: center; margin-top: 1.5rem; font-size: 0.8rem; color: #64748b;">
                <i class="fa-solid fa-shield-halved"></i> Your account information is securely protected.
            </p>
        </section>
    </div>
</body>
</html>