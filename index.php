<!DOCTYPE html>
<html>
<head>
  <title>Classes</title>
  <link rel="stylesheet" type="text/css" href="css/Users.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(window).on("load resize ", function() {
      var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
      $('.tbl-header').css({'padding-right':scrollWidth});
    }).resize();
  </script>
</head>
<body>
<?php 
  // Start session if not already started
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
?> 
<?php include 'header.php'; ?> 
<main>
  <section>
    <!-- Class table -->
    <h1 class="slideInDown animated">YOUR CLASSES</h1>
    <div class="tbl-header slideInRight animated">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Name</th>
            <th>Subject</th>
			<th></th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content slideInRight animated">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody>
          <?php
            // Connect to database
            require 'connectDB.php';
            
            // Check if the user is logged in
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];

                // Prepare and execute SQL query to get teacherId of the logged-in teacher
                $sql_teacher = "SELECT TeacherID FROM accounts WHERE acc = ?";
                $stmt_teacher = $conn->prepare($sql_teacher);
                $stmt_teacher->bind_param("s", $username);
                $stmt_teacher->execute();
                $result_teacher = $stmt_teacher->get_result();

                if ($result_teacher->num_rows > 0) {
                    $teacher = $result_teacher->fetch_assoc();
                    $teacherId = $teacher['TeacherID'];

                    // Prepare and execute SQL query to get classes taught by the logged-in teacher
                    $sql = "SELECT c.ClassID, c.ClassName, s.SubjectName
            FROM Classes c
            JOIN Subjects s ON c.SubjectID = s.SubjectID
            WHERE c.TeacherID = ? ORDER BY ClassName DESC";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $teacherId);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $index = 1; // Initialize the index for numbering
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $index++ . '</td>';
                            echo '<td>' . htmlspecialchars($row['ClassName']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['SubjectName']) . '</td>';
							echo '<td><a href="view_class.php?id=' . $row['ClassID'] . '">View</a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="3">Không có lớp học nào</td></tr>';
                    }

                    $stmt->close();
                } else {
                    echo '<tr><td colspan="3">Không tìm thấy giáo viên</td></tr>';
                }

                $stmt_teacher->close();
            } else {
                echo '<tr><td colspan="3">Vui lòng đăng nhập để xem danh sách lớp học</td></tr>';
            }

            $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </section>
</main>
</body>
</html>
