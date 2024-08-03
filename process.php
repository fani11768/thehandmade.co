


<?php
// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP MySQL password is empty
$dbname = "shipments";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the request is to add a shipment
    if (isset($_POST['customerName']) && isset($_POST['orderNumber']) && isset($_POST['serviceHandler']) && isset($_POST['origin']) && isset($_POST['destination']) && isset($_POST['status'])) {
        $customerName = $_POST['customerName'];
        $orderNumber = $_POST['orderNumber'];
        $trackingCode = 'HM' . str_pad(rand(0, 999999), 8, '92', STR_PAD_LEFT);
        $serviceHandler = $_POST['serviceHandler'];
        $origin = $_POST['origin'];
        $destination = $_POST['destination'];
        $status = $_POST['status'];
        $updateTime = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO shipments (customerName, orderNumber, trackingCode, serviceHandler, origin, destination, status, updateTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $customerName, $orderNumber, $trackingCode, $serviceHandler, $origin, $destination, $status, $updateTime);

        if ($stmt->execute()) {
            // Redirect to index.php with a success message
            header("Location: index.php?message=Shipment added successfully");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    // Check if the request is to fetch shipment details
    if (isset($_POST['trackingCode'])) {
        $trackingCode = $_POST['trackingCode'];

        // Prepare SQL statement
        $sql = "SELECT * FROM shipments WHERE trackingCode = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $trackingCode);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch and return the shipment data as JSON
        if ($result->num_rows > 0) {
            $shipment = $result->fetch_assoc();
            echo json_encode($shipment);
        } else {
            echo json_encode(null);
        }

        $stmt->close();
    }
}

$conn->close();
?>
