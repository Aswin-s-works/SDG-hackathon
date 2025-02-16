<?php 
  session_start(); 
  include('db_connect.php'); // Include database connection

  if (!isset($_SESSION['username'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: login.php');
      exit();
  }

  if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['username']);
      unset($_SESSION['email']);
      unset($_SESSION['role']);
      header("location: login.php");
      exit();
  }

  // Fetch user details from database
  $username = $_SESSION['username'];
  $query = "SELECT email, role FROM users WHERE username='$username'";
  $result = mysqli_query($db, $query);
  
  if ($result && $row = mysqli_fetch_assoc($result)) {
      $_SESSION['email'] = $row['email'];
      $_SESSION['role'] = $row['role'];
  } else {
      $_SESSION['email'] = 'Not Available';
      $_SESSION['role'] = 'Not Set';
  }

  // Handle Role Selection with Staff Password Verification
  if (isset($_POST['update_role'])) {
      $role = $_POST['role'];
      
      if ($role == "staff") {
          $staff_password = $_POST['staff_password'];
          $correct_password = "secureStaff123"; // Set your staff password here

          if ($staff_password === $correct_password) {
              $_SESSION['role'] = "staff";
              $update_query = "UPDATE users SET role='staff' WHERE username='$username'";
              mysqli_query($db, $update_query);
              $_SESSION['message'] = "Role updated to Staff!";
          } else {
              $_SESSION['message'] = "Incorrect staff password!";
          }
      } else {
          $_SESSION['role'] = "student";
          $update_query = "UPDATE users SET role='student' WHERE username='$username'";
          mysqli_query($db, $update_query);
          $_SESSION['message'] = "Role updated to Student!";
      }
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Profile Page</h2>
    </div>
    <div class="content">
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>

        <?php if (isset($_SESSION['message'])) : ?>
            <div class="success">
                <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
            </div>
        <?php endif ?>

        <?php if (isset($_SESSION['username'])) : ?>
            <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
            <p>Email: <strong><?php echo $_SESSION['email']; ?></strong></p>
            <p>Role: <strong><?php echo $_SESSION['role']; ?></strong></p>
            
            <form method="post" action="profile.php">
                <label>Select Role:</label>
                <select name="role" id="role" onchange="checkStaffPassword()">
                    <option value="student">Student</option>
                    <option value="staff">Staff</option>
                </select>
                <div id="staff-password" style="display:none;">
                    <label>Enter Staff Password:</label>
                    <input type="password" name="staff_password">
                </div>
                <button type="submit" name="update_role">Update Role</button>
            </form>
            
            <p><a href="main.html" style="color: red;">Home</a></p>
        <?php endif ?>
    </div>

    <script>
        function checkStaffPassword() {
            var role = document.getElementById("role").value;
            var staffPasswordDiv = document.getElementById("staff-password");
            if (role === "staff") {
                staffPasswordDiv.style.display = "block";
            } else {
                staffPasswordDiv.style.display = "none";
            }
        }
    </script>
</body>
</html>
