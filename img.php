<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pct";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    // Validate image upload
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Image upload failed: ' . $_FILES['image']['error']]);
        exit;
    }

    // Validate image type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG and GIF allowed.']);
        exit;
    }

    // Read image file
    $family_head_photo = file_get_contents($_FILES['image']['tmp_name']);
   
    // Retrieve form data
    $family_head = $_POST['family-head'];
    $village_name = $_POST['village-name'];
    $blood_group = $_POST['blood-group'];
    $education = $_POST['education'];
    $family_members_count = $_POST['family-members-count'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $occupation = $_POST['occupation'];
    $mataji = $_POST['mataji'];
    $help = $_POST['help'];
    $suggestions = $_POST['suggestions'];

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        $query = "INSERT INTO family_head_details (
            family_head_name, 
            family_head_photo, 
            family_native, 
            family_head_blood_group,
            family_head_education,
            family_members,
            family_head_dob,
            family_head_address,
            family_head_contact_num,
            family_head_occupation,
            mataji_madh,
            help_pct,
            suggestions
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query);
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssssssssss",
            $family_head,
            $family_head_photo,
            $village_name,
            $blood_group,
            $education,
            $family_members_count,
            $dob,
            $address,
            $phone,
            $occupation,
            $mataji,
            $help,
            $suggestions
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_commit($conn);
            echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
        } else {
            throw new Exception(mysqli_stmt_error($stmt));
        }
        
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(['status' => 'error', 'message' => 'Error saving data: ' . $e->getMessage()]);
    } finally {
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>