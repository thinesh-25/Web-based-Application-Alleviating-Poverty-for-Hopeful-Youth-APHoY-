<!DOCTYPE html>
<html>
<head>
   <title>Header</title>
   <style>
        body {
            padding-top: 20px;
            margin-top: 20px;
            margin-right: 20px;
            margin-left: 20px;
        }
        .header a {
            padding: 10px 20px;
            border: none;
            color: white;
            text-decoration: none;
        }
        .header a:hover {
            color: aqua;
        }
        /* CSS for the logout button */
        .logout-btn {
            float: right;
            padding: 6px 10px;
            background-color: #002147;
            color: white;
            text-decoration: none;
            font-size: 25px;
            border-radius: 4px;
            margin-right: 10px;
        }
        .logout-btn:hover {
            color: aqua;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href='home.html'>APHoY</a>
        <a href="logout.php" class="logout-btn">Logout</a>
        <a href='index.html'>Index</a>
   </div>
</body>
</html>




