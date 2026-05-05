<?php
session_start();

// --- 1. การตั้งค่าฐานข้อมูล ---
$host = "localhost";
$user = "root";      // ปกติ XAMPP คือ root
$pass = "";          // ปกติ XAMPP คือว่างไว้
$dbname = "vul_test"; // เปลี่ยนเป็นชื่อ DB ของคุณ

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $pass, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- 2. ส่วนการประมวลผลการ Login ---
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //$query = "SELECT id FROM users WHERE email = '" . $email . "' AND password = '" . $password . "'";

    $query = "SELECT id FROM users WHERE email = '$email' AND password = '$password'";

    echo ("query = " . $query);
//$query = "SELECT username, email FROM users WHERE id = 1 UNION SELECT username FROM users";
    $result = mysqli_query($conn, $query);

    $result = mysqli_query($conn, $query);

    // นับจำนวนแถวที่เจอ
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        echo "Login สำเร็จ! พบข้อมูล $count แถว";
        // ทำงานต่อ เช่น สร้าง Session
    } else {
        echo "Login ไม่สำเร็จ! Email หรือ Password ไม่ถูกต้อง";
    }
//$row = mysqli_fetch_assoc($result);

    // ใช้ Prepared Statement เพื่อป้องกัน SQL Injection
    //$stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    //$stmt->bind_param("s", $email);
    //$stmt->execute();
    //$result = $stmt->get_result();
    /*
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // ตรวจสอบรหัสผ่าน (ใช้ password_verify สำหรับรหัสที่ถูก hash)
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            
            // Login สำเร็จ (ในที่นี้ขอแสดงข้อความแทนการรีไดเรกต์)
            echo "<script>alert('เข้าสู่ระบบสำเร็จ!');</script>";
        } else {
            $error = "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        $error = "ไม่พบ Email นี้ในระบบ";
    }
    */
    //$stmt->close();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Login Single File</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 100%; max-width: 350px; }
        h2 { text-align: center; color: #333; }
        input { width: 100%; padding: 12px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .error-msg { color: #d9534f; background: #f2dede; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px; text-align: center; }
        .success-msg { color: #3c763d; background: #dff0d8; padding: 10px; border-radius: 5px; text-align: center; }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login</h2>

    <!-- แสดง Error ถ้ามี -->
    <?php if ($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- แสดงสถานะถ้า Login อยู่ -->
    <?php if (isset($_SESSION['user_id'])): ?>
        <div class="success-msg">
            คุณเข้าสู่ระบบอยู่ (<?php echo $_SESSION['user_email']; ?>)<br>
            <a href="?logout=1">ออกจากระบบ</a>
        </div>
    <?php else: ?>
        <form method="POST" action="">
            <label>Email</label>
            <input type="text" name="email" required placeholder="admin@example.com">
            
            <label>Password</label>
            <input type="text" name="password" required placeholder="123456">
            
            <button type="submit">Login</button>
        </form>
    <?php endif; ?>
</div>

<?php
// ส่วนของการ Logout แบบง่ายในไฟล์เดียว
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

</body>
</html>
