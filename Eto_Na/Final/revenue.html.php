<?php
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

// Get current month and year
$current_month = date('m');
$current_year = date('Y');

// SQL query to fetch data for the current month and year
$sql = "SELECT SUM(total_price) AS total_earnings FROM `order` WHERE `Month` = '$current_month' AND `Year` = '$current_year'";
$result = $conn->query($sql);

?>
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
            background-color: #333;
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
            padding: 10px 15px; /* Adjusted padding for closer spacing */
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .header a.logout {
            background-color: #f44336; /* Red color for "Go Back" button */
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
    </style>
</head>
<body>
    <div class="header">
        <a href="admin.php" class="logout">Go Back</a>
        <a href="revenue.html.php" class="revenue-link">Monthly/Yearly</a>
        <a href="daily.html.php" class="revenue-link">Daily</a>
        <a href="history.html.php" class="revenue-link">History</a>
    </div>
    <div class="container">
        <h1>Sales History</h1>
        <table>
            <tr>
                <th>Month/Year</th>
                <th>Total Earnings</th>
            </tr>
            <?php
            if ($result !== false && $result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    // Display month/year and total earnings
                    echo "<tr>";
                    echo "<td>" . date("F Y") . "</td>";
                    echo "<td>$" . number_format($row["total_earnings"], 2). "</td>"; // Format as currency
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No data available</td></tr>";
            }            
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>