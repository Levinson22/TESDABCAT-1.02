<?php
/**
 * Login Page
 * TESDA-BCAT Grade Management System
 */

require_once 'config/database.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

startSession();

// Redirect if already logged in
if (isLoggedIn()) {
    $role = getCurrentUserRole();
    header("Location: $role/dashboard.php");
    exit();
}

// Handle login form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    }
    else {
        $user = authenticateUser($username, $password);

        if ($user) {
            createUserSession($user);
            header("Location: {$user['role']}/dashboard.php");
            exit();
        }
        else {
            $error = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo APP_NAME; ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="BCAT logo 2024.png" type="image/png">
    
    <style>
        :root {
            --primary-indigo: #1a3a5c;
            --secondary-indigo: #0f2a47;
            --accent-indigo: #5b8db8;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }
        
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('bcat updated.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
            overflow-x: hidden;
        }
        
        .login-container {
            max-width: 480px;
            width: 100%;
            padding: 24px;
            perspective: 1000px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: cardFloat 1.2s ease-out;
            transition: transform 0.3s ease;
        }

        @keyframes cardFloat {
            0% { opacity: 0; transform: translateY(40px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--primary-indigo), var(--secondary-indigo));
            color: white;
            padding: 48px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0; left: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
        
        .login-header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        
        .login-header p {
            margin: 0;
            font-size: 0.875rem;
            opacity: 0.8;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        .login-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 700;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }
        
        .input-group {
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--primary-indigo);
            background: white;
            box-shadow: 0 10px 25px -10px rgba(26, 58, 92, 0.2);
            transform: translateY(-2px);
        }
        
        .input-group-text {
            background-color: transparent;
            border: none;
            padding-left: 1.25rem;
            color: var(--primary-indigo);
            opacity: 0.7;
        }
        
        .form-control {
            border: none;
            background: transparent;
            padding: 0.875rem 1rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .form-control:focus {
            box-shadow: none;
            background: transparent;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1a3a5c, #0f2a47);
            border: none;
            padding: 1rem;
            font-weight: 700;
            border-radius: 1rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-size: 0.9rem;
            margin-top: 1rem;
            box-shadow: 0 10px 20px -10px rgba(26, 58, 92, 0.5);
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -10px rgba(26, 58, 92, 0.6);
            background: linear-gradient(135deg, #0f2a47, #071828);
        }
        
        .tesda-logo-wrap {
            width: 90px;
            height: 90px;
            margin: 0 auto 1.5rem;
            background: white;
            border-radius: 2rem;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        .tesda-logo-wrap img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="tesda-logo-wrap">
                    <img src="BCAT logo 2024.png" alt="TESDA Logo">
                </div>
                <h1><?php echo APP_NAME; ?></h1>
                <p>Grade Management System</p>
            </div>
            
            <div class="login-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-radius: 1rem; background: rgba(231, 76, 60, 0.1); color: #c0392b;">
                        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php
endif; ?>
                
                <?php echo getFlashMessage(); ?>
                
                <form method="POST" action="">
                    <div class="mb-4">
                        <label for="username" class="form-label">Account Username</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user-circle"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   id="username" 
                                   name="username" 
                                   placeholder="Enter your ID or username"
                                   required 
                                   autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Secure Password</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-shield-alt"></i>
                            </span>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password"
                                   required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-login w-100 mb-4">
                        Login to Portal <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                    
                    <div class="text-center">
                        <small class="text-muted fw-500">
                            <i class="fas fa-headset me-1 text-primary"></i> 
                            Need help? Contact system administrator
                        </small>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-4 footer-text">
            <small>
                &copy; <?php echo date('Y'); ?> TESDA-BCAT Grade Management System<br>
                <span class="opacity-75">Advanced Portal Version <?php echo APP_VERSION; ?></span>
            </small>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
