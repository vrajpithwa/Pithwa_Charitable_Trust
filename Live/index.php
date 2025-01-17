<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="Pithwa Charitable Trust - Making a Difference">
    <meta property="og:description" content="Join Pithwa Charitable Trust in transforming communities through welfare, education, and healthcare support. Donate and be part of the change.">
    <meta property="og:image" content="URL_TO_IMAGE">
    <meta property="og:url" content="https://www.pithwacharitabletrust.org">
    <meta name="description" content="Discover Pithwa Charitable Trust, a non-profit organization dedicated to improving lives through community welfare, educational support, healthcare initiatives, and more. Join us in our mission to make a difference. Donate today.">
    <meta name="keywords" content="Pithwa Charitable Trust, Pithwa Trust, Charity,Charitable organizations in [Your City], Social welfare initiatives, Non-profit organization India, Charitable work in India, Community development, Donate to Pithwa Charitable Trust, Helping the less fortunate, Pithwa Trust donations, pithwa, vraj pithwa, Pithwa, Charity trust pithwa">
    <title>Pithwa Charitable Trust</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/index.css">
</head>
<body>
   <?php include "navbar.php"; ?>
    <section class="hero">
        <div class="hero-content" data-aos="fade-up">
            <h1>Pithwa Charitable Trust</h1>
            <p>Unity • Service • Prosperity • Cooperation • Education</p>
            <a href="#mission" class="btn">Learn More</a>
        </div>
    </section>

    <section id="mission" class="mission">
        <h2 class="section-title" data-aos="fade-up">Our Mission</h2>
        <div class="mission-grid">
            <div class="mission-card" data-aos="fade-up" data-aos-delay="100">
                <h3>Medical Assistance</h3>
                <p>Providing crucial medical support to financially needy families.</p>
            </div>
            <div class="mission-card" data-aos="fade-up" data-aos-delay="200">
                <h3>Educational Support</h3>
                <p>Empowering through education and knowledge sharing.</p>
            </div>
            <div class="mission-card" data-aos="fade-up" data-aos-delay="300">
                <h3>Widow Welfare</h3>
                <p>Supporting widows through various welfare initiatives.</p>
            </div>
        </div>
    </section>

    <section class="activities">
        <h2 class="section-title" data-aos="fade-up">Our Activities</h2>
        <div class="activities-grid">
            <div class="activity-card" data-aos="fade-up" data-aos-delay="100">
                <h3>Admin Brothers Meeting</h3>
                <p>Regular meetings to discuss and plan community initiatives.</p>
            </div>
            <div class="activity-card" data-aos="fade-up" data-aos-delay="200">
                <h3>Educational-help / Seminars</h3>
                <p>Knowledge sharing sessions for community development.</p>
            </div>
            <div class="activity-card" data-aos="fade-up" data-aos-delay="300">
                <h3>Medical Camps</h3>
                <p>Free health checkups and medical assistance camps.</p>
            </div>
            <div class="activity-card" data-aos="fade-up" data-aos-delay="300">
                <h3>Women Admin Group</h3>
                <p></p>
            </div>
            <div class="activity-card" data-aos="fade-up" data-aos-delay="300">
                <a href="mou.php" style="text-decoration: none; color: inherit;">
                    <h3>MOU for Medical Initiatives</h3>
                    <p>View our partnerships with healthcare providers to support the community.</p>
                </a>
            </div>

        </div>
    </section>
    <section class="main-gallery">
        <h2 class="section-title" data-aos="fade-up">Our Gallery</h2>
        <div class="main-gallery-grid">
        <a href="gallery.php?category=SnehaMilan_11-01-2025" data-aos="fade-up" data-aos-delay="100" class="main-gallery-item">
            <img src="./snehamilan_banner1.jpeg" alt="SnehaMilan 11-01-2025" >
            <div class="main-gallery-overlay">
                <h3>Snehamilan_11-01-2025</h3>
                <p>.....</p>
            </div>
        </a>
        </div>
    </section>

    <section class="newsletters">
        <h2 class="section-title" data-aos="fade-up">Our Newsletters</h2>
        <div class="newsletter-grid">
            <!-- Newsletter Card 1 -->
