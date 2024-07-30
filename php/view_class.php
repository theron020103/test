<!DOCTYPE html>
<html>
<head>
  <title>Class Students</title>
  <link rel="stylesheet" type="text/css" href="css/Users.css">
  <style>
    /* Hide the default checkbox */
    input[type="checkbox"] {
      display: none;
    }

    /* Create a custom checkbox */
    .custom-checkbox {
      display: inline-block;
      width: 25px;
      height: 25px;
      background-color: #f0f0f0;
      border-radius: 5px;
      border: 2px solid #ddd;
      position: relative;
      cursor: pointer;
      margin-right: 10px;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .custom-checkbox::after {
      content: "";
      position: absolute;
      display: none;
      left: 9px;
      top: 5px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      transform: rotate(45deg);
    }

    /* Show the checkmark/indicator when checked */
    input[type="checkbox"]:checked + .custom-checkbox::after {
      display: block;
    }

    /* Change background color when checked */
    input[type="checkbox"]:checked + .custom-checkbox {
      background-color: #007bff;
      border-color: #007bff;
    }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#submitButton").click(function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của form (không tải lại trang)
        var classID = $("#classID").val(); // Lấy giá trị từ input có id là classID

        // Gửi dữ liệu đến getdata.php sử dụng AJAX
        $.ajax({
          url: 'getdata.php',
          type: 'post',
          data: {classID: classID},
          success: function(response) {
            // Xử lý phản hồi từ server ở đây
            alert('Data Sent: ' + response);
          },
          error: function() {
            alert('Error sending data');
          }
        });
      });
    });
  </script>

  <script>
    function loadStudents() {
      var xhr = new XMLHttpRequest();
      var classID = "<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>";
      var node = "<?php echo isset($_GET['node']) ? $_GET['node'] : ''; ?>";
      xhr.open("GET", "loadStudents.php?id=" + classID + "&node=" + node, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("studentTableBody").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    setInterval(loadStudents, 3000); // Refresh every 3 seconds
  </script>
</head>
<body>
<?php 
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
?>
<?php include 'header.php'; ?>
<main>
  <section>
    <a href="UsersLog.php" style="display: block; width: 200px; text-align: center; margin: 0 auto; padding: 10px; border: 1px solid #ccc; text-decoration: none; color: #333;">ATTENDANCE LIST</a>
    <a href="EditAttendace.php?id=<?php echo $_GET['id']; ?>" style="display: block; width: 200px; text-align: center; margin: 0 auto; padding: 10px; border: 1px solid #ccc; text-decoration: none; color: #333;">EDIT</a>
    <!-- Student table -->
    <?php
      require 'connectDB.php';

      if (isset($_GET['id'])) {
          $classID = $_GET['id'];
          
          $sql = "SELECT ClassName FROM Classes WHERE ClassID = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $classID);
          $stmt->execute();
          $result = $stmt->get_result();
          
          if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              echo '<h1 class="slideInDown animated">STUDENTS IN ' . htmlspecialchars($row['ClassName']) . '</h1>';
          } else {
              echo '<tr><td colspan="5">Không tìm thấy lớp học</td></tr>';
          }
          $stmt->close();
      } else {
          echo '<tr><td colspan="5">Không có ID lớp học</td></tr>';
      }

      $conn->close();
    ?>

    <div class="tbl-header slideInRight animated">
      <table cellpadding="0" cellspacing="0" border="0">
        <thead>
          <tr>
            <th>No</th>
            <th>Student Code</th>
            <th>Student Name</th>
            <th>Check</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="tbl-content slideInRight animated">
      <table cellpadding="0" cellspacing="0" border="0">
        <tbody id="studentTableBody">
          <!-- Student data will be loaded here -->
        </tbody>
      </table>
    </div>
  </section>
</main>
</body>
</html>
