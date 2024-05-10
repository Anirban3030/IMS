<?php

session_start();

include("connection.php");

$tables = array("Dashboard", "Orders", "Suppliers");
$current_table = isset($_GET['table']) ? $_GET['table'] : 'Products';

function generateSidebarLinks($tables, $current_table)
{
    foreach ($tables as $table) {
        echo '<li><a href="?table=' . $table . '"' . ($current_table === $table ? ' class="active"' : '') . '>' . $table . '</a></li>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
        }

        .header h1 {
            margin: 0;
            display: flex;
            align-items: center;
        }

        .header h1 img {
            width: 40px;
            height: auto;
            margin-right: 10px;
        }

        .header .user-info {
            display: flex;
            align-items: center;
        }

        .header .user-info img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 200px;
            background-color: #f1f1f1;
            padding: 20px;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #000;
        }

        .sidebar li a:hover {
            background-color: #ddd;
        }

        .sidebar li a.active {
            background-color: #4CAF50;
            color: white;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content th,
        .content td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left; 
            
        }

        .content th {
            background-color: #4CAF50;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>
            <img src="icons8-inventory-management-64.png" alt="Inventory Icon">
            Inventory Management System
        </h1>
        <div class="user-info">
            <img src="usericon.png" alt="User Icon">
            <span><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?></span>
        </div>
    </div>
    <div class="container">
        <div class="sidebar">
            <ul>
                <?php generateSidebarLinks($tables, $current_table); ?>
            </ul>
        </div>
        <div class="content">
            <!-- Content for the selected table -->
            <?php
            switch ($current_table) { 
                case 'Dashboard':
                    // Query to calculate total sales
                    $total_sales_query = "SELECT SUM(total_cost) AS total_sales FROM orders";
                    $total_sales_result = mysqli_query($con, $total_sales_query);
                    $total_sales_row = mysqli_fetch_assoc($total_sales_result);
                    $total_sales = $total_sales_row['total_sales'];
                
                    // Query to count the number of products in inventory
                    $product_count_query = "SELECT COUNT(*) AS product_count FROM productdetail";
                    $product_count_result = mysqli_query($con, $product_count_query);
                    $product_count_row = mysqli_fetch_assoc($product_count_result);
                    $product_count = $product_count_row['product_count'];
                
                    // Query to fetch products
                    $product_query = "SELECT * FROM productdetail"; 
                    $product_result = mysqli_query($con, $product_query);
                    ?>
                
                    <div style="background-color: #f2f2f2; padding: 20px; margin-bottom: 20px; border-radius: 10px;">
                        <h2 style="margin-top: 0;">Dashboard Overview</h2>
                        <div style="display: flex; justify-content: space-around;">
                            <div style="background-color: #4CAF50; color: white; padding: 20px; border-radius: 10px;">
                                <h3>Total Sales</h3>
                                <p style='font-size: 24px; margin: 0;'>$<?php echo $total_sales; ?></p>
                            </div>
                            <div style="background-color: #ff9800; color: white; padding: 20px; border-radius: 10px;">
                                <h3>Products in Inventory</h3>
                                <p style='font-size: 24px; margin: 0;'><?php echo $product_count; ?></p>
                            </div>
                        </div>
                    </div>
                
                    <h2>Products</h2>
                    <?php
                    if (mysqli_num_rows($product_result) > 0) {
                        echo '<table>';
                        echo '<tr><th>Product ID</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Order Status</th></tr>';
                        while ($row = mysqli_fetch_assoc($product_result)) {
                            echo '<tr>';
                            echo '<td>' . $row['Productid'] . '</td>';
                            echo '<td>' . $row['Productname'] . '</td>';
                            echo '<td>' . $row['Quantity'] . '</td>';
                            echo '<td>$' . $row['price'] . '</td>';
                            echo '<td>' . $row['orderstatus'] . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    } else {
                        echo 'No products found.';
                    }
                    echo '<h2>Insert Product Data</h2>';
                    echo '<button onclick="window.location.href=\'insertionpage.php\'">Add Product</button>';
                    break;
                case 'Orders':
                    // Query and display orders table
                    $order_query = "SELECT * FROM orders";
                    $order_result = mysqli_query($con, $order_query);
                    if (mysqli_num_rows($order_result) > 0) {
                        echo '<table>';
                        echo '<tr><th>Order Id</th><th>Product Name</th><th>Supplier Name</th><th>Quantity</th><th>Price per unit</th><th>Total Sales</th></tr>';
                        while ($row = mysqli_fetch_assoc($order_result)) {
                            echo '<tr>';
                            echo '<td>' . $row['order_id'] . '</td>';
                            echo '<td>' . $row['product_name'] . '</td>';
                            echo '<td>' . $row['supplier_name'] . '</td>';
                            echo '<td>' . $row['quantity'] . '</td>';
                            echo '<td>' . $row['price_per_kg'] . '</td>';
                            echo '<td>' . $row['total_cost'] . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    } else {
                        echo 'No orders found.';
                    }
                    echo '<h2>Place new Orders </h2>';
                    echo '<button onclick="window.location.href=\'insertionpage.php\'">Place Order</button>';
                    break;
                    // Display orders table
                case 'Suppliers':
                    // Query and display suppliers table
                    $supplier_query = "SELECT * FROM suppliers";
                    $supplier_result = mysqli_query($con, $supplier_query);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($supplier_result) > 0) {
                        // Display table header
                        echo "<table border='1'>";
                        echo "<tr><th>Supplier ID</th><th>Supplier Name</th><th>Contact Person</th><th>Email</th><th>Phone Number</th><th>Address</th><th>City</th><th>State</th><th>Postal Code</th><th>Country</th></tr>";

                        // Display data for each supplier
                        while ($row = mysqli_fetch_assoc($supplier_result)) {
                            echo "<tr>";
                            echo "<td>" . $row['supplier_id'] . "</td>";
                            echo "<td>" . $row['supplier_name'] . "</td>";
                            echo "<td>" . $row['contact_person'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone_number'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['city'] . "</td>";
                            echo "<td>" . $row['state'] . "</td>";
                            echo "<td>" . $row['postal_code'] . "</td>";
                            echo "<td>" . $row['country'] . "</td>";
                            echo "</tr>";
                        }

                        
                        echo "</table>";
                    } else {
                    
                        echo "No suppliers found.";
                    } 
                    echo '<h2>Add new Supplier Details </h2>';
                    echo '<button onclick="window.location.href=\'insertionpage.php\'">Add Supliers</button>';
                    break;

                default:
                    echo "Invalid table selection.";
            }
            ?>
        </div>
    </div>
</body>

</html>
