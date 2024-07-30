<!DOCTYPE html>
<html>
<head>
  <title>Users Logs</title>
  <link rel="stylesheet" type="text/css" href="css/userslog.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"
          integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
          crossorigin="anonymous"></script>
  <script src="js/jquery-2.2.3.min.js"></script>
  <script src="js/user_log.js"></script>
  <script>
    $(document).ready(function(){
        $.ajax({
          url: "user_log_up.php",
          type: 'POST',
          data: {
              'select_date': 1,
          }
        });
      setInterval(function(){
        $.ajax({
          url: "user_log_up.php",
          type: 'POST',
          data: {
              'select_date': 0,
          }
          }).done(function(data) {
            $('#userslog').html(data);
          });
      },3000);
    });
  </script>
</head>
<body>
<?php 
  // Start session if not already started
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
?> 
<?php include'header.php'; ?> 
<main>
  <section>
  <div class="form-style-5 slideInDown animated">
  		<form method="POST" action="Export_Excel.php">
  			<input type="date" name="date_sel" id="date_sel">
        <button type="button" name="user_log" id="user_log">Select Date</button>
  			<input type="submit" name="To_Excel" value="Export to Excel">
  		</form>
  	</div>
  <a href="view_class.php?id=<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>&node=1" style="display: block; width: 200px; text-align: center; margin: 0 auto; padding: 10px; border: 1px solid #ccc; text-decoration: none; color: #333;">BACK</a>

  <div class="tbl-header slideInRight animated">
    <table cellpadding="0" cellspacing="0" border="0">
      <thead>
        <tr>
		  <th>No</th>
          <th>ID</th>
          <th>Name</th>
          <th>Time in</th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="tbl-content slideInRight animated">
    <div id="userslog"></div>
  </div>
</section>
</main>
</body>
</html>
