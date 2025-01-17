                 
                 // Initialize AOS
                  AOS.init({
                    duration: 1000,
                    once: true,
                    offset: 100
                });
        
                // Navigation scroll effect
                const nav = document.querySelector('.nav');
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        nav.classList.add('scrolled');
                    } else {
                        nav.classList.remove('scrolled');
                    }
                });
        
                // Mobile menu toggle functionality
                const navToggle = document.querySelector('.nav-toggle');
                const navItems = document.querySelector('.nav-items');
                
        
                navToggle.addEventListener('click', () => {
                    navToggle.classList.toggle('active');
                    navItems.classList.toggle('active');
                });

                // Close mobile menu when clicking a link
                document.querySelectorAll('.nav-items a').forEach(link => {
                    link.addEventListener('click', () => {
                        navToggle.classList.remove('active');
                        navItems.classList.remove('active');
                    });
                });

                // Initialize Lightbox
                lightbox.option({
                    'resizeDuration': 200,
                    'wrapAround': true,
                    'showImageNumberLabel': false,
                    'fadeDuration': 300
                });
        
                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        document.querySelector(this.getAttribute('href')).scrollIntoView({
                            behavior: 'smooth'
                        });
                    });
                });
                
                  // Handle toggle button click
            navToggle.addEventListener('click', () => {
                navToggle.classList.toggle('active');
                navItems.classList.toggle('active');
        
                // Ensure the correct styles are applied when toggling
                if (navItems.classList.contains('active')) {
                    nav.style.background = 'var(--white)';
                    nav.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                } else if (window.scrollY === 0) {
                    nav.style.background = 'transparent';
                    nav.style.boxShadow = 'none';
                }
            });
        
            // Adjust styles when scrolling
            window.addEventListener('scroll', () => {
                if (window.scrollY > 0) {
                    nav.classList.add('scrolled');
                    if (!navItems.classList.contains('active')) {
                        nav.style.background = 'var(--white)';
                        nav.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
                    }
                } else {
                    nav.classList.remove('scrolled');
                    if (!navItems.classList.contains('active')) {
                        nav.style.background = 'transparent';
                        nav.style.boxShadow = 'none';
                    }
                }
            });


// Function to open the newsletter modal and display the image and PDF URL
function openModal(imageBase64, pdfUrl) {
    var modal = document.getElementById('newsletterModal');
    var modalImage = document.getElementById('modalImage');
    var modalPdfUrl = document.getElementById('modalPdfUrl');

    // Set the image and PDF URL in the modal
    modalImage.src = 'data:image/jpeg;base64,' + imageBase64;
    modalPdfUrl.textContent = pdfUrl;

    // Show the modal
    modal.style.display = 'block';
}

// Function to close the modal
function closeModal() {
    var modal = document.getElementById('newsletterModal');
    modal.style.display = 'none';
}

// Click event to close the modal if clicked outside the modal content
window.onclick = function(event) {
    var modal = document.getElementById('newsletterModal');
    var modalContent = document.querySelector('.modal-content');

    // If the user clicks anywhere outside the modal content, close the modal
    if (event.target == modal) {
        closeModal();
    }
}
