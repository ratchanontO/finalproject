<?php
include 'connectdb.php';
require "head.php";
session_start();
$login_error = false;
if ($login_error) {

}
if (isset($_POST['username']) && isset($_POST['password'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($_POST['password'], $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            echo ($_SESSION['username']);
            // header("Location: index.php");
            exit;
        } else {
            $login_error = true;
        }
    } else {
        $login_error = true;
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
                    <h3 class="text-center mb-4">เข้าสู่ระบบ</h3>
                    <hr>
                    <form action="login.php" method="POST">
                        <!-- <div class="mb-3">
                            <label for="username" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" placeholder="Username" id="username" name="username" required>
                        </div> -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" placeholder="Username" name="username" required>
                        </div>
                        <!-- <div class="mb-3">
                            <label for="password" class="form-label">รหัสผ่าน</label>
                            <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        </div> -->
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                        <?php if ($login_error): ?>
                            <a>ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง</a>
                        <?php endif; ?>
                        <button type="submit" class="btn btn-success w-100">เข้าสู่ระบบ</button>
                    </form>
                    <p class="text-center mt-3">ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>