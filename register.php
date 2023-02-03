<?php

@include 'config.php';

if(isset($_POST['submit2'])){
   $income;
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $staff_student_id = intval($_POST['staff_student_id']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
      if (!preg_match("/^[a-zA-Z0-9._%+-]+@(student\.)?usm.my$/", $email)) {
      echo "Invalid email format. Must be @student.usm.my or @usm.my";
      exit;
      }

   $nric = mysqli_real_escape_string($conn, $_POST['nric']);
   $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
   $gender = mysqli_real_escape_string($conn, $_POST['gender']);
   $school = mysqli_real_escape_string($conn, $_POST['school']);
   $job_status = mysqli_real_escape_string($conn, $_POST['job_status']);
   $income = mysqli_real_escape_string($conn, $_POST['income']);
   //$pass = md5($_POST['pass']);
   $pass = mysqli_real_escape_string($conn, $_POST['pass']);
   //$cpass = md5($_POST['cpass']);
   $cpass = mysqli_real_escape_string($conn, $_POST['cpass']);
   $mycsd = 0;

   $select = " SELECT * FROM registration WHERE email = '$email' && pass = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      //$error[] = 'user already exist!';
      echo "user already exist";

   }else{

      if($pass != $cpass){
         //$error[] = 'password not matched!';
         echo 'password not matched!';
      }else{
         $insert = "INSERT INTO registration(name, staff_student_id, email, nric, contact_number, gender, school,
         job_status, income, pass, mycsd) VALUES('$name','$staff_student_id','$email', '$nric', '$contact_number', '$gender',
          '$school', '$job_status', '$income', '$pass', '$mycsd')";
         mysqli_query($conn, $insert);
         header("Location: home.html");
      }

   }

};

?>