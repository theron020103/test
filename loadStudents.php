<?php
require 'connectDB.php';

if (isset($_GET['id'])) {
    // Lấy class ID từ tham số query
    $classID = $_GET['id'];
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $currentDate = date('Y-m-d');

    if (isset($_GET['node'])) {
        // Cập nhật trạng thái 'Present' cho những người dùng có trong user_logs và enrollments
        $updateSql = "
            UPDATE Attendance a
            JOIN Enrollments e ON a.EnrollmentID = e.EnrollmentID
			JOIN Users u ON e.UserID = u.id
            JOIN users_logs ul ON ul.fingerprint_id = u.fingerprint_id  -- Giả định cột UserID trong bảng Enrollments
            SET a.Status = 'Present'
            WHERE e.ClassID = ? AND a.AttendanceDate = ? AND ul.checkindate = ?
        ";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("iss", $classID, $currentDate, $currentDate);
        $updateStmt->execute();
        $updateStmt->close();

        // Xóa tất cả các bản ghi từ user_logs của ngày hiện tại
        $deleteSql = "DELETE FROM users_logs WHERE checkindate = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("s", $currentDate);
        $deleteStmt->execute();
        $deleteStmt->close();
    }

    // Thêm người dùng chưa có trong bảng attendance với trạng thái 'Absent'
    $absentSql = "
        INSERT INTO Attendance (AttendanceDate, EnrollmentID, Status)
        SELECT ?, e.EnrollmentID, 'Absent'
        FROM Enrollments e
        LEFT JOIN Attendance a ON e.EnrollmentID = a.EnrollmentID AND a.AttendanceDate = ?
        WHERE e.ClassID = ? AND a.EnrollmentID IS NULL
    ";
    $absentStmt = $conn->prepare($absentSql);
    $absentStmt->bind_param("ssi", $currentDate, $currentDate, $classID);
    $absentStmt->execute();
    $absentStmt->close();

    // Lấy và hiển thị các bản ghi điểm danh
    $sql = "SELECT u.id, u.username, a.Status AS attendance_status
            FROM Enrollments e
            JOIN Users u ON e.UserID = u.id
            LEFT JOIN Attendance a ON e.EnrollmentID = a.EnrollmentID AND a.AttendanceDate = ?
            WHERE e.ClassID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $currentDate, $classID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $index = 1; // Khởi tạo chỉ số cho việc đánh số
        while ($row = $result->fetch_assoc()) {
            $checked = ($row['attendance_status'] == 'Present') ? 'checked' : '';
            echo '<tr>';
            echo '<td>' . $index++ . '</td>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td><label class="checkbox-label"><input type="checkbox" name="student[]" value="' . $row['id'] . '" ' . $checked . '><span class="custom-checkbox"></span></label></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">Không có sinh viên nào trong lớp này</td></tr>';
    }

    $stmt->close();
} else {
    echo '<tr><td colspan="5">Không có ID lớp học</td></tr>';
}

$conn->close();
?>
