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

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $childName = $_POST['childName'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $childAddress = $_POST['childAddress'];
    $language = $_POST['language'];
    $medicalInfo = $_POST['medicalInfo'];
    $parentName = $_POST['parentName'];
    $parentContact = $_POST['parentContact'];
    $parentEmail = $_POST['parentEmail'];
    $emergencyContact = $_POST['emergencyContact'];
    $emergencyPhone = $_POST['emergencyPhone'];
    $startDate = $_POST['startDate'];
    $programSelection = $_POST['programSelection'];
    $previousExperience = $_POST['previousExperience'];
    $specialNeeds = $_POST['specialNeeds'];

    $sql = "UPDATE Enrollment SET 
            childName = ?, dob = ?, gender = ?, childAddress = ?, language = ?, 
            medicalInfo = ?, parentName = ?, parentContact = ?, parentEmail = ?, 
            emergencyContact = ?, emergencyPhone = ?, startDate = ?, 
            programSelection = ?, previousExperience = ?, specialNeeds = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssssssssssssssi",
        $childName, $dob, $gender, $childAddress, $language, $medicalInfo,
        $parentName, $parentContact, $parentEmail, $emergencyContact,
        $emergencyPhone, $startDate, $programSelection, $previousExperience,
        $specialNeeds, $id
    );
    $stmt->execute();

    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Enrollment</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
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
        form {
            display: grid;
            gap: 15px;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input[type="text"], input[type="date"], input[type="email"] {
            padding: 10px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #f9f9f9;
        }
        input[type="text"]:focus, input[type="date"]:focus, input[type="email"]:focus {
            border-color: #007BFF;
            outline: none;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .back-btn {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 1rem;
            text-decoration: none;
            margin-top: 20px;
        }
        .back-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Enrollment for <?= htmlspecialchars($record['childName']) ?></h1>

    <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $record['id'] ?>">

        <div class="form-group">
            <label for="childName">Child Name:</label>
            <input type="text" id="childName" name="childName" value="<?= htmlspecialchars($record['childName']) ?>">
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($record['dob']) ?>">
        </div>
        <div class="form-group">
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?= htmlspecialchars($record['gender']) ?>">
        </div>
        <div class="form-group">
            <label for="childAddress">Address:</label>
            <input type="text" id="childAddress" name="childAddress" value="<?= htmlspecialchars($record['childAddress']) ?>">
        </div>
        <div class="form-group">
            <label for="language">Language:</label>
            <input type="text" id="language" name="language" value="<?= htmlspecialchars($record['language']) ?>">
        </div>
        <div class="form-group">
            <label for="medicalInfo">Medical Info:</label>
            <input type="text" id="medicalInfo" name="medicalInfo" value="<?= htmlspecialchars($record['medicalInfo']) ?>">
        </div>
        <div class="form-group">
            <label for="parentName">Parent Name:</label>
            <input type="text" id="parentName" name="parentName" value="<?= htmlspecialchars($record['parentName']) ?>">
        </div>
        <div class="form-group">
            <label for="parentContact">Parent Contact:</label>
            <input type="text" id="parentContact" name="parentContact" value="<?= htmlspecialchars($record['parentContact']) ?>">
        </div>
        <div class="form-group">
            <label for="parentEmail">Parent Email:</label>
            <input type="email" id="parentEmail" name="parentEmail" value="<?= htmlspecialchars($record['parentEmail']) ?>">
        </div>
        <div class="form-group">
            <label for="emergencyContact">Emergency Contact:</label>
            <input type="text" id="emergencyContact" name="emergencyContact" value="<?= htmlspecialchars($record['emergencyContact']) ?>">
        </div>
        <div class="form-group">
            <label for="emergencyPhone">Emergency Phone:</label>
            <input type="text" id="emergencyPhone" name="emergencyPhone" value="<?= htmlspecialchars($record['emergencyPhone']) ?>">
        </div>
        <div class="form-group">
            <label for="startDate">Start Date:</label>
            <input type="text" id="startDate" name="startDate" value="<?= htmlspecialchars($record['startDate']) ?>">
        </div>
        <div class="form-group">
            <label for="programSelection">Program Selection:</label>
            <input type="text" id="programSelection" name="programSelection" value="<?= htmlspecialchars($record['programSelection']) ?>">
        </div>
        <div class="form-group">
            <label for="previousExperience">Previous Experience:</label>
            <input type="text" id="previousExperience" name="previousExperience" value="<?= htmlspecialchars($record['previousExperience']) ?>">
        </div>
        <div class="form-group">
            <label for="specialNeeds">Special Needs:</label>
            <input type="text" id="specialNeeds" name="specialNeeds" value="<?= htmlspecialchars($record['specialNeeds']) ?>">
        </div>

        <button type="submit" name="update">Update</button>
    </form>

    <a href="admin.php?key=secretKey123" class="back-btn">Back to Admin</a>
</div>

</body>
</html>

<?php $conn->close(); ?>