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
        .orders-table-container {
            margin-top: 20px;
            overflow-x: auto;
        }
        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }
        .orders-table th, .orders-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .orders-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .orders-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .orders-table tr:hover {
            background-color: #ddd;
        }
        .no-orders {
            margin-top: 20px;
            font-style: italic;
            color: #777;
        }
        .go-back-button {
            margin-top: 20px;
            text-align: center;
        }
        .go-back-button a, .history-button a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .go-back-button a:hover, .history-button a:hover {
            background-color: #45a049;
        }
        .done-button, .priority-button {
            padding: 6px 10px;
            margin-left: 5px;
            cursor: pointer;
        }
        .priority-button {
            background-color: #ff0;
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
        <?php
        // Include your database configuration file
        @include 'config.php';

        // CSS styles for the orders table
        $css = "
            <style>
                .orders-table-container {
                    margin-top: 20px;
                    overflow-x: auto;
                }

                .orders-table {
                    width: 100%;
                    border-collapse: collapse;
                }

                .orders-table th, .orders-table td {
                    padding: 8px;
                    border: 1px solid #ddd;
                }

                .orders-table th {
                    background-color: #f2f2f2;
                    text-align: left;
                }

                .orders-table tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                .orders-table tr:hover {
                    background-color: #ddd;
                }

                .no-orders {
                    margin-top: 20px;
                    font-style: italic;
                    color: #777;
                }

                .go-back-button {
                    margin-top: 20px;
                    text-align: center;
                }

                .go-back-button a, .history-button a {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #4caf50;
                    color: white;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }

                .go-back-button a:hover, .history-button a:hover {
                    background-color: #45a049;
                }

                .done-button, .priority-button {
                    padding: 6px 10px;
                    margin-left: 5px;
                    cursor: pointer;
                }

                .priority-button {
                    background-color: #ff0;
                }
            </style>
        ";

        echo $css;
        ?>

        <?php
        // Function to move order to history by ID
        function moveOrderToHistory($conn, $order_id) {
            $sql = "INSERT INTO `history_order` SELECT * FROM `order` WHERE id = $order_id";
            if(mysqli_query($conn, $sql)) {
                return true;
            } else {
                return false;
            }
        }

        // Initialize total revenue variable
        $total_revenue = 0;

        // Query to fetch all orders from the database
        $select_orders = mysqli_query($conn, "SELECT * FROM `order`");

        // Check if there are any orders
        if(mysqli_num_rows($select_orders) > 0) {
            echo '<div class="orders-table-container">';
            echo '<table class="orders-table">';
            echo '<tr><th>Student Name</th><th>Contact</th><th>Email</th><th>Method</th><th>Building</th><th>Strand and Section</th><th>Cluster</th><th>Advisory</th><th>Year</th><th>ID</th><th>Total Price</th><th>Action</th></tr>';

            // Loop through each order and display the details
            while($row = mysqli_fetch_assoc($select_orders)) {
                echo '<tr>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['number'].'</td>';
                echo '<td>'.$row['email'].'</td>';
                echo '<td>'.$row['method'].'</td>';
                echo '<td>'.$row['flat'].'</td>';
                echo '<td>'.$row['street'].'</td>';
                echo '<td>'.$row['city'].'</td>'; // Change to Cluster
                echo '<td>'.$row['state'].'</td>';
                echo '<td>'.$row['country'].'</td>';
                echo '<td>'.$row['pin_code'].'</td>';
                echo '<td>'.$row['total_price'].'</td>'; // Display total price
                echo '<td>';
                echo '<button class="done-button" onclick="moveOrderToHistory('.$row['id'].')">Done</button>';
                echo '<button class="priority-button" onclick="markPriority(this)">Priority</button>';
                echo '</td>';
                echo '</tr>';
                
                // Add order's total price to total revenue
                $total_revenue += $row['total_price'];
            }

            echo '</table>';
            echo '</div>';

            // Display total revenue
            echo '<div>Total Revenue: ₱' . number_format($total_revenue, 2) . '</div>';
        } else {
            // If no orders found, display a message
            echo '<div class="no-orders">No orders found.</div>';
        }
        ?>

        <div class="go-back-button">
            <a href="admin.php">Go Back</a>
        </div>
    </div>

    <script>
        // Function to move order to history
        function moveOrderToHistory(order_id) {
            if (confirm("Are you sure you want to move this order to history?")) {
                // Send an AJAX request to move the order to history
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        // Reload the page after moving to history
                        window.location.reload();
                    }
                };
                xmlhttp.open("GET", "history.html.php?id=" + order_id, true);
                xmlhttp.send();
            }
        }

        // Function to mark priority
        function markPriority(button) {
            var row = button.parentNode.parentNode;
            if (row.style.backgroundColor === "yellow") {
                row.style.backgroundColor = "";
            } else {
                row.style.backgroundColor = "yellow";
            }
        }
    </script>
</body>
</html>