<?php

include "db_connect.php";
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT * FROM newsletters ORDER BY newsletter_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '
        <div class="newsletter-card" data-aos="fade-up" data-aos-delay="100">
            <img src="data:image/jpeg;base64,' . $row['image_base64'] . '" alt="' . htmlspecialchars($row['title']) . '" class="newsletter-image">
            <div class="newsletter-content">
                <div class="newsletter-date">' . date("F Y", strtotime($row['newsletter_date'])) . '</div>
                <h3 class="newsletter-title">' . htmlspecialchars($row['title']) . '</h3>
                <p class="newsletter-excerpt">' . htmlspecialchars($row['excerpt']) . '</p>
                <a href="javascript:void(0);" class="newsletter-link" onclick="openModal(\'' . $row['image_base64'] . '\', \'' . $row['pdf_url'] . '\')">Read More →</a>
            </div>
        </div>';
    }
} else {
    echo "No newsletters available.";
}

$conn->close();
?>



        </div>
    </section>
    

    <section id="donors" class="donors">
        <h2 class="section-title" data-aos="fade-up">Our Valued Donors</h2>
        <div class="donors-grid">
            <div class="donor-card" data-aos="fade-up" data-aos-delay="100">
                <h3>Konark Plastomech Pvt. Ltd.</h3>
                <p>Shri Kantibhai Pragjibhai Pithwa</p>
            </div>
            <div class="donor-card" data-aos="fade-up" data-aos-delay="200">
                <h3>Saurashtra Engg. Ahmedabad</h3>
                <p>Shri Kantibhai Ranchhodbhai Pithwa</p>
            </div>
            <div class="donor-card" data-aos="fade-up" data-aos-delay="300">
                <h3>Community Supporters</h3>
                <p>Various generous contributors</p>
            </div>
        </div>
    </section>

    <section id="donate" class="donation">
        <h2 class="section-title" data-aos="fade-up">Make a Difference</h2>
        <div class="donation-content">
            <div class="donation-details" data-aos="fade-up">
                <h3>Bank Details</h3>
                <p>Bank of India, Gomtipur Branch</p>
                <p>A/C No: 202510210000169</p>
                <p>IFSC: BKID0002025</p>
                <h3 class="mt-4">Tax Benefits</h3>
                <p>80G and CSR Certificate Available</p>
                <p>URN: AAFTP6755NF20241</p>
                <p>PAN: AAFTP6755N</p>
            </div>
        </div>
    </section>

    <footer>
        <div  data-aos="fade-up">
            <h3>Pithwa Charitable Trust</h3>
            <p>Serving Humanity with Grace</p>
            <p>Contact: info@pithwacharitabletrust.org</p>
            <p>With the infinite grace of Ishtadev Shri Vishwakarma Dada</p>
            <p>Jaza Haath Raliyamana</p>
            <p>Jai Vishwakarma 🙏</p>
            <div class="designer-credit" style="margin-top: 2rem; font-size: 0.9rem;">
                <p><a href="https://vraj.ketanpithva.com" target="_blank" style="color: white; text-decoration: none;">Designed and Developed by: Vraj Pithwa</a></p>
                <p>Distributed by: Ketan Pithwa</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="./assets/js/index.js"></script>
    <!-- Modal for displaying image and PDF URL -->
<div id="newsletterModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div class="modal-image-container">
            <img id="modalImage" src="" alt="Newsletter Image" class="modal-image">
        </div>
        <div class="modal-text-container">
            <p><strong>PDF URL:</strong> <span id="modalPdfUrl"></span></p>
        </div>
    </div>
</div>
</body>


</html>