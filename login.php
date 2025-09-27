<?php 
session_start();
include("database.php");
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password"; }
        } else {
            $error = "No account found!";
            }
            $stmt->close();
            $conn->close();
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(to right, #6a11cb, #2575fc); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; }

        .form-container { background-color: #fff; 
            padding: 40px; 
            border-radius: 10px; 
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); 
            width: 100%; 
            max-width: 400px; 
            text-align: center; 
            animation: fadeIn 0.5s ease-in-out; }

        h2 { margin-bottom: 30px; 
            color: #333; }
        .input-group { 
            position: relative; 
            text-align: left; 
            margin-bottom: 20px; }
        label { 
            display: block; 
            margin-bottom: 5px; 
            color: #555; 
            font-weight: bold; }

        .form-input { 
            width: 100%; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            box-sizing: border-box; 
            font-size: 16px; 
        }
        input:focus { 
            outline: none; 
            border-color: #2575fc; 
            box-shadow: 0 0 8px rgba(37, 117, 252, 0.3); }

        .toggle-password { 
            position: absolute; 
            top: 43px; 
            right: 15px; 
            color: #999; 
            cursor: pointer; 
            width: 20px; 
            text-align: center; }
        
        .forgot-password {
            display: block;
            text-align: left;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .forgot-password a {
            color: #2575fc;
            text-decoration: none;
        }

        button { width: 100%; padding: 12px; border: none; border-radius: 5px; 
            background-color: #6a11cb; color: white; font-size: 16px; font-weight: bold; 
            cursor: pointer; transition: background-color 0.3s, transform 0.2s; }
        button:hover { background-color: #5a0fb1; transform: translateY(-2px); }
        .register-link { margin-top: 20px; font-size: 14px; }
        .register-link a { color: #2575fc; text-decoration: none; }
        .error { color: #e74c3c; background-color: #fdd; padding: 10px; 
        border-radius: 5px; margin-bottom: 15px; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to 
        { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>User Login</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required class="form-input">
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required class="form-input">
                <i class="fas fa-eye-slash toggle-password" id="togglePassword"></i>
            </div>
            
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>

            <button type="submit">Login</button>
        </form>
        <p class="register-link">Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script>
        const toggleIcon = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (toggleIcon && passwordInput) {
            toggleIcon.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>

       