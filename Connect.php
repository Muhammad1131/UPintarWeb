<?php
// Supabase configuration
$supabaseUrl = 'https://ytcmpxfduhrramtsrmvv.supabase.co'; // Replace with your Supabase URL
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Inl0Y21weGZkdWhycmFtdHNybXZ2Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzIwMjgxODcsImV4cCI6MjA0NzYwNDE4N30.NWuUhkUrOEnxOw98qavc5nghwUwK_hQVwTFeLx1T65A'; // Replace with your Supabase anon key

// Fetch POST data
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

// Handle file uploads
function uploadImage($file, $folder)
{
    if ($file["error"] === 4) {
        return null;
    }

    $validExtensions = ['jpg', 'jpeg', 'png'];
    $fileName = $file["name"];
    $fileSize = $file["size"];
    $tmpName = $file["tmp_name"];

    $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($extension, $validExtensions) || $fileSize > 1000000) {
        return null;
    }

    $newFileName = uniqid() . '.' . $extension;
    move_uploaded_file($tmpName, "$folder/$newFileName");
    return $newFileName;
}

$childPhoto = uploadImage($_FILES["childPhoto"], "child img");
$paymentPhoto = uploadImage($_FILES["paymentPhoto"], "payment img");

// Prepare data for Supabase API
$data = [
    "childName" => $childName,
    "dob" => $dob,
    "gender" => $gender,
    "childAddress" => $childAddress,
    "language" => $language,
    "medicalInfo" => $medicalInfo,
    "parentName" => $parentName,
    "parentContact" => $parentContact,
    "parentEmail" => $parentEmail,
    "emergencyContact" => $emergencyContact,
    "emergencyPhone" => $emergencyPhone,
    "startDate" => $startDate,
    "programSelection" => $programSelection,
    "previousExperience" => $previousExperience,
    "specialNeeds" => $specialNeeds,
    "childPhoto" => $childPhoto,
    "paymentPhoto" => $paymentPhoto
];

// Send data to Supabase using cURL
$apiUrl = "$supabaseUrl/rest/v1/Enrollment"; // Supabase REST endpoint
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "apikey: $supabaseKey",
    "Content-Type: application/json",
    "Authorization: Bearer $supabaseKey"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo "Error: " . curl_error($ch);
} else {
    echo "Registration Successful! Response: $response";
}
curl_close($ch);
?>
