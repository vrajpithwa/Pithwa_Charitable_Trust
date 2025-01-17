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
    <link rel="icon" href="./favicon.png">
    <link rel="canonical" href="https://www.pithwacharitabletrust.org">
    <link rel="shortlink" href="https://www.pithwacharitabletrust.org">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        @font-face {
            font-family: 'logo';
            src: url('./COOPBL.TTF') format('truetype');
        }

        .header img {
            max-width: 250px;
            height: auto;
            flex-shrink: 0;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: rgb(194, 240, 252);
            color: rgb(19, 19, 19);
            padding: 20px;
            margin-bottom: 30px;
        }

        .header-text {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header h1 {
            font-size: clamp(40px, 4vw, 60px);
            margin: 0 25px 10px;
            font-family: 'logo';
            color: rgb(60, 42, 152);
            text-align: center;
            font-weight: normal;
        }

        .header p {
            font-size: clamp(18px, 2vw, 25px);
            text-align: left;
            margin-top: 5px;
        }

        .red-line {
            border: none;
            border-top: 2px solid red;
            width: 100%;
            margin: 5px 0;
        }

        @media (min-width: 1024px) {
            .header {
                justify-content: flex-start;
            }

            .header img {
                max-width: 300px;
            }

            .header h1 {
                font-size: 55px;
                margin-right: 20px;
            }

            .header div {
                margin-left: 20px;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            .header-text {
                align-items: center;
                width: 100%;
            }

            .header img {
                max-width: 80%;
                margin-bottom: 15px;
            }

            .header h1 {
                font-size: clamp(30px, 5vw, 50px);
                text-align: center;
            }
        }

        .content {
            display: flex;
            gap: 30px;
        }

        .column {
            flex: 1;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
        }

        .card h2 {
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .mission-list {
            list-style-type: disc;
            padding-left: 30px;
            font-weight: bold;
        }

        .bank-details {
            display: grid;
            gap: 10px;
        }

        .activities {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .activity-item {
            background-color: #3498db;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .activity-item:hover {
            background-color: #2980b9;
        }

        .donors {
            background-color: white;
            padding: 20px;
            text-align: center;
            margin-top: 30px;
            border-radius: 10px;
        }

        .donor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .donor-item {
            background-color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            font-weight: bold;
        }

        .event-card {
            background-color: #FFFFFFFF;
            color: #000000FF;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
        }

        footer {
            text-align: center;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            margin-top: 30px;
        }

        .designer-credit {
            text-align: center;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            font-size: 14px;
        }

        .designer-credit a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .designer-credit a:hover {
            color: #2ecc71;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
            .header-text {
                align-items: center;
                width: 100%;
            }

            .activities {
                grid-template-columns: 1fr;
            }

            .donor-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Floating Card Styles */
        .floating-card {
            height: 150px;
            width: 210px;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color:whitesmoke;
    background-image: url('frame.png'); /* Add your image URL here */
    background-size:cover; /* Make sure the image covers the entire card */
    background-position: center; /* Ensure the image is centered */
    color: black;
    padding: 17px;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    z-index: 1000;
    transition: transform 0.3s ease;
}

.floating-card:hover {
    transform: translateY(-5px);
}

        .floating-content {
            
            text-align: center;
        }

        .floating-content h3 {
         
            margin: 13px 0 5px 0;
            font-size: 1.2em;
        }

        .floating-content p {
            margin: 0;
            font-size: 0.9em;
        }

        .click-text {
            font-size: 0.8em;
            margin-top: 5px;
            opacity: 0.9;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1001;
        }

        .invitation-image {
    width: 30%;
    height: auto;
    display: block;
    border-radius: 10px;
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
}


        .close-button {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 30px;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
        }

        .close-button:hover {
            color: #000;
        }

        .modal h2 {
            text-align: center;
            color: #c90000;
            margin-bottom: 30px;
            font-size: 2em;
        }

        .invitation-details {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .detail-section {
            text-align: center;
        }

        .detail-section h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.3em;
        }

        .program-schedule {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sponsorship-box {
            background-color: #fff1f1;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }

        .sponsorship-box h3 {
            color: #c90000;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .modal-content {
                width: 100%;
                margin: 10px;
                padding: 20px;
            }
            .invitation-image {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 10px;
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
}

            .floating-card {
                bottom: 10px;
                right: 10px;
            }
        }
        .floating-donate-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #3c2a98;
    color: white;
    padding: 12px 24px;
    font-size: 20px;
    font-weight: bold;
    text-decoration: none;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, transform 0.3s ease;
    z-index: 1000;
}

.floating-donate-btn:hover {
    background-color: #a70000;
    transform: translateY(-5px);
}

    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <img src="./logo_transparent.jpeg" alt="Logo" class="logo" />
            <div class="header-text">
                <h1>Pithwa Charitable Trust</h1>
                <hr class="red-line" />
                <p class="tagline">Unity, Service, Prosperity, Cooperation, Education</p>
            </div>
            <a href="https://www.pithwacharitabletrust.org/donate" class="floating-donate-btn">Donate Now</a>

        </header>

        <!-- Content -->
        <div class="content">
            <div class="column">
                <div class="card">
                    <h2>Our Mission</h2>
                    <p>The Pithwa Charitable Trust is dedicated to uplifting society by providing crucial support to financially needy families:</p>
                    <ul class="mission-list">
                        <li>Medical Assistance</li>
                        <li>Educational Support</li>
                        <li>Widow Welfare</li>
                        <li>Group Marriage Support</li>
                        <li>Community Welfare Initiatives</li>
                    </ul>
                </div>
                <div class="card">
                    <h2>Donation Information</h2>
                    <div class="bank-details">
                        <div>
                            <strong>Bank Details:</strong>
                            <p>Bank of India, Gomtipur Branch</p>
                            <p>A/C No: 202510210000169</p>
                            <p>IFSC: BKID0002025</p>
                        </div>
                        <div>
                            <strong>Tax Benefits:</strong>
                            <p>80G and CSR Certificate Available</p>
                            <p>URN: AAFTP6755NF20241</p>
                            <p>PAN: AAFTP6755N</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <h2>Our Activities</h2>
                    <div class="activities">
                        <div class="activity-item">Admin Brothers Meeting</div>
                        <div class="activity-item">Educational-help / Seminar</div>
                        <div class="activity-item">Medical Camp</div>
                        <div class="activity-item">Women Admin Group</div>
                        <div class="activity-item">
                            <a href="./mou.html" style="color: white; text-decoration: none;">MOU for Medical Initiatives</a>
                        </div>
                        <div class="activity-item">
                            <a href="./downloads.html" style="color: white; text-decoration: none; font-weight: bold;">Download Documents</a>
                        </div>
                    </div>
                </div>
                <div class="event-card">
                    <h2>Past Events: </h2><h2>Snehamilan Ceremony</h2>
                    <p>Date: Saturday, 11th January 2025</p>
                    <p>Location: Chotila</p>
                    <p>Sponsorship Opportunities Available!</p>
                </div>
            </div>
        </div>

        <!-- Donors -->
        <div class="donors">
            <h2>Our Valued Donors</h2>
            <div class="donor-grid">
                <div class="donor-item">Konark Plastomech Pvt. Ltd. <br> Shri Kantibhai Pragjibhai Pithwa</div>
                <div class="donor-item">Saurashtra Engg. Ahmedabad <br> Shri Kantibhai Ranchhodbhai Pithwa </div>
                <div class="donor-item">Community Supporters</div>
            </div>
        </div>

        <!-- Footer -->
        <footer>
            <p>Pithwa Charitable Trust - Serving Humanity with Grace</p>
            <p>Contact: info@pithwacharitabletrust.org</p>
            <p>With the infinite grace of Ishtadev Shri Vishwakarma Dada</p>
            <p>Jaza Haath Raliyamana</p>
            <p>Jai Vishwakarma 🙏 </p>
        </footer>
        <div class="designer-credit">
            <p><a href="https://vraj.ketanpithva.com" target="_blank">Designed and Developed by: Vraj Pithwa</a></p>
            <p>Distributed by: Ketan Pithwa</p>
        </div>
    </div>

    

    <!-- JavaScript for Floating Card and Modal -->
    <script>
        // Get DOM elements
        const floatingCard = document.getElementById('floatingCard');
        const modal = document.getElementById('invitationModal');
        const closeButton = document.querySelector('.close-button');

        // Open modal when floating card is clicked
        floatingCard.addEventListener('click', () => {
            modal.style.display = 'block';
            floatingCard.style.display = 'none';
        });

        // Close modal when close button is clicked
        closeButton.addEventListener('click', () => {
            modal.style.display = 'none';
            floatingCard.style.display = 'block';
        });

        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
                floatingCard.style.display = 'block';
            }
        });
    </script>
</body>
</html>