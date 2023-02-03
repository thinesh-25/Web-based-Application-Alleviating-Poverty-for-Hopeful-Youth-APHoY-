<?php

    // $conn = mysqli_connect('localhost','root','','cat304');

    $conn = new mysqli('localhost','root','','cat304');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
