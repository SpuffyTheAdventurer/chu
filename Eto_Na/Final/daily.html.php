<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333; /* Set header background color to #333 */
            color: #fff;
            padding: 10px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .header a.logout {
            background-color: #f44336;
        }

        .header a:hover {
            background-color: #555;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        .no-data {
            text-align: center;
            color: red;
        }

        .go-back-button {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <a href="admin.php" class="logout">Go Back</a>
        <a href="revenue.html.php" class="revenue-link">Monthly/Yearly</a>
        <a href="daily.html.php" class="revenue-link">Daily</a>
        <a href="history.html.php" class="revenue-link">History</a>
    </div>

    <!-- Main content -->
    <div class="container">
        <h1>Total Earnings</h1>
        <table>
            <tr>
                <th>Date</th>
                <th>Total Earnings</th>
            </tr>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "shop_db";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch total earnings from the database
            $sql = "SELECT `Date`, `total_earnings` FROM `total_earnings`";
            $result = $conn->query($sql);

            // Displaying total earnings for each date
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["Date"]."</td><td>₱".$row["total_earnings"]."</td></tr>";
                }
            } else {
                echo '<tr><td colspan="2" class="no-data">No data available</td></tr>';
            }
            $conn->close();
            ?>
        </table>

        <!-- Clear button form -->
        <div class="go-back-button">
            <form method="post">
                <input type="submit" name="go_back" value="Clear">
            </form>
        </div>
    </div>

    <!-- PHP code for clearing the database -->
    <?php
    // Check if the "Clear" button is clicked
    if(isset($_POST['go_back'])) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "shop_db";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Clear the total_earnings table
        $clear_sql = "TRUNCATE TABLE `total_earnings`"; // Truncate the table to clear all data
        if(mysqli_query($conn, $clear_sql)) {
            // Redirect to the same page after clearing the database
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        } else {
            echo '<div style="text-align: center; color: red;">Failed to clear database!</div>';
        }
        $conn->close();
    }
    ?>
</body>
</html>