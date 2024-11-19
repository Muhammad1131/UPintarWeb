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

// Define the secret access key
$secretKey = "secretKey123";

// Check if the key is passed through the query string
if (isset($_GET['key']) && $_GET['key'] === $secretKey) {
    // Fetch all records from the 'Enrollment' table
    $sql = "SELECT * FROM Enrollment"; // Ensure 'Enrollment' matches your table name
    $result = $conn->query($sql);
} else {
    // If the key doesn't match, show an error
    echo "<h2>Access Denied: Invalid Key</h2>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2; /* New light grey background */
        }

        header {
            background-color: #2196F3; /* Blue header */
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 28px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2196F3; /* Matching table header color */
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Action button styles */
        .actions a {
            padding: 10px 20px; /* Increased padding for more space */
            border-radius: 8px; /* Rounded corners for a smoother look */
            text-decoration: none;
            color: white;
            margin: 5px;
            font-size: 16px; /* Slightly larger font size */
            transition: all 0.3s ease;
            display: inline-block; /* Ensure buttons are aligned horizontally */
            min-width: 100px; /* Ensure a minimum width for all buttons */
            text-align: center; /* Center the text inside the buttons */
        }

        .actions .edit-btn {
            background-color: #FF9800; /* Orange edit button */
        }

        .actions .delete-btn {
            background-color: #F44336; /* Red delete button */
        }

        .actions .view-btn {
            background-color: #4CAF50; /* Green view button */
        }

        .actions a:hover {
            transform: scale(1.05); /* Slight scaling effect on hover */
            opacity: 0.9;
        }

        /* Flexbox layout for the actions column */
        .actions {
            display: flex;
            justify-content: center;
            gap: 10px; /* Adds space between the buttons */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table, th, td {
                font-size: 12px;
                padding: 8px;
            }

            header {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <header>
        Admin Dashboard - All Enrollments
    </header>

    <div class="container">
        <table id="adminTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Child Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Address</th>
                    <th>Language</th>
                    <th>Medical Info</th>
                    <th>Parent Name</th>
                    <th>Parent Contact</th>
                    <th>Parent Email</th>
                    <th>Emergency Contact</th>
                    <th>Emergency Phone</th>
                    <th>Start Date</th>
                    <th>Program</th>
                    <th>Previous Experience</th>
                    <th>Special Needs</th>
                    <th>Child Photo</th>
                    <th>Payment Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($result) && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . htmlspecialchars($row['childName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['dob']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['gender']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['childAddress']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['language']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['medicalInfo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['parentName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['parentContact']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['parentEmail']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['emergencyContact']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['emergencyPhone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['startDate']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['programSelection']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['previousExperience']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['specialNeeds']) . "</td>";
                        echo "<td><img src='child img/" . htmlspecialchars($row['childPhoto']) . "' width='50' height='50' alt='Child Photo'></td>";
                        echo "<td><img src='payment img/" . htmlspecialchars($row['paymentPhoto']) . "' width='50' height='50' alt='Payment Photo'></td>";
                        echo "<td class='actions'>
                                <a href='edit.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>
                                <a href='delete.php?id=" . $row['id'] . "' class='delete-btn'>Delete</a>
                                <a href='view.php?id=" . $row['id'] . "' class='view-btn'>View</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='19'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#adminTable').DataTable();
        });
    </script>

</body>
</html>

<?php
$conn->close();
?>