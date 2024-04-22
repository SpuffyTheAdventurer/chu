<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Assuming the password is empty based on the SQL dump
$dbname = "shop_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the "Go Back" button is clicked and clear the database
if(isset($_POST['go_back'])) {
    // Insert daily earnings into the total_earnings table
    $insert_earnings_sql = "INSERT INTO `total_earnings` (`total_earnings`, `Date`, `Year`) SELECT SUM(`total_price`), CURRENT_DATE(), YEAR(CURRENT_DATE()) FROM `order`";
    if(mysqli_query($conn, $insert_earnings_sql)) {
        echo '<div style="text-align: center; color: green;">Daily earnings added successfully!</div>';
    } else {
        echo '<div style="text-align: center; color: red;">Failed to add daily earnings!</div>';
    }

    // Clear the order table
    $clear_sql = "TRUNCATE TABLE `order`"; // Truncate the table to clear all data
    if(mysqli_query($conn, $clear_sql)) {
        echo '<div style="text-align: center; color: green;">Database cleared successfully!</div>';
    } else {
        echo '<div style="text-align: center; color: red;">Failed to clear database!</div>';
    }
}

// Query to fetch all orders from the database
$query = "SELECT * FROM `order`";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <style>
        /* CSS styles for the combined page */
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
            max-width: 95%;
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
        .go-back-button {
            margin-top: 20px;
            text-align: center; /* Center the button */
        }
        .go-back-button input[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .go-back-button input[type="submit"]:hover {
            background-color: #45a049;
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
    <!-- Container -->
    <div class="container">
        <h1>Sales History</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Number</th>
                <th>Email</th>
                <th>Method</th>
                <th>Total Products</th>
                <th>Total Price</th>
                <th>Date</th>
                <th>Year</th>
            </tr>
            <?php
            if(mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['number']."</td>";
                    echo "<td>".$row['email']."</td>";
                    echo "<td>".$row['method']."</td>";
                    echo "<td>".$row['total_products']."</td>";
                    echo "<td>₱".$row['total_price']."/-</td>";
                    echo "<td>".$row['Date']."</td>";
                    echo "<td>".$row['Year']."</td>";
                    echo "</tr>";
                }
            } else {
                echo '<tr><td colspan="9" class="no-orders">No orders available</td></tr>';
            }
            ?>
        </table>
        
        <!-- Clear button form -->
        <div class="go-back-button">
            <form method="post">
                <input type="submit" name="go_back" value="Clear">
            </form>
        </div>
    </div>

    <!-- Your JavaScript code here -->
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>