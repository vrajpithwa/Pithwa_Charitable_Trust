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

// Query to retrieve family heads and their family members
$query = "
    SELECT 
        fh.sr_no AS family_head_id,
        fh.family_head_name,
        fh.family_head_photo,
        fh.family_native,
        fh.family_head_blood_group,
        fh.family_head_education,
        fh.family_members,
        fh.family_head_dob,
        fh.family_head_address,
        fh.family_head_contact_num,
        fh.family_head_occupation,
        fh.mataji_madh,
        fh.help_pct,
        fh.suggestions,
        fm.member_id,
        fm.member_name,
        fm.member_photo,
        fm.member_relation,
        fm.member_dob,
        fm.member_blood_group,
        fm.member_marital_status,
        fm.member_education
    FROM family_head_details fh
    LEFT JOIN family_members fm ON fh.sr_no = fm.family_head_sr_no
    ORDER BY fh.sr_no, fm.member_id
";

$result = mysqli_query($conn, $query);

$family_data = [];
if ($result) {
    // Organize data into an associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $family_head_id = $row['family_head_id'];
        
        // Initialize family head if not already in array
        if (!isset($family_data[$family_head_id])) {
            $family_data[$family_head_id] = [
                'family_head_name' => $row['family_head_name'],
                'family_head_photo' => base64_encode($row['family_head_photo']),
                'family_native' => $row['family_native'],
                'family_head_blood_group' => $row['family_head_blood_group'],
                'family_head_education' => $row['family_head_education'],
                'family_members' => $row['family_members'],
                'family_head_dob' => $row['family_head_dob'],
                'family_head_address' => $row['family_head_address'],
                'family_head_contact_num' => $row['family_head_contact_num'],
                'family_head_occupation' => $row['family_head_occupation'],
                'mataji_madh' => $row['mataji_madh'],
                'help_pct' => $row['help_pct'],
                'suggestions' => $row['suggestions'],
                'members' => []
            ];
        }

        // Add family member details to the family head
        if ($row['member_id']) {
            $family_data[$family_head_id]['members'][] = [
                'member_id' => $row['member_id'],
                'member_name' => $row['member_name'],
                'member_photo' => base64_encode($row['member_photo']),
                'member_relation' => $row['member_relation'],
                'member_dob' => $row['member_dob'],
                'member_blood_group' => $row['member_blood_group'],
                'member_marital_status' => $row['member_marital_status'],
                'member_education' => $row['member_education']
            ];
        }
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Family Head and Members</title>
</head>
<body>

<?php foreach ($family_data as $family_head): ?>
    <div class="family-head">
        <h2><?php echo htmlspecialchars($family_head['family_head_name']); ?></h2>
        <img src="data:image/jpeg;base64,<?php echo $family_head['family_head_photo']; ?>" alt="Family Head Photo" width="100" height="100">
        <p>Native: <?php echo htmlspecialchars($family_head['family_native']); ?></p>
        <p>Blood Group: <?php echo htmlspecialchars($family_head['family_head_blood_group']); ?></p>
        <p>Education: <?php echo htmlspecialchars($family_head['family_head_education']); ?></p>
        <p>Contact: <?php echo htmlspecialchars($family_head['family_head_contact_num']); ?></p>
        <p>Occupation: <?php echo htmlspecialchars($family_head['family_head_occupation']); ?></p>
        <p>Address: <?php echo htmlspecialchars($family_head['family_head_address']); ?></p>
        <h3>Family Members:</h3>
        <?php if (count($family_head['members']) > 0): ?>
            <ul>
                <?php foreach ($family_head['members'] as $member): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($member['member_name']); ?></strong><br>
                        <img src="data:image/jpeg;base64,<?php echo $member['member_photo']; ?>" alt="Member Photo" width="50" height="50"><br>
                        Relation: <?php echo htmlspecialchars($member['member_relation']); ?><br>
                        DOB: <?php echo htmlspecialchars($member['member_dob']); ?><br>
                        Blood Group: <?php echo htmlspecialchars($member['member_blood_group']); ?><br>
                        Marital Status: <?php echo htmlspecialchars($member['member_marital_status']); ?><br>
                        Education: <?php echo htmlspecialchars($member['member_education']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No family members recorded.</p>
        <?php endif; ?>
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>
