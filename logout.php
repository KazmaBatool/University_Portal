<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['yes'])){
    session_destroy();
    header("Location: login.php");
    exit();
}

if(isset($_POST['no'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm Logout - EduPortal | Learning Management System</title>
<div class="sidebar-footer">
    <!-- Logout Form -->
    <form method="POST" action="dashboard.php">
        <button type="submit" name="yes" class="action-btn logout-btn">🚪 Logout</button>
    </form>
</div>

<link rel="stylesheet" href="style.css">
<style>
    .logout-container {
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
        position: relative;
        overflow: hidden;
    }

    .logout-container::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        top: -150px;
        right: -100px;
        animation: float 6s ease-in-out infinite;
    }

    .logout-container::after {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
        bottom: -100px;
        left: -50px;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(20px); }
    }
    
    .logout-box {
        width: 100%;
        max-width: 500px;
        padding: 60px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        text-align: center;
        animation: slideUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        z-index: 1;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .logout-box h2 {
        font-size: 32px;
        font-weight: 800;
        color: #1a202c;
        margin-bottom: 12px;
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: -0.5px;
    }
    
    .logout-box p {
        color: #718096;
        font-size: 16px;
        margin-bottom: 30px;
        line-height: 1.6;
        font-weight: 500;
    }
    
    .logout-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
        border: 1px solid #fcd34d;
        padding: 18px;
        margin-bottom: 35px;
        border-radius: 12px;
        color: #78350f;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        line-height: 1.5;
    }

    .logout-warning-icon {
        font-size: 20px;
        flex-shrink: 0;
    }
    
    .logout-buttons {
        display: flex;
        gap: 18px;
        margin-top: 35px;
    }
    
    .logout-buttons button {
        flex: 1;
        padding: 14px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        letter-spacing: 0.5px;
    }
    
    .logout-buttons button[name="yes"] {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.35);
    }
    
    .logout-buttons button[name="yes"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(239, 68, 68, 0.5);
    }

    .logout-buttons button[name="yes"]:active {
        transform: translateY(0);
    }
    
    .logout-buttons button[name="no"] {
        background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
    }

    .logout-buttons button[name="no"]:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(59, 130, 246, 0.5);
    }

    .logout-buttons button[name="no"]:active {
        transform: translateY(0);
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 480px) {
        .logout-box {
            padding: 40px 25px;
            margin: 20px;
        }

        .logout-box h2 {
            font-size: 26px;
        }

        .logout-box p {
            font-size: 14px;
        }

        .logout-warning {
            padding: 14px;
            font-size: 13px;
        }

        .logout-buttons {
            gap: 12px;
        }

        .logout-buttons button {
            padding: 12px;
            font-size: 14px;
        }
    }
</style>
</head>
<body>
<div class="logout-container">
    <div class="logout-box">
        <h2>🚪 Confirm Logout</h2>
        <p>Are you sure you want to leave your learning session?</p>
        
        <div class="logout-warning">
            <span class="logout-warning-icon">⚠️</span>
            <span>You will be logged out from your account and need to sign in again to access your courses.</span>
        </div>
        
        <form method="POST" action="">
            <div class="logout-buttons">
                <button type="submit" name="yes" value="yes">🚪 Yes, Logout</button>
                <button type="submit" name="no" value="no">↩️ Cancel</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

