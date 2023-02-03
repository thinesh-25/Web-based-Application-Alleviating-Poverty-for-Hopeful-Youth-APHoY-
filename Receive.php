<?php

@include 'config.php';

if(isset($_POST['submit2'])){

    session_start();
    $staff_student_id = $_SESSION['staff_student_id'];
    $item =  mysqli_real_escape_string($conn, $_POST['item']);
    $amount = intval($_POST['amount']);
    $bank_name =  mysqli_real_escape_string($conn, $_POST['bank_name']);
    $bank_account_number = mysqli_real_escape_string($conn, $_POST['bank_account_number']);
    $select_query = "SELECT COUNT(*) FROM donation";
    $result = mysqli_query($conn, $select_query);
    $count = mysqli_fetch_assoc($result)["COUNT(*)"];

    if($count == 0){
        $donation_id = 1000;
    }
    
    else{
        $max_query = "SELECT MAX(donation_id) FROM donation";
        $result = mysqli_query($conn, $max_query);
        $max = mysqli_fetch_assoc($result)["MAX(donation_id)"];
        $donation_id = $max + 1;
     }

    $insert = "INSERT INTO donation(donation_id, receivers_id, item, amount, bank_name, bank_account_number, donors_id, status) VALUES('$donation_id','$staff_student_id','$item', '$amount', '$bank_name', '$bank_account_number', $staff_student_id, 'Pending')";

    
    mysqli_query($conn, $insert);
    header("Location: Receive.php");

};

?>

<!DOCTYPE html>
<head>
    <title>APHoY</title>
    <link rel="icon" type="image/png" href="logov_2.svg">
    <link rel = "stylesheet" href= "Receive.css">
    
</head>
<body>
    <div class="full-page">
      <div class="navbar">
        <div>
            <a href='home.html'>APHoY</a>
        </div>
        <nav>
            <ul id='MenuItems'>
                <li><a href='index.html'>Index</a></li>
                <li><a href='logout.php'>Logout</a></li>
            </ul>
        </nav>
      </div>
    
        <section>
        <table id="example" >
            
            <h1>Request Status</h1>
                    <thead>
                        <tr>
                            <th>Request Item</th>
                            <th>Status</th>
                            <th>Donor Name</th>
                            <th>Donor Contact</th>
                           <!-- <th>Action</th>-->
                            
                        </tr>
                    </thead>
                    <?php
                        session_start();
                        $staff_student_id = $_SESSION['staff_student_id'];
                        $select_query = "SELECT *
                        FROM donation
                        INNER JOIN registration
                        ON donation.donors_id = registration.staff_student_id";
                        $result = mysqli_query($conn, $select_query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if($row["donors_id"] == $row["receivers_id"]){
                                    echo "<tr>
                                    <td>" . $row["item"] . "</td>
                                    <td>" . $row["status"] . "</td>
                                    <td>" . "" . "</td>
                                    <td>" . "" . "</td>
                                </tr>";
                                }
                                else{
                                    echo "<tr>
                                        <td>" . $row["item"] . "</td>
                                        <td>" . $row["status"] . "</td>
                                        <td>" . $row["name"] . "</td>
                                        <td>" ."<a href='https://api.whatsapp.com/send?phone=" . $row["contact_number"] . "' target='_blank'>Click Here to WhatsApp Link</a>"; "</td>
                                    </tr>";
                                }
                            }
                        }
                        ?>
                    <tbody>
                    </tbody>
                </table>
            </section>        
                 
        <!--<div class = "column2">-->
            <section>
                <h1> My Application</h1>
                <form action="Receive.php" method="POST">

            <label>Requested Item : </label>
            <select id="type" name="item">
            <optgroup label="Application" class="dropdown">
            <option value="clothes">Clothes</option>
            <option value="money">Money</option>
            <option value="food">Food </option> 
            </br>
            </br>
            <label for="name">Requested Money Amount :</label>
            <input type="hidden" id="type" name="amount2">
            </br>
            </br>    
            <label for="name">Requested Money Amount :</label>
            <input type="text" id="rma" name="amount">
            </br>       
            <label for="ssid">Bank Name:</label>
            <input type="text" id="bname" name="bank_name">

            <label for="ssid">Bank Account Number:</label>
            <input type="text" id="bacc" name="bank_account_number">
                    
            <label for="ssid">Action:</label>
            <button type='submit' name = 'submit2' class='submit-btn'>Submit</button>
            </body>
            </form>
        
        </section>
        <div class="bottom-bar">CAT 304: Web Development @APHoY</div>   
    </div> 
</body>    
</html>
    <?php
    $conn->close();
    ?>  
