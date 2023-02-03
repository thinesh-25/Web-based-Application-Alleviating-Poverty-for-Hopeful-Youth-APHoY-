<?php

session_start();
ini_set('file_uploads', 'On');
include 'config.php';

$staff_student_id = $_SESSION['staff_student_id'];
$donation_id = $_POST["donation-id"];

if (isset($_POST["submit-btn"])) {

    $target_dir = "./Proof/";
    $target_file = $target_dir . "(" . rand() . ") " . basename($_FILES["user_proof"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["user_proof"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if (
        $_FILES["user_proof"]["size"] > 500000
    ) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["user_proof"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["user_proof"]["name"])) . " has been uploaded.";

            $sql = "UPDATE donation SET `status`='Approved', proof='$target_file', donors_id = $staff_student_id WHERE donation_id='$donation_id'";
            $select_query = "SELECT mycsd FROM registration where staff_student_id = $staff_student_id";
            $result = mysqli_query($conn, $select_query);
            $count = mysqli_fetch_assoc($result)["mycsd"];
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                $count = $count + 5;
                echo $count;
                $insert = "UPDATE registration SET mycsd=$count where staff_student_id = $staff_student_id";
                mysqli_query($conn, $insert);
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            header("location: Donation.php");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else if (isset($_POST["withdraw-btn"])) {

    $sql = "UPDATE donation SET `status`='Pending' WHERE donation_id='$donation_id'";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("location: Donation.php");
} else if (isset($_POST["accept-btn"])) {

    $sql = "UPDATE donation SET `status`='Accepted', donors_id = $staff_student_id WHERE donation_id='$donation_id'";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("location: Donation.php");
}
