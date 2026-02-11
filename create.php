<?php
session_start();

$successMessage = '';
$errorMessage = '';

if(isset($_POST['create'])){
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirm_password'] ?? '');

    if(empty($username) || empty($password) || empty($confirmPassword)){
        $errorMessage = 'All fields are required.';
    } elseif(strlen($password) < 6){
        $errorMessage = 'Password must be at least 6 characters long.';
    } elseif($password !== $confirmPassword){
        $errorMessage = 'Passwords do not match.';
    } else {
        $file = fopen("user.txt","r");
        $found = false;

        if($file){
            while(!feof($file)){
                $line = fgets($file);
                if(empty(trim($line))) continue;
                $data = explode("|", $line);
                
                if(isset($data[0]) && trim($data[0]) === $username){
                    $found = true;
                    break;
                }
            }
            fclose($file);
        }

        if($found){
            $errorMessage = 'Username already exists. Please choose another.';
        } else {
            $file = fopen("user.txt","a");
            if($file){
                fwrite($file, htmlspecialchars($username, ENT_QUOTES, 'UTF-8') . "|" . htmlspecialchars($password, ENT_QUOTES, 'UTF-8') . "\n");
                fclose($file);
                $successMessage = 'Account created successfully! Redirecting to login...';
                header("refresh:2;url=login.php");
            } else {
                $errorMessage = 'Unable to create account. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Account - EduPortal | Learning Management System</title>
<link rel="stylesheet" href="style.css">
<style>
    .login-wrapper {
        display: flex;
        height: 100vh;
        background: #fff;
    }

    .login-branding {
        flex: 1;
        background: linear-gradient(135deg, #059669 0%, #047857 50%, #10b981 100%);
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
        background: linear-gradient(135deg, #34d399 0%, #6ee7b7 100%);
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

    .login-form-container {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px;
        background: linear-gradient(135deg, #f0fdf4 0%, #f0f9ff 100%);
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
        font-family: inherit;
    }

    .login-form-content input:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: white;
    }

    .login-form-content button {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
        letter-spacing: 0.5px;
    }

    .login-form-content button:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(5, 150, 105, 0.4);
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

    .success-message {
        background: #f0fdf4;
        color: #15803d;
        border-left: 4px solid #22c55e;
        border: 1px solid #86efac;
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
        color: #059669;
        text-decoration: none;
        font-weight: 700;
        transition: color 0.3s;
    }

    .signup-link a:hover {
        color: #047857;
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
            <div class="university-logo">✨</div>
            <h1>Join EduPortal</h1>
            <p class="subtitle">Begin Your Learning Adventure</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="login-form-container">
        <div class="login-form-box">
            <div class="login-form-header">
                <h2>Create Account</h2>
                <p>Get started with your learning journey today</p>
            </div>

            <div class="login-form-content">
                <?php if(!empty($successMessage)): ?>
                    <div class="success-message">
                        <span>✅</span>
                        <span><?php echo htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(!empty($errorMessage)): ?>
                    <div class="error-message">
                        <span>⚠️</span>
                        <span><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Choose a unique username" required autocomplete="username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Minimum 6 characters" required autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required autocomplete="new-password">
                    </div>

                    <button type="submit" name="create">✨ Create My Account</button>
                </form>

                <div class="signup-link">
                    Already have an account? <a href="login.php">Sign in here</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
