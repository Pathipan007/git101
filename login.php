<?php
session_start();

// เชื่อมต่อกับฐานข้อมูล
$servername = "ชื่อเซิร์ฟเวอร์";
$username = "ชื่อผู้ใช้";
$password = "รหัสผ่าน";
$dbname = "ชื่อฐานข้อมูล";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า username และ password มาจากฟอร์ม
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ทำให้รหัสผ่านเป็นรูปแบบที่ปลอดภัย เช่น md5, sha256, หรือ bcrypt
    $hashed_password = md5($password);

    // สร้างคำสั่ง SQL เพื่อตรวจสอบข้อมูลในฐานข้อมูล
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashed_password'";
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลที่ตรงกันหรือไม่
    if ($result->num_rows > 0) {
        // ล็อกอินสำเร็จ
        $_SESSION['username'] = $username;
        echo "ล็อกอินสำเร็จ!";
    } else {
        // ล็อกอินไม่สำเร็จ
        echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง!";
    }
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn->close();
?>
