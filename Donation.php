<?php
session_start();
include 'config.php';
ini_set('file_uploads', 'On');
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>APHoY</title>
    <link rel="icon" type="image/png" href="logov_2.svg">
    <link rel="stylesheet" href="Donation.css">
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
        <h1 class="modal-title" id="myModalLabel">My Task</h1>
        <section>
            <?php
            // query to the database
            $sql = "SELECT * FROM donation d JOIN registration r ON r.staff_student_id=d.receivers_id WHERE d.status='Accepted'";
            // result of the query
            $result = $conn->query($sql) or die($conn->error);

            if ($result !== false && $result->num_rows > 0) {
                echo '
                            <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Bank Name</th>
                                        <th>Bank Account</th>
                                        <th>Proof</th>
                                        <th>Action</th>
                                        <th>Withdraw</th>
                                    </tr>
                                </thead>
                            <tbody>';

                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr>
                        <form action="submit-donation.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="donation-id" value="<?php echo $row["donation_id"] ?>">
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo "<a href='https://api.whatsapp.com/send?phone=" . $row["contact_number"] . "' target='_blank'>Click Here to WhatsApp Link</a>"; ?></td>
                            <td><?php echo $row["bank_name"]; ?></td>
                            <td><?php echo $row["bank_account_number"]; ?></td>
                            <td><input type="file" id="proof" name="user_proof"></td>
                            <td><button type="submit" name="submit-btn">Submit</button></td>
                            <td><button type="submit" name="withdraw-btn">Withdraw</button></td>
                        </form>
                    </tr>
            <?php
                }

                echo '</tbody>
                        </table>';
            } else {
                echo "<p style='text-align: center; color: red;'>No Results</p>";
            }
            ?>

        </section>
        <?php

        ?>
        <div>
            <h1 class="modal-title" id="myModalLabel">Donation Approval</h1>
            <section>
                <?php
                // query to the database
                $sql = "SELECT * FROM donation d JOIN registration r ON r.staff_student_id=d.receivers_id WHERE d.status='Pending';";
                // result of the query
                $result = $conn->query($sql) or die($conn->error);

                if ($result !== false && $result->num_rows > 0) {
                    echo '<table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Request</th>
                                    <th>(MYR) Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        <tbody>';

                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <form action="submit-donation.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="donation-id" value="<?php echo $row["donation_id"] ?>">
                                <td><?php echo $row["name"]; ?></td>
                                <td><?php echo $row["item"]; ?></td>
                                <td>
                                    <?php if ($row["amount"] === 0) {
                                        echo "NA";
                                    } else {
                                        echo $row["amount"];
                                    } ?>
                                </td>
                                <td><button type="submit" name="accept-btn">Accept</button></td>
                            </form>
                        </tr>
                <?php
                    }

                    echo '</tbody>
                        </table>';
                } else {
                    echo "<p style='text-align: center; color: red;'>No Results</p>";
                }
                ?>




            </section>
        </div>
        <div class="bottom-bar">CAT 304: Web Development @APHoY</div>
    </div>

</body>

</html>