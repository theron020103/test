<?php
session_start();
include 'connectDB.php'; // Include file kết nối cơ sở dữ liệu

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Chuẩn bị câu lệnh SQL để tránh SQL Injection
    $sql = "SELECT * FROM Accounts WHERE acc = ? AND pass = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra kết quả truy vấn
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        echo "success"; // Trả về chuỗi "success" nếu đăng nhập thành công
    } else {
        echo "User không tồn tại hoặc mật khẩu không đúng"; // Trả về thông báo lỗi nếu đăng nhập thất bại
    }
    $stmt->close();
}

$conn->close(); // Đóng kết nối đến cơ sở dữ liệu
?>
