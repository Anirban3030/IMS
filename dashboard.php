<?php
// Check if the user is logged in, if not, redirect to login page
session_start();
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
//     header("location: index.php");
//     exit;
// }

// Include the database connection
include("connection.php");

// Initialize variables for table names
$tables = array("Products", "Orders", "Suppliers");
$current_table = isset($_GET['table']) ? $_GET['table'] : 'Products';

// Function to generate sidebar links
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
        .container {
            display: flex;
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
    </style>
</head>
<body>
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
                case 'Products':
                    // Query and display products table
                    $product_query = "SELECT * FROM products";
                    $product_result = mysqli_query($con, $product_query);
                    // Display products table
                    break;
                case 'Orders':
                    // Query and display orders table
                    $order_query = "SELECT * FROM orders";
                    $order_result = mysqli_query($con, $order_query);
                    // Display orders table
                    break;
                case 'Suppliers':
                    // Query and display suppliers table
                    $supplier_query = "SELECT * FROM suppliers";
                    $supplier_result = mysqli_query($con, $supplier_query);
                    // Display suppliers table
                    break;
                default:
                    echo "Invalid table selection.";
            }
            ?>
        </div>
    </div>
</body>
</html>
