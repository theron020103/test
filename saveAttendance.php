<?php  
// Kết nối tới cơ sở dữ liệu
require 'connectDB.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attendance = json_decode($_POST['attendance'], true);
    
    foreach ($attendance as $record) {
        $enrollmentID = $record['enrollmentID'];
        $status = $record['status'];

        $sql = "UPDATE attendance SET Status = ? WHERE EnrollmentID = ? AND AttendanceDate = CURDATE()";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("si", $status, $enrollmentID);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Có lỗi xảy ra khi cập nhật điểm danh.";
            exit();
        }
    }
    
    echo "Cập nhật thành công!";
}

$conn->close();
?>
