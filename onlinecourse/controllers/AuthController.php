<?php
class AuthController
{
    public function login()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $identifier = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                // Debug
                error_log("=== LOGIN DEBUG ===");
                error_log("Identifier: " . $identifier);
                error_log("Password: " . $password);

                $userModel = new User();
                $user = $userModel->findByEmailOrUsername($identifier);

                // Debug
                error_log("User found: " . ($user ? 'YES' : 'NO'));
                if ($user) {
                    error_log("User data: " . print_r($user, true));
                    error_log("Role: " . $user['role']);
                }

                if ($user && password_verify($password, $user['password'])) {
                    // Debug
                    error_log("Password verification SUCCESS!");
                    
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_role'] = (int)$user['role'];
                    $_SESSION['user_name'] = $user['fullname'];
                    $_SESSION['user_email'] = $user['email'];
                    
                    // Debug session
                    error_log("Session set: " . print_r($_SESSION, true));
                
                // Chuyển hướng theo vai trò
                if ((int)$user['role'] === 0) {
                    // Học viên
                    header('Location: /onlinecourse/onlinecourse/index.php?controller=Student&action=dashboard');
                } elseif ((int)$user['role'] === 1) {
                    // Giảng viên
                    header('Location: /onlinecourse/onlinecourse/index.php?controller=Instructor&action=dashboard');
                } else {
                    // Admin
                    header('Location: /onlinecourse/onlinecourse/index.php?controller=Admin&action=dashboard');
                }
                exit;
            } else {
                    // Debug
                    if ($user) {
                        error_log("Password verification FAILED for user: " . $user['email']);
                        error_log("Input password: " . $password);
                        error_log("Stored hash: " . $user['password']);
                    } else {
                        error_log("User not found: " . $identifier);
                    }
                    $error = 'Email/Tài khoản hoặc mật khẩu không đúng';
                }
            } catch (Exception $e) {
                $error = 'Lỗi kết nối database: ' . $e->getMessage();
            }
        }

        $pageTitle = 'Đăng nhập';
        require __DIR__ . '/../views/auth/login.php';
    }

    public function register()
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $fullname = trim($_POST['fullname'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm) {
                $error = 'Mật khẩu nhập lại không khớp';
            } elseif ($username === '' || $email === '' || $fullname === '' || $password === '') {
                $error = 'Vui lòng nhập đầy đủ thông tin';
            } else {
                $userModel = new User();
                $existing = $userModel->findByEmailOrUsername($email);
                if ($existing) {
                    $error = 'Email đã được sử dụng';
                } else {
                    // Password validation
                    if (strlen($password) < 8) {
                        $error = 'Mật khẩu phải có ít nhất 8 ký tự!';
                    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $password)) {
                        $error = 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường và 1 số!';
                    } else {
                        $hash = password_hash($password, PASSWORD_ARGON2ID, ['memory_cost' => 65536, 'time_cost' => 4, 'threads' => 3]);
                        $created = $userModel->create([
                            'username' => $username,
                            'email' => $email,
                            'fullname' => $fullname,
                            'password' => $hash,
                            'role' => 0,
                        ]);
                    if ($created) {
                        header('Location: index.php?controller=Auth&action=login&success=registered');
                        exit;
                    } else {
                        $error = 'Không thể tạo tài khoản';
                    }
                    }
                }
            }
        }

        $pageTitle = 'Đăng ký';
        require __DIR__ . '/../views/auth/register.php';
    }

    public function profile()
    {
        $pageTitle = 'Hồ sơ cá nhân';
        require __DIR__ . '/../views/auth/profile.php';
    }

    public function forgot_password()
    {
        $pageTitle = 'Quên mật khẩu';
        require __DIR__ . '/../views/auth/forgot_password.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /onlinecourse/onlinecourse/views/coursera/index.php');
        exit;
    }
}
