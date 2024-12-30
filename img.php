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
    // Validate main image upload
    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Image upload failed: ' . $_FILES['image']['error']]);
        exit;
    }

    // Validate image type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/*'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG and GIF allowed.']);
        exit;
    }

    // Read family head image file
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

    // Get family members data from JSON string
    $family_members = isset($_POST['family_members']) ? json_decode($_POST['family_members'], true) : [];

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert family head data
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
            // Get the last inserted family_head_id
            $family_head_id = mysqli_insert_id($conn);

            // Insert family members
            if (!empty($family_members)) {
                $member_query = "INSERT INTO family_members (
                    family_head_sr_no, 
                    member_name, 
                    member_photo,
                    member_relation, 
                    member_dob, 
                    member_blood_group, 
                    member_marital_status, 
                    member_education
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                
                $member_stmt = mysqli_prepare($conn, $member_query);

                foreach ($family_members as $index => $member) {
                    // Process member's photo
                    $member_photo = null;
                    if (isset($_FILES["member_photo_" . $index]) && $_FILES["member_photo_" . $index]['error'] === UPLOAD_ERR_OK) {
                        if (in_array($_FILES["member_photo_" . $index]['type'], $allowed_types)) {
                            $member_photo = file_get_contents($_FILES["member_photo_" . $index]['tmp_name']);
                        } else {
                            throw new Exception("Invalid file type for member " . ($index + 1));
                        }
                    }

                    mysqli_stmt_bind_param($member_stmt, "isssssss", 
                        $family_head_id, 
                        $member['name'],
                        $member_photo,
                        $member['relation'], 
                        $member['dob'], 
                        $member['blood_group'], 
                        $member['marital_status'], 
                        $member['education']
                    );
                    
                    if (!mysqli_stmt_execute($member_stmt)) {
                        throw new Exception("Error inserting family member: " . mysqli_stmt_error($member_stmt));
                    }
                }
                mysqli_stmt_close($member_stmt);
            }

            // Commit transaction
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