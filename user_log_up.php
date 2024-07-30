<table cellpadding="0" cellspacing="0" border="0">
  <tbody>
    <?php
      session_start();
      // Connect to database
      require 'connectDB.php';

      // Set the default timezone to the correct one
      date_default_timezone_set('Asia/Ho_Chi_Minh');

      // Set the selected date to today
      $seldate = date("Y-m-d");


      // Prepare and execute the SQL query
      $sql = "SELECT * FROM users_logs WHERE checkindate='$seldate' ORDER BY id DESC";
      $result = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($result, $sql)) {
          echo '<p class="error">SQL Error</p>';
      } else {
          mysqli_stmt_execute($result);
          $resultl = mysqli_stmt_get_result($result);
          if (mysqli_num_rows($resultl) > 0) {
              $index = 1;
              while ($row = mysqli_fetch_assoc($resultl)) {
    ?>
                  <TR>
                      <TD><?php echo $index++; ?></TD>
                      <TD><?php echo $row['id']; ?></TD>
                      <TD><?php echo $row['username']; ?></TD>
                      <TD><?php echo $row['timein']; ?></TD>
                  </TR>
    <?php
              }
          } else {
              echo '<p>No logs found for today.</p>';
          }
      }
    ?>
  </tbody>
</table>
