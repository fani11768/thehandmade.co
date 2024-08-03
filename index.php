

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        /* Existing styles */
        .edit-button {
            padding: 4px 10px;
            background-color: black;
            color: white;
           
          
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button:hover {
            background-color: #e0a800;
        }
        .edit-input {
            width: 90%;
            padding: 5px;
          border: white;
            border-radius: 4px;
           
           
        }
      
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: rgb(216, 143, 7);
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
          background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  
        }
        label {
            display: inline-block;
            width: 10%;
            margin-bottom: 20px;
        }
        input {
            padding: 10px;
            border: 1px solid #585858;
            border-radius: 4px;
            width: 200px;
          
        }
        button {
            padding: 10px;
            background: black;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
         
        }
        button:hover {
            background: rgb(184, 7, 7);
        }
        .table-container {
            overflow: auto;
            max-height: 600px; /* Set a maximum height for the table container */
            background: #fafafa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px;
            border: 1px solid #9d8fdb;
            white-space: nowrap; /* Prevent text wrapping */
            text-align: center;
        }
        th {
            padding: 10px;
            background: rgb(102, 78, 78);
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        td:first-child {
            position: sticky;
            left: 0;
            background: #f2f2f2; /* Background for sticky first column */
            z-index: 1; /* Ensure it's below header */
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .copy-button {
            padding: 5px 10px;
            background-color: #276cec;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .copy-button:hover {
            background-color: #45a049;
        }
        .logout-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .logout-link:hover {
            background-color: #0056b3;
        }
        .status-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .status-button {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .status-in-process {
            background-color: red; /* Orange */
        }
        .status-out-of-delivery {
            background-color: #ffa500; /* Blue */
        }
        .status-delivered {
            background-color: #28a745; /* Green */
        }
        .delete-button {
            padding: 5px 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-button:hover {
            background-color: darkred;
        }

        .status-buttons {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
        .status-button {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .status-in-process {
            background-color: red; /* Orange */
        }
        .status-out-of-delivery {
            background-color: #ffa500; /* Blue */
        }
        .status-delivered {
            background-color: #28a745; /* Green */
        }
        a:link, a:visited {
  background-color: #f44336;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}
    </style>
</head>
<body>

<form id="shipmentForm" action="process.php" method="POST">
        <!-- Form elements -->
        <label for="customerName">Customer Name:</label>
        <input type="text" id="customerName" name="customerName" required>
        <label for="orderNumber">Order Number:</label>
        <input type="text" id="orderNumber" name="orderNumber" required> <br>
        <label for="serviceHandler">Hand Over:</label> 
        <input type="text" id="serviceHandler" name="serviceHandler" required> 
        <label for="origin">Origin:</label> 
        <input type="text" id="origin" name="origin" required> <br>
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" required> 
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" required> <br>
        <button type="submit">Add Shipment</button>
        <a href="tracking.html" target="">Tracking</a>   
    </form>

    <div class="table-container">
        <table id="shipmentTable">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Order ID</th>
                    <th>Tracking ID</th>
                    <th>Hand Over</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Update Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = ""; // default XAMPP MySQL password is empty
                $dbname = "shipments";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM shipments";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["customerName"] . "</td>";
                        echo "<td>" . $row["orderNumber"] . "</td>";
                        echo "<td>" . $row["trackingCode"] . "</td>";
                        echo "<td>" . $row["serviceHandler"] . "</td>";
                        echo "<td>" . $row["origin"] . "</td>";
                        echo "<td>" . $row["destination"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["updateTime"] . "</td>";
                        echo "<td class='action-buttons'>";
                        echo "<button class='delete-button' onclick='deleteShipment(" . $row["id"] . ")'>Delete</button>";

                        // Status buttons
                        echo "<button class='status-button status-in-process' onclick='updateStatus(" . $row["id"] . ", \"in_process\")'>In Process</button>";
                        echo "<button class='status-button status-out-of-delivery' onclick='updateStatus(" . $row["id"] . ", \"out_of_delivery\")'>Out of Delivery</button>";
                        echo "<button class='status-button status-delivered' onclick='updateStatus(" . $row["id"] . ", \"delivered\")'>Delivered</button>";

                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No shipments found</td></tr>";
                }

                $conn->close();
                ?>
                
            </tbody>
        </table>
    </div>

    <script>
        function deleteShipment(id) {
            if (confirm("Are you sure you want to delete this shipment?")) {
                window.location.href = "delete.php?id=" + id;
            }
        }

        function updateStatus(id, status) {
            if (confirm("Are you sure you want to update the status to " + status + "?")) {
                window.location.href = "update_status.php?id=" + id + "&status=" + status;
            }
        }
    </script>
</body>
</html>
