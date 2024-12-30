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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Directory</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            background-color: #f4f7f6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .family-head {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 25px;
            transition: transform 0.3s ease;
            position: relative;
        }

        .family-head:hover {
            transform: translateY(-5px);
        }

        .print-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .print-btn:hover {
            background-color: #2980b9;
        }

        .print-btn:active {
            transform: scale(0.95);
        }

        .print-btn svg {
            width: 20px;
            height: 20px;
        }

        .family-head h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .family-head img {
            border-radius: 50%;
            object-fit: contain;
            border: 4px solid #3498db;
            margin-bottom: 15px;
        }

        .family-head p {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }

        .family-head p strong {
            color: #2980b9;
            margin-right: 10px;
            min-width: 120px;
        }

        h3 {
            color: #2c3e50;
            margin-top: 20px;
            margin-bottom: 15px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        ul li {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        ul li:hover {
            background-color: #e9ecef;
        }

        ul li img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 3px solid #3498db;
            margin-bottom: 10px;
        }

        hr {
            border: none;
            height: 1px;
            background-color: #e0e0e0;
            margin: 30px 0;
        }

        @media screen and (max-width: 768px) {
            body {
                padding: 10px;
            }

            .family-head {
                padding: 20px;
            }

            ul {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            body {
                background-color: white;
            }
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 10px;">Family Directory</h1>

    <?php foreach ($family_data as $family_head_id => $family_head): ?>
        <div class="family-head" id="family-head-<?php echo $family_head_id; ?>">
            <button class="print-btn" onclick="printFamilyHead(<?php echo $family_head_id; ?>)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 9V2h12v7"/>
                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                    <rect x="6" y="14" width="12" height="8" rx="2"/>
                </svg>
                Print
            </button>
            <h2><?php echo htmlspecialchars($family_head['family_head_name']); ?></h2>
            <img src="data:image/jpeg;base64,<?php echo $family_head['family_head_photo']; ?>" alt="Family Head Photo" width="200" height="200">
            <p><strong>Native:</strong> <?php echo htmlspecialchars($family_head['family_native']); ?></p>
            <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($family_head['family_head_blood_group']); ?></p>
            <p><strong>Education:</strong> <?php echo htmlspecialchars($family_head['family_head_education']); ?></p>
            <p><strong>Contact:</strong> <?php echo htmlspecialchars($family_head['family_head_contact_num']); ?></p>
            <p><strong>Occupation:</strong> <?php echo htmlspecialchars($family_head['family_head_occupation']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($family_head['family_head_address']); ?></p>
            <h3>Family Members:</h3>
            <?php if (count($family_head['members']) > 0): ?>
                <ul>
                    <?php foreach ($family_head['members'] as $member): ?>
                        <li>
                            <img src="data:image/jpeg;base64,<?php echo $member['member_photo']; ?>" alt="Member Photo">
                            <h4><?php echo htmlspecialchars($member['member_name']); ?></h4>
                            <p><strong>Relation:</strong> <?php echo htmlspecialchars($member['member_relation']); ?></p>
                            <p><strong>DOB:</strong> <?php echo htmlspecialchars($member['member_dob']); ?></p>
                            <p><strong>Blood Group:</strong> <?php echo htmlspecialchars($member['member_blood_group']); ?></p>
                            <p><strong>Marital Status:</strong> <?php echo htmlspecialchars($member['member_marital_status']); ?></p>
                            <p><strong>Education:</strong> <?php echo htmlspecialchars($member['member_education']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No family members recorded.</p>
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>

    <script>
    function printFamilyHead(familyHeadId) {
    // Find the specific family head div
    const familyHeadDiv = document.getElementById(`family-head-${familyHeadId}`);
    
    // Create a new window for printing
    const printWindow = window.open('', '', 'width=800,height=600');
    
    // Recreate the styles for print
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Family Details</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    line-height: 1.6;
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 20px;
                }

                .family-head {
                    background-color: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                }

                .family-head h2 {
                    color: #2c3e50;
                    border-bottom: 2px solid #3498db;
                    padding-bottom: 10px;
                    margin-bottom: 20px;
                }

                .family-head img {
                    border-radius: 50%;
                    object-fit: cover;
                    border: 4px solid #3498db;
                    margin-bottom: 15px;
                }

                .family-head p {
                    margin: 10px 0;
                    display: flex;
                    align-items: center;
                }

                .family-head p strong {
                    color: #2980b9;
                    margin-right: 10px;
                    min-width: 120px;
                }

                ul {
                    list-style-type: none;
                    padding: 0;
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                    gap: 20px;
                }

                ul li {
                    background-color: #f8f9fa;
                    border-radius: 8px;
                    padding: 15px;
                    text-align: center;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                ul li img {
                    border-radius: 50%;
                    width: 100px;
                    height: 100px;
                    object-fit: cover;
                    border: 3px solid #3498db;
                    margin-bottom: 10px;
                }
            </style>
        </head>
        <body>
            <div class="family-head">
                ${familyHeadDiv.innerHTML.replace(/<button.*?<\/button>/, '')}
            </div>
        </body>
        </html>
    `);
    
    // Close the document to render content
    printWindow.document.close();
    
    // Trigger print dialog
    printWindow.print();
    
    // Close the print window
    printWindow.close();
}
    </script>
</body>
</html>