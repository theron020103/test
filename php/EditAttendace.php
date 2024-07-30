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
  <script>
    function loadStudents() {
      var xhr = new XMLHttpRequest();
      var classID = "<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>";
      xhr.open("GET", "loadStudents.php?id=" + classID, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById("studentTableBody").innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    function saveAttendance() {
      var xhr = new XMLHttpRequest();
      var classID = "<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>";
      xhr.open("POST", "saveAttendance.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      var attendanceData = [];
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      checkboxes.forEach(function(checkbox) {
        attendanceData.push({
          enrollmentID: checkbox.value,
          status: checkbox.checked ? 'Present' : 'Absent'
        });
      });

      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          alert(xhr.responseText);
        }
      };

      xhr.send("attendance=" + JSON.stringify(attendanceData));
    }

    window.onload = function() {
      loadStudents();
    };
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
    <button type="button" onclick="saveAttendance()">Lưu</button>
  </section>
</main>
</body>
</html>
