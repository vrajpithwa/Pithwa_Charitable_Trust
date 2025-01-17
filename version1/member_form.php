<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>પીઠવા ચેરિટેબલ ટ્રસ્ટ</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <style> 
        .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}
    </style>
</head>
<body>
<div class="container">
    <?php include "header.php";?>

        
        <div class="language-switcher-container">
            <label for="select-language" id="select-language">ભાષા બદલો:</label>
            <select id="language-switcher" onchange="changeLanguage(this.value)">
                <option value="en">English</option>
                <option value="gu">ગુજરાતી</option>
            </select>
        </div>

          


    <form class="form-data" id="main-form" enctype="multipart/form-data">
      <div>
      
    <label for="family-head" id="family-head-label">કૂટુંબના મુખ્ય વ્યક્તિનું નામ:</label>
    <input type="text" id="family-head" name="family-head" required><br>

    <img id="image-preview" class="avatar" src="./blank.png" alt="Avatar Placeholder" accept="
    image/*"
    >

    <label for="image" id="family-head-photo">પાસપોર્ટ સાઇઝનો ફોટો અપલોડ કરો</label>
    <input type="file" id="file-input" name="image" accept="image/*" required>
    
        <br><br>
    </div>
  
        <label for="village-name" id="village-name-label">કુટુંબનું મૂળ વતન:</label>
        <input type="text" id="village-name" name="village-name" required><br><br>

        <div class="input-row">
            <!-- <div>
                <label for="blood-group" id="blood-group-label">બ્લડ ગ્રુપ:</label>
                <input type="text" id="blood-group" name="blood-group">
            </div> -->
            <div>
        <label for="blood-group" id="blood-group-label">બ્લડ ગ્રુપ:</label>
        <select id="blood-group" name="blood-group" required>
            <option value="">પસંદ કરો</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="Don't Know">ખબર નથી</option>
        </select>   
    </div>
            <div>
                <label for="education" id="education-label">અભ્યાસ:</label>
                <input type="text" id="education" name="education">
            </div>
        </div>
        <br>
        <div class="input-row">
            <div>
                <label for="family-members-count" id="family-members-count-label">કુટુંબના સભ્યોની સંખ્યા:</label>
                <input type="number" id="family-members-count" name="family-members-count"><br><br>
            </div>
            <div>
                <label for="dob" id="dob-label">જન્મ તારીખ:</label>
                <input type="date" id="dob" name="dob"><br><br>
            </div>
        </div>
        <div id="family-member-container"></div>

        <label for="address" id="address-label">પત્ર વ્યવહારનું સરનામું:</label>
        <textarea id="address" name="address" rows="4" cols="50"></textarea><br><br>

        <div class="input-row">
            <div>
                <label for="phone" id="phone-label">સંપર્ક નંબર:</label>
                <input type="tel" id="phone" name="phone"><br><br>
            </div>
            <div>
                <label for="occupation" id="occupation-label">ધંધા/કાર્યનું નામ:</label>
                <input type="text" id="occupation" name="occupation"><br><br>
            </div>
        </div>

        <div class="input-row">
            <div>
                <label for="Matajimadh" id="mataji-label">તમારા માતાજીનો મઢ અને સુરાપુરા દાદા કઇ જગ્યાએ છે તે ગામ નું નામ લખો:</label>
                <input type="text" id="mataji" name="mataji"><br><br>
            </div>
            <!-- <div>
                <label for="add-family" id="add-family-label">કુટુંબના વ્યક્તિઓ ઉમેરો:</label><br><br>
                <input type="button" id="open-popup" value="Add family members:"><br><br>
            </div> -->
        </div>
<!-- 
        <table id="details-table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th id="tb-name">નામ:</th>
                    <th id="tb-rel">સંબંધ:</th>
                    <th id="tb-dob">જન્મ તારીખ:</th>
                    <th id="tb-bg">બ્લડ ગ્રુપ:</th>
                    <th id="tb-ms">વૈવાહિક સ્થિતિ:</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table> -->

        <label for="help" id="help-label">શું તમે પીઠવા ચેરિટેબલ ટ્રસ્ટને મદદ કરવા ઈચ્છતા છો?</label><br>
        <input type="radio" id="yes" name="help" value="yes">
        <label for="yes" id="yes-label">હા</label><br>
        <input type="radio" id="no" name="help" value="no">
        <label for="no" id="no-label">ના</label><br><br>

        <label for="suggestions" id="suggestions-label">અન્ય સૂચનાઓ/સંદેશો:</label>
        <textarea id="suggestions" name="suggestions" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="મોકલો" id="submit-button">
    </form>
     </div>

    <script>



        document.getElementById('file-input').onchange = function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};
        window.onload = function() {
            document.getElementById('language-switcher').value = 'en';
            changeLanguage('en');
        };

        const translations = {
            en: {
                'family-head-photo':'Upload passport size photo:',
                'tb-name':'Name',
                'tb-rel':'Relation',
                'tb-dob':'Date of birth',
                'tb-bg':'Blood Group',
                'tb-ms':'Marital Status',
                'select-language': 'Change Language:',
                'navbar-title': 'Pithwa Charitable Trust',
                'family-head-label': "Family Head's Name:",
                'village-name-label': "Family's Native Village:",
                'blood-group-label': 'Blood Group:',
                'education-label': 'Education:',
                'family-members-count-label': 'Number of Family Members:',
                'dob-label': 'Date of Birth:',
                'address-label': 'Postal Address:',
                'phone-label': 'Phone Number:',
                'occupation-label': 'Occupation:',
                'mataji-label': 'Write the name of the village where your Mataji’s shrine and Surapura Dada are located:',
                'add-family-label': 'Add Family Members:',
                'help-label': 'Would you like to help Pithwa Charitable Trust?',
                'yes-label': 'Yes',
                'no-label': 'No',
                'suggestions-label': 'Any Suggestions/Message:',
                'submit-button': 'Submit',
                'popup-title': 'Family Member Details',
                'popup-name-label': 'Name:',
                'popup-relation-label': 'Relation:',
                'popup-bdate-label': 'Birth Date:',
                'popup-blood-group-label': 'Blood Group:',
                'popup-marital-status-label': 'Marital Status:',
                'popup-submit': 'Submit',
                'select-blood': 'Select Blood Group',
                'dont-know': "Don't Know"
            },
            gu: {
                'select-blood': 'પસંદ કરો',
                'dont-know': 'ખબર નથી',
                'family-head-photo':'પાસપોર્ટ સાઇઝનો ફોટો અપલોડ કરો:',
                'tb-name':'નામ:',
                'tb-rel':'સંબંધ:',
                'tb-dob':'જન્મ તારીખ:',
                'tb-bg':'બ્લડ ગ્રુપ:',
                'tb-ms':'વૈવાહિક સ્થિતિ:',
                'select-language':'ભાષા બદલો:',
                'navbar-title': 'પીઠવા ચેરિટેબલ ટ્રસ્ટ',
                'family-head-label': "કૂટુંબના મુખ્ય વ્યક્તિનું નામ:",
                'village-name-label': "કુટુંબનું મૂળ વતન:",
                'blood-group-label': 'બ્લડ ગ્રુપ:',
                'education-label': 'અભ્યાસ:',
                'family-members-count-label': 'કુટુંબના સભ્યોની સંખ્યા:',
                'dob-label': 'જન્મ તારીખ:',
                'address-label': 'પત્ર વ્યવહારનું સરનામું:',
                'phone-label': 'સંપર્ક નંબર:',
                'occupation-label': 'ધંધા/કાર્યનું નામ:',
                'mataji-label': 'તમારા માતાજીનો મઢ અને સુરાપુરા દાદા કઇ જગ્યાએ છે તે ગામ નું નામ લખો:',
                'add-family-label': 'કુટુંબના વ્યક્તિઓ ઉમેરો:',
                'help-label': 'શું તમે પીઠવા ચેરિટેબલ ટ્રસ્ટને મદદ કરવા ઈચ્છતા છો?',
                'yes-label': 'હા',
                'no-label': 'ના',
                'suggestions-label': 'અન્ય સૂચનાઓ/સંદેશો:',
                'submit-button': 'મોકલો',
                'popup-title': 'કુટુંબના સભ્યની વિગત',
                'popup-name-label': 'નામ:',
                'popup-relation-label': 'સંબંધ:',
                'popup-bdate-label': 'જન્મ તારી    ખ:',
                'popup-blood-group-label': 'બ્લડ ગ્રુપ:',
                'popup-marital-status-label': 'વૈવાહિક સ્થિતિ:',
                'popup-submit': 'સબમિટ કરો'
            }
        };

        function changeLanguage(lang) {
            for (const key in translations[lang]) {
                const element = document.getElementById(key);
                if (element) {
                    element.innerText = translations[lang][key];
                }
            }
        }


        
         // Get family member count input and listen for changes
         document.getElementById('family-members-count').addEventListener('input', function() {
            generateFamilyMemberInputs(this.value);
        });

        function generateFamilyMemberInputs(count) {
    const container = document.getElementById('family-member-container');
    container.innerHTML = ''; // Clear previous inputs

    // Blood group options HTML
    const bloodGroupOptions = `
        <option value="">પસંદ કરો</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
        <option value="Don't Know">ખબર નથી</option>
    `;

    // Relation options HTML
    const relationOptions = `
        <option value="">પસંદ કરો</option>
        <option value="Spouse">Spouse</option>
        <option walue="Grand-father">Grand-Father</option>
        <option value="Father">Father</option>
        <option value="Father-inlaw">Father-inlaw</option>
        <option value="Grand-mother">Grand-Mother</option>
        <option value="Mother">Mother</option>
        <option value="Mother-inlaw">Mother-inlaw</option>
        <option value="Brother">Brother</option>
        <option value="Brother-inlaw">Brother-inlaw</option>
        <option value="Sister">Sister</option>
        <option value="Sister-inlaw">Sister-law</option>
        <option value="Grand-son">Grand-Son</option>
        <option value="Son">Son</option>
        <option value="Grand-daughter">Grand-Daughter</option>
        <option value="Daughter">Daughter</option>
        <option value="Daughter-inlaw">Daughter-law</option>
        
        

    `;

        // Marital status options HTML
        const maritalStatusOptions = `
        <option value="">પસંદ કરો</option>
        <option value="Single">Single</option>
        <option value="Married">Married</option>
        <option value="Engaged">Engaged</option>
        <option value="Widowed">Widowed</option>
        <option value="Divorced">Divorced</option>
    `;

    if (count > 0) {
        for (let i = 0; i < count; i++) {
            let memberDiv = document.createElement('div');
            memberDiv.className = 'family-member';
            memberDiv.innerHTML = `
                <h4>Family Member ${i + 1}</h4>
                <label for="name_${i}">Name:</label>
                <input type="text" name="name_${i}" required><br>

                <div class="photo-section">
                    <img id="member-preview-${i}" class="member-avatar" src="./blank.png" alt="Member Photo Preview" style="width: 100px; height: 100px; object-fit: cover;">
                    <label for="member_photo_${i}">Member's Photo:</label>
                    <input type="file" id="member_photo_${i}" name="member_photo_${i}" class="member-photo" accept="image/*" required><br>
                </div>

                <label for="relation_${i}">Relation:</label>
                <select name="relation_${i}" id="relation_${i}" required>
                    ${relationOptions}
                </select><br>

                <label for="dob_${i}">Date of Birth:</label>
                <input type="date" name="dob_${i}" required><br>

                <label for="blood_group_${i}">Blood Group:</label>
                <select name="blood_group_${i}" id="blood_group_${i}" required>
                    ${bloodGroupOptions}
                </select><br>

        <label for="marital_status_${i}">Marital Status:</label>
                <select name="marital_status_${i}" id="marital_status_${i}" required>
                    ${maritalStatusOptions}
                </select><br>

                <label for="education_${i}">Education:</label>
                <input type="text" name="education_${i}"><br><br>
            `;
            container.appendChild(memberDiv);

            // Add event listener for photo preview
            const photoInput = document.getElementById(`member_photo_${i}`);
            photoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(`member-preview-${i}`).src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    }
}

// Form submission handler
document.getElementById('main-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get the count of family members
    const familyMemberCount = parseInt(document.getElementById('family-members-count').value) || 0;
    
    // Create FormData object
    const formData = new FormData(this);
    
    // Collect family members data
    let familyMembers = [];
    for (let i = 0; i < familyMemberCount; i++) {
        let member = {
            name: document.querySelector(`input[name="name_${i}"]`).value,
            relation: document.querySelector(`select[name="relation_${i}"]`).value,
            dob: document.querySelector(`input[name="dob_${i}"]`).value,
            blood_group: document.querySelector(`select[name="blood_group_${i}"]`).value,
            marital_status: document.querySelector(`select[name="marital_status_${i}"]`).value,
            education: document.querySelector(`input[name="education_${i}"]`).value
        };
        familyMembers.push(member);

        // Add photo file to FormData if it exists
        const photoFile = document.querySelector(`#member_photo_${i}`).files[0];
        if (photoFile) {
            formData.append(`member_photo_${i}`, photoFile);
        }
    }
    
    // Add family members data as JSON string
    formData.append('family_members', JSON.stringify(familyMembers));

    // Submit form using fetch with improved error handling
    fetch('member_form_data_to_db.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! image status: ${response.status}`);
        }
        // First try to get the response as text
        return response.text();
    })
    .then(text => {
        // Try to parse the text as JSON
        try {
            const data = JSON.parse(text);
            if (data.status === 'success') {
                alert('Data saved successfully!');
                // Reset the form
                this.reset();
                // Reset all member preview images
                document.querySelectorAll('.member-avatar').forEach(img => {
                    img.src = './blank.png';
                });
            } else {
                alert('Error: ' + (data.message || 'Unknown error occurred'));
            }
        } catch (e) {
            console.error('Server response:', text);
            throw new Error('Invalid JSON response from server');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while saving the data: ' + error.message);
    });
});
         
       
    </script>
   
</body>
</html>
