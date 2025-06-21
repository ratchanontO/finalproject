<?php
include 'connectdb.php';
require "head.php";
function isValidUsername($username)
{
    return preg_match('/^[a-zA-Z0-9]+$/', $username);
}

$error_password = false;
$error_register = false;
$error_email = false;
$error_username = false;
$success = false;

if (!empty($_POST["username"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $email = $_POST["email"];
    $time = date("Y-m-d H:i:s");
    if (isValidUsername($username)) {
        if ($password == $confirmpassword) {
            $hash_password = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));
            // เริ่มลงdb
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? or email = ?");
            $stmt->bind_param("ss", $username, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error_register = true;
            } else {
                $insert = $conn->prepare("INSERT INTO users (username, password, email, token, created_at ) VALUES (?, ?, ?, ?, ?)");
                $insert->bind_param("sssss", $username, $hash_password, $email, $token, $time);
                $insert->execute();
                $success = true;
            }
        } else {
            $error_password = true;
        }
    } else {
        $error_username = true;
    }
}
?>

<style>
    body {
        background: linear-gradient(to right, #74ebd5, #acb6e5);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        background-color: #fff;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #6c63ff;
    }
</style>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-card p-4">
                    <h3 class="text-center mb-4"> สมัครสมาชิก </h3>
                    <hr>
                    <form action="register.php" method="POST">
                        <div class="mb-3">
                            <label for="username"> ชื่อผู้ใช้ </label>
                            <input type="text" class="form-control" placeholder="Username" id="username" name="username"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="password"> รหัสผ่าน </label>
                            <input type="password" class="form-control" placeholder="password" id="password"
                                name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password"> ยืนยันรหัสผ่าน </label>
                            <input type="password" class="form-control" placeholder="confirmpassword"
                                id="confirmpassword" name="confirmpassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="email"> อีเมล </label>
                            <input type="email" class="form-control" placeholder="email" id="email" name="email"
                                required>
                        </div>
                        <?php
                        if ($error_register) {
                            echo "ชื่อผู้ใช้หรืออีเมลมีคนใช้งานไปแล้ว";
                        }
                        if ($error_password) {
                            echo "รหัสผ่านไม่ตรงกัน";
                        }
                        if ($error_username) {
                            echo "ชื่อผู้ใช้งานมีอักษรพิเศษ";
                        }
                        ?>
                        <div class="mb-2">
                            <button type="submit" class="btn btn-success w-100">สมัครสมาชิก</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">มีบัญชีแล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
                    <?php if ($success): ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'สมัครสมาชิกสำเร็จ!',
                                text: 'ระบบจะพาคุณไปหน้าถัดไป...',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                heightAuto: false          
                            })
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>