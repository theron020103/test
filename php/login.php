<!DOCTYPE html>
<html>
<head>
  <title>Users Logs</title>
  <link rel="stylesheet" type="text/css" href="css/Users.css">
  <script src="https://code.jquery.com/jquery-3.3.1.js"
          integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
          crossorigin="anonymous"></script>
  <script src="js/jquery-2.2.3.min.js"></script>
</head>
<body>
<?php include 'header.php'; ?> 
<main>
  <section>
    <h1 class="slideInDown animated">Login</h1>
    
      <form id="loginForm" method="POST" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 300px; margin: auto; font-family: 'Arial', sans-serif;">
    <label for="username" style="font-weight: bold; color: #333; margin-bottom: 8px; display: block;">Username:</label>
    <input type="text" id="username" name="username" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
    
    <label for="password" style="font-weight: bold; color: #333; margin-bottom: 8px; display: block;">Password:</label>
    <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
    
    <button type="submit" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">Login</button>
	<div id="loginMessage"></div>
</form>

    
  </section>
</main>
<script>
  $(document).ready(function(){
    $('#loginForm').on('submit', function(event){
      event.preventDefault();
      $.ajax({
        url: "login_process.php",
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          if (response.trim() == "success") {
            window.location.href = 'index.php';
          } else {
            $('#loginMessage').html(response);
          }
        }
      });
    });
  });
</script>
</body>
</html>
