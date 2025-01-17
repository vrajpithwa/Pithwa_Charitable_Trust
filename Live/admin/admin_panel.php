<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCT Admin Dashboard</title>
    <style>
        :root {
            --primary: #3c2a98;
            --secondary: #ff6b6b;
            --background: #f8f9fa;
            --text: #2c3e50;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: var(--background);
            color: var(--text);
            line-height: 1.6;
            min-height: 100vh;
        }

        .admin-header {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 2rem;
            text-align: center;
        }

        .admin-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .admin-section {
            background: var(--white);
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .section-title {
            color: var(--primary);
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--secondary);
            font-size: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        label {
            color: var(--text);
            font-weight: 600;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        textarea {
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="file"] {
            padding: 0.5rem;
            background: white;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(60, 42, 152, 0.1);
        }

        button {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 1rem 2rem;
            border: none;
            border-radius: 2rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            align-self: flex-start;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .preview-image {
            max-width: 300px;
            margin-top: 1rem;
            border-radius: 0.5rem;
            display: none;
        }

        @media (max-width: 768px) {
            .admin-container {
                padding: 1rem;
            }

            .admin-section {
                padding: 1.5rem;
            }

            button {
                width: 100%;
            }
        }

        /* Success/Error Messages */
        .message {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <h1>Pithwa Charitable Trust - Admin Dashboard</h1>
    </header>

    <div class="admin-container">
    <section class="admin-section">
    <h2 class="section-title">Manage Newsletters</h2>
    <table id="newsletterTable" border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</section>


        <section class="admin-section">
            <h2 class="section-title">Add Newsletter</h2>
            <div id="newsletterMessage" class="message"></div>
            <form action="add_newsletter.php" method="POST" enctype="multipart/form-data" id="newsletterForm">
                <div class="form-group">
                    <label for="image">Newsletter Image:</label>
                    <input type="file" id="image" name="image" accept="image/*" required>
                    <img id="imagePreview" class="preview-image" alt="Preview">
                </div>

                <div class="form-group">
                    <label for="date">Newsletter Date:</label>
                    <input type="date" id="date" name="newsletter_date" required>
                </div>

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="excerpt">Description:</label>
                    <textarea id="excerpt" name="excerpt" required></textarea>
                </div>

                <div class="form-group">
                    <label for="pdf">URL:</label>
                    <input type="text" id="pdf" name="pdf_url" required>
                </div>

                <button type="submit">Add Newsletter</button>
            </form>
        </section>
 <!-- MOU Management -->
 <section class="admin-section">
            <h2 class="section-title">Manage MOUs</h2>
            <table id="mouTable" border="1" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Hospital Name</th>
                        <th>Details</th>
                        <th>Date</th>
                        <th>File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch MOU data
                    include "../db_connect.php";
                    $sql = "SELECT * FROM mou ORDER BY mou_date DESC";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row['hospital_name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['mou_details']) . '</td>';
                            echo '<td>' . date("F Y", strtotime($row['mou_date'])) . '</td>';
                            echo '<td>';
                            if ($row['file_type'] == 'pdf') {
                                echo '<a href="data:application/pdf;base64,' . base64_encode($row['file_content']) . '" target="_blank">View PDF</a>';
                            } elseif (in_array($row['file_type'], ['jpg', 'jpeg', 'png', 'gif'])) {
                                echo '<img src="data:image/' . $row['file_type'] . ';base64,' . base64_encode($row['file_content']) . '" alt="MOU Image" style="max-width: 100px;">';
                            }
                            echo '</td>';
                            echo '<td>
                                    <button onclick="editEntry(' . $row['id'] . ', \'mou\')">Edit</button>
                                    <button onclick="deleteEntry(' . $row['id'] . ', \'mou\')">Delete</button>
                                  </td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">No MOU records found.</td></tr>';
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>
        <section class="admin-section">
            <h2 class="section-title">Add MOU</h2>
            <div id="mouMessage" class="message"></div>
            <form action="mou_upload.php" method="POST" enctype="multipart/form-data" id="mouForm">
                <div class="form-group">
                    <label for="hospital_name">Hospital Name:</label>
                    <input type="text" id="hospital_name" name="hospital_name" required>
                </div>

                <div class="form-group">
                    <label for="mou_details">MOU Details:</label>
                    <textarea id="mou_details" name="mou_details" required></textarea>
                </div>

                <div class="form-group">
                    <label for="mou_date">Valid From:</label>
                    <input type="date" id="mou_date" name="mou_date" required>
                </div>

                <div class="form-group">
                    <label for="file_upload">MOU File (PDF or Image):</label>
                    <input type="file" id="file_upload" name="file_upload" accept="application/pdf, image/*" required>
                </div>

                <button type="submit">Add MOU</button>
            </form>
        </section>
    </div>

    <script>

        // Fetch and display newsletters
fetch('fetch_newsletters.php')
    .then(response => response.json())
    .then(data => {
        const newsletterTable = document.querySelector('#newsletterTable tbody');
        data.forEach(newsletter => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${newsletter.id}</td>
                <td>${newsletter.title}</td>
                <td>${newsletter.excerpt}</td>
                <td>${newsletter.newsletter_date}</td>
                <td><img src="${newsletter.image_url}" alt="Newsletter Image" style="max-width: 100px;"></td>
                <td>
                    <button onclick="editEntry(${newsletter.id}, 'newsletter')">Edit</button>
                    <button onclick="deleteEntry(${newsletter.id}, 'newsletter')">Delete</button>
                </td>
            `;
            newsletterTable.appendChild(row);
        });
    });


// Delete entry
function deleteEntry(id, type) {
    if (confirm('Are you sure you want to delete this entry?')) {
        fetch('delete_entry.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&type=${type}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success) location.reload();
        });
    }
}

        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>