<?php
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

    if($_FILES["childPhoto"]["error"] === 4){
        echo
        "<script> alert('Image Does Not Exist');</script>";
    }else{
        $fileName1 = $_FILES["childPhoto"]["name"];
        $fileSize1 = $_FILES["childPhoto"]["size"];
        $tmpName1 = $_FILES["childPhoto"]["tmp_name"];

        $validImageExtension1 = ['jpg', 'jpeg', 'png'];
        $imageExtension1 = explode('.', $fileName1);
        $imageExtension1 = strtolower(end($imageExtension1));
        if(!in_array($imageExtension1, $validImageExtension1)){
            echo
            "<script> alert('Invalid Image Extension');</script>";
        }else if($fileSize1 > 1000000){
        echo
        "<script> alert('Image Size Is Too Large');</script>";
        }else{
            $childPhoto = uniqid();
            $childPhoto .= '.' . $imageExtension1;

            move_uploaded_file($tmpName1, 'child img/' . $childPhoto);
        }
    }
    

    if($_FILES["paymentPhoto"]["error"] === 4){
        echo
        "<script> alert('Image Does Not Exist');</script>";
    }else{
        $fileName2 = $_FILES["paymentPhoto"]["name"];
        $fileSize2 = $_FILES["paymentPhoto"]["size"];
        $tmpName2 = $_FILES["paymentPhoto"]["tmp_name"];

        $validImageExtension2 = ['jpg', 'jpeg', 'png'];
        $imageExtension2 = explode('.', $fileName2);
        $imageExtension2 = strtolower(end($imageExtension2));
        if(!in_array($imageExtension2, $validImageExtension2)){
            echo
            "<script> alert('Invalid Image Extension');</script>";
        }else if($fileSize2 > 1000000){
        echo
        "<script> alert('Image Size Is Too Large');</script>";
        }else{
            $paymentPhoto = uniqid();
            $paymentPhoto .= '.' . $imageExtension2;

            move_uploaded_file($tmpName2, 'payment img/' . $paymentPhoto);
        }
    }


    //Database Connection
    $conn = new mysqli('localhost','root','','upintar');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }else{
        $stmt = $conn->prepare("insert into Enrollment(childName,dob,gender,childAddress,language,medicalInfo,parentName,parentContact,parentEmail,emergencyContact,emergencyPhone,startDate,programSelection,previousExperience,specialNeeds,childPhoto,paymentPhoto)
            values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("sssssssssssssssss",$childName,$dob,$gender,$childAddress,$language,$medicalInfo,$parentName,$parentContact,$parentEmail,$emergencyContact,$emergencyPhone,$startDate,$programSelection,$previousExperience,$specialNeeds,$childPhoto,$paymentPhoto);
        $stmt->execute();
        echo "Registration Successfully...";
        $stmt->close();
        $conn->close();
    }

?>