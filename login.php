<?php
session_start();

$errorMessage = '';

if(isset($_POST['login'])){
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if(empty($username) || empty($password)){
        $errorMessage = 'Username and password are required.';
    } else {
        $file = fopen("user.txt","r");
        $found = false;

        if($file){
            while(!feof($file)){
                $line = fgets($file);
                if(empty(trim($line))) continue;
                $data = explode("|", $line);

                if(isset($data[0]) && isset($data[1])){
                    $data[0] = trim($data[0]);
                    $data[1] = trim($data[1]);
                    
                    if($data[0] === $username && $data[1] === $password){
                        $found = true;
                        $_SESSION['user'] = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
                        header("Location: dashboard.php");
                        exit();
                    }
                }
            }
            fclose($file);
        }

        if(!$found){
            $errorMessage = 'Invalid username or password.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In - EduPortal | Learning Management System</title>
<link rel="stylesheet" href="style.css">
<style>
    .login-wrapper {
        display: flex;
        height: 100vh;
        background: #fff;
    }

    .login-branding {
        flex: 1;
        background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 60px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .login-branding::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        top: -150px;
        right: -100px;
    }

    .login-branding::after {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        bottom: -100px;
        left: -50px;
    }

    .branding-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .university-logo {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #60a5fa 0%, #93c5fd 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 30px;
        font-size: 50px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .branding-content h1 {
        font-size: 42px;
        font-weight: 900;
        margin-bottom: 15px;
        letter-spacing: -1px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .branding-content .subtitle {
        font-size: 18px;
        color: #d1d5db;
        margin-bottom: 40px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    .branding-features {
        display: flex;
        flex-direction: column;
        gap: 20px;
        text-align: left;
        margin-top: 50px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .feature-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        backdrop-filter: blur(10px);
    }

    .feature-text h3 {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .feature-text p {
        font-size: 12px;
        color: #d1d5db;
    }

    .login-form-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .login-form-box {
        width: 100%;
        max-width: 420px;
    }

    .login-form-header {
        margin-bottom: 35px;
    }

    .login-form-header h2 {
        font-size: 32px;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 10px;
        letter-spacing: -0.5px;
    }

    .login-form-header p {
        font-size: 14px;
        color: #718096;
        font-weight: 500;
    }

    .login-form-content {
        background: white;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
    }

    .login-form-content .form-group {
        margin-bottom: 24px;
    }

    .login-form-content label {
        display: block;
        margin-bottom: 10px;
        color: #1a202c;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .login-form-content input {
        width: 100%;
        padding: 14px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }

    .login-form-content input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: white;
    }

    .login-form-content button {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(30, 64, 175, 0.3);
        letter-spacing: 0.5px;
    }

    .login-form-content button:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(30, 64, 175, 0.4);
    }

    .login-form-content button:active {
        transform: translateY(0);
    }

    .error-message {
        background: #fee;
        color: #c33;
        border-left: 4px solid #dc2626;
        border: 1px solid #fecaca;
        padding: 16px;
        margin-bottom: 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .signup-link {
        text-align: center;
        margin-top: 24px;
        font-size: 14px;
        color: #718096;
    }

    .signup-link a {
        color: #1e40af;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }

    .signup-link a:hover {
        color: #1e3a8a;
        text-decoration: underline;
    }

    @media (max-width: 1024px) {
        .login-branding {
            flex: 0.8;
            padding: 40px;
        }

        .login-form-container {
            flex: 1.2;
            padding: 40px;
        }

        .branding-content h1 {
            font-size: 32px;
        }

        .university-logo {
            width: 80px;
            height: 80px;
            font-size: 40px;
        }
    }

    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
            height: auto;
        }

        .login-branding {
            min-height: 300px;
            padding: 40px 30px;
        }

        .login-form-container {
            padding: 40px 20px;
        }

        .login-form-box {
            max-width: 100%;
        }

        .branding-features {
            display: none;
        }

        .branding-content h1 {
            font-size: 28px;
        }

        .branding-content .subtitle {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .login-branding {
            padding: 30px 20px;
            min-height: 250px;
        }

        .login-form-container {
            padding: 30px 15px;
        }

        .login-form-content {
            padding: 25px;
        }

        .university-logo {
            width: 70px;
            height: 70px;
            font-size: 35px;
        }

        .branding-content h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .login-form-header h2 {
            font-size: 24px;
        }
    }
</style>
</head>
<body>
<div class="login-wrapper">
    <!-- Branding Section -->
    <div class="login-branding">
        <div class="branding-content">
            <div class="university-logo">🎓</div>
            <h1>EduPortal</h1>
            <p class="subtitle">Learning Management System</p>

            <div class="branding-features">
                <div class="feature-item">
                    <div class="feature-icon">📚</div>
                    <div class="feature-text">
                        <h3>Interactive Learning</h3>
                        <p>Engage with dynamic course materials</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">👥</div>
                    <div class="feature-text">
                        <h3>Collaborate</h3>
                        <p>Connect with instructors and peers</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon">📈</div>
                    <div class="feature-text">
                        <h3>Track Progress</h3>
                        <p>Monitor your academic performance</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="login-form-container">
        <div class="login-form-box">
            <div class="login-form-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your account to continue learning</p>
            </div>

            <div class="login-form-content">
                <?php if(!empty($errorMessage)): ?>
                    <div class="error-message">
                        <span>⚠️</span>
                        <span><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="current-password">
                    </div>

                    <button type="submit" name="login">🔐 Sign In</button>
                </form>

                <div class="signup-link">
                    Don't have an account? <a href="create.php">Create one here</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
