<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "upintar";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Enrollment WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Enrollment</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007BFF;
            font-size: 2rem;
            margin-bottom: 20px;
        }
        .detail {
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        .detail label {
            font-weight: bold;
            color: #555;
        }
        .detail p {
            margin: 5px 0;
            color: #555;
        }
        .detail img {
            margin: 10px;
            border-radius: 8px;
            max-width: 500px; /* Increased width for larger image */
            max-height: 500px; /* Increased height for larger image */
            object-fit: contain; /* Ensures the entire image is visible */
            border: 2px solid #ddd;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .btn {
            display: inline-block;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            margin-top: 20px;
            font-size: 1rem;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .actions {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Details for <?= htmlspecialchars($record['childName']) ?></h1>

    <div class="detail">
        <label>Date of Birth:</label>
        <p><?= htmlspecialchars($record['dob']) ?></p>
    </div>
    <div class="detail">
        <label>Gender:</label>
        <p><?= htmlspecialchars($record['gender']) ?></p>
    </div>
    <div class="detail">
        <label>Address:</label>
        <p><?= htmlspecialchars($record['childAddress']) ?></p>
    </div>
    <div class="detail">
        <label>Language:</label>
        <p><?= htmlspecialchars($record['language']) ?></p>
    </div>
    <div class="detail">
        <label>Medical Info:</label>
        <p><?= htmlspecialchars($record['medicalInfo']) ?></p>
    </div>
    <div class="detail">
        <label>Parent Name:</label>
        <p><?= htmlspecialchars($record['parentName']) ?></p>
    </div>
    <div class="detail">
        <label>Parent Contact:</label>
        <p><?= htmlspecialchars($record['parentContact']) ?></p>
    </div>
    <div class="detail">
        <label>Parent Email:</label>
        <p><?= htmlspecialchars($record['parentEmail']) ?></p>
    </div>
    <div class="detail">
        <label>Emergency Contact:</label>
        <p><?= htmlspecialchars($record['emergencyContact']) ?></p>
    </div>
    <div class="detail">
        <label>Emergency Phone:</label>
        <p><?= htmlspecialchars($record['emergencyPhone']) ?></p>
    </div>
    <div class="detail">
        <label>Start Date:</label>
        <p><?= htmlspecialchars($record['startDate']) ?></p>
    </div>
    <div class="detail">
        <label>Program Selection:</label>
        <p><?= htmlspecialchars($record['programSelection']) ?></p>
    </div>
    <div class="detail">
        <label>Previous Experience:</label>
        <p><?= htmlspecialchars($record['previousExperience']) ?></p>
    </div>
    <div class="detail">
        <label>Special Needs:</label>
        <p><?= htmlspecialchars($record['specialNeeds']) ?></p>
    </div>

    <div class="detail">
        <label>Child's Photo:</label><br>
        <img src="child img/<?= htmlspecialchars($record['childPhoto']) ?>" alt="Child Photo">
    </div>
    <div class="detail">
        <label>Payment Photo:</label><br>
        <img src="payment img/<?= htmlspecialchars($record['paymentPhoto']) ?>" alt="Payment Photo">
    </div>

    <div class="actions">
        <a href="edit.php?id=<?= $record['id'] ?>" class="btn">Edit Details</a>
        <a href="admin.php?key=secretKey123" class="btn">Back to Admin</a>
    </div>
</div>

</body>
</html>

<?php $conn->close(); ?>