<?php

session_start();

include("connection.php");

$tables = array("Add new Product", "Place new Orders", "Add new Supplier");
$current_table = isset($_GET['table']) ? $_GET['table'] : 'Add new Product';

function generateSidebarLinks($tables, $current_table)
{
    foreach ($tables as $table) {
        echo '<li><a href="?table=' . urlencode($table) . '"' . ($current_table === $table ? ' class="active"' : '') . '>' . $table . '</a></li>';
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($current_table) {
        case 'Add new Product':
            
            $productid = $_POST['productid'];
            $product_name = $_POST['product_name'];
            $qty = $_POST['qty'];
            $price = $_POST['price'];

            
            $sql = "INSERT INTO productdetail (Productid, Productname, Quantity, price) VALUES ('$productid', '$product_name', '$qty', '$price')";
            mysqli_query($con, $sql);
            break;

        case 'Place new Orders':
            
            $orderid = $_POST['orderid'];
            $productname = $_POST['productname']; 
            $suppliername = $_POST['suppliername']; 
            $quantity = $_POST['quantity'];  
            $priceperunit = $_POST['priceperunit']; 
            $sql = "INSERT INTO orders (order_id , product_name, supplier_name, quantity, price_per_kg) VALUES ('$orderid', '$productname', '$suppliername', '$quantity','$priceperunit')"; 
            mysqli_query($con, $sql);
            break;

        case 'Add new Supplier':
            $supplierid=$_POST['supplierid'];
            $suppliername=$_POST['suppliername']; 
            $contactperson=$_POST['contactperson']; 
            $email=$_POST['email'];  
            $phonenumber=$_POST['phonenumber'];   
            $address=$_POST['address']; 
            $city=$_POST['city'];  
            $State=$_POST['state'];  
            $postalcode = $_POST['postalcode']; 
            $country=$_POST['country'];  

            $sql = "INSERT INTO suppliers (	supplier_id  , supplier_name, contact_person, email, phone_number, address,city,state,postal_code,country) VALUES ('$supplierid', '$suppliername', '$contactperson', '$email','$phonenumber','$address','$city','$State','$postalcode','$country')"; 
            mysqli_query($con, $sql);
            break;

        default:
        
            break;
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

        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px; 
        
        }

        .form-container label {
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer; 
            box-shadow: #000;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
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
            
            <?php
            switch ($current_table) {
                case 'Add new Product':
                    ?>
                    <div class="form-container">
                        <h2>Add New Product</h2>
                        <form  method="post">

                            <label for="productid">Product Id:</label>
                            <input type="number" id="productid" name="productid" required> 

                            <label for="product_name">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" required>

                            <label for="qty">Quantity:</label>
                            <input type="number" id="qty" name="qty" required>

                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" required>

                            <label for="order_status">Order Status:</label>
                            <select id="order_status" name="order_status" required>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Completed</option>
                                <option value="Processing">Processing</option>
                            </select>

                            <input type="submit" value="Add Product">
                        </form>
                    </div>
                    <?php
                    break;
                case 'Place new Orders':
                    ?>
                    <div class="form-container">
                        <h2>Place New Order</h2>
                        <form  method="post">
                            
                            <label for="orderid">Order Id:</label>
                            <input type="number" id="orderid" name="orderid" required>

                            <label for="productname">Product Name:</label>
                            <input type="text" id="productname" name="productname" required>

                            <label for="suppliername">Supplier Name:</label>
                            <input type="text" id="suppliername" name="suppliername" required>

                            <label for="quantity">Quantity:</label>  
                            <input type = "number" id="quantity" name="quantity" required>

                            <label for="priceperunit">Price per Unit</label> 
                            <input type = "number" id="priceperunit" name="priceperunit" required> 


                            <input type="submit" value="Add Order">
                        </form>
                    </div>
                    <?php
                    break;
                case 'Add new Supplier':
                    ?>
                    <div class="form-container">  
                        <h2>Add new Supplier details</h2>
                        <form  method="post">
                            
                            <label for="supplierid">Supplier ID:</label>
                            <input type="number" id="supplierid" name="supplierid" required>

                            <label for="suppliername">Supplier Name:</label>
                            <input type="text" id="suppliername" name="suppliername" required>

                            <label for="contactperson">Contact Person:</label>
                            <input type="text" id="contactperson" name="contactperson" required>

                            <label for="email">Email:</label>  
                            <input type = "text" id="email" name="email" required> 
                            
                            <label for="phonenumber">Phone Number</label> 
                            <input type = "number" id="phonenumber" name="phonenumber" required> 
                            
                            <label for="address">Address</label> 
                            <input type = "text" id="address" name="address" required>  

                            <label for="city">City</label> 
                            <input type = "text" id="city" name="city" required>  

                            <label for="state">State</label> 
                            <input type = "text" id="state" name="state" required>  

                            <label for="postalcode">Postal Code</label> 
                            <input type = "number" id="postalcode" name="postalcode" required> 

                            <label for="country">Country</label> 
                            <input type = "text" id="country" name="country" required>


                            <input type="submit" value="Add supplier">
                        </form>
                    </div>
                    <?php
                    break;
                default:
                    
            }
            ?>
        </div>
    </div>
</body>

</html>
