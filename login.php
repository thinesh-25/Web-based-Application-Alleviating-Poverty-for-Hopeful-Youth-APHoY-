<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   #$name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   #$pass = md5($_POST['pass']);
   $pass = mysqli_real_escape_string($conn, $_POST['pass']);
   #$cpass = md5($_POST['cpass']);
   //$cpass = mysqli_real_escape_string($conn, $_POST['cpass']);
   $staff_student_id;
   $dbemail = "";
   $dbpassword = "";

   $select = " SELECT * FROM registration WHERE email = '$email' && pass = '$pass'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      while($row = $result->fetch_assoc()) {
         $staff_student_id = $row["staff_student_id"];
         $dbemail = $row["email"];
         $dbpassword = $row["pass"];
      }

     
   }else{

      echo "0 results";
   }

   $conn->close();

   // Compare the entered login credentials with the ones in the database
   if($email == $dbemail && $pass == $dbpassword) {
      echo "Login successful";
      session_start();
      $_SESSION['staff_student_id'] = $staff_student_id;
      header("Location: index.html"); // redirect to index.html
      exit();
   } else {
      echo "Login failed";
   }

};
?>