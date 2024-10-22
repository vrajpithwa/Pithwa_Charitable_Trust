<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>પીઠવા ચેરિટેબલ ટ્રસ્ટ</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="navbar">
        <h1 class="navbar-title" id="navbar-title">પીઠવા ચેરિટેબલ ટ્રસ્ટ</h1>
        <div class="language-switcher-container">
            <label for="select-language" id="select-language">ભાષા બદલો:</label>
            <select id="language-switcher" onchange="changeLanguage(this.value)">
                <option value="en">English</option>
                <option value="gu">ગુજરાતી</option>
            </select>
        </div>
    </div>
          
    <img src="./logo.jpeg" class="centered-image" alt="Trust Logo" />

    <form class="form-data" action="img.php" method="POST" id="main-form" enctype="multipart/form-data">
      <div>
      
    <label for="family-head" id="family-head-label">કૂટુંબના મુખ્ય વ્યક્તિનું નામ:</label>
    <input type="text" id="family-head" name="family-head" required><br>

    <img id="image-preview" class="avatar" src="./blank.png" alt="Avatar Placeholder">

    <label for="image" id="family-head-photo">પાસપોર્ટ સાઇઝનો ફોટો અપલોડ કરો</label>
    <input type="file" id="file-input" name="image" accept="image/*" required>
    
        <br><br>
    </div>
  
        <label for="village-name" id="village-name-label">કુટુંબનું મૂળ વતન:</label>
        <input type="text" id="village-name" name="village-name" required><br><br>

        <div class="input-row">
            <div>
                <label for="blood-group" id="blood-group-label">બ્લડ ગ્રુપ:</label>
                <input type="text" id="blood-group" name="blood-group">
            </div>
            <div>
                <label for="education" id="education-label">અભ્યાસ:</label>
                <input type="text" id="education" name="education">
            </div>
        </div><br>

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
            <div>
                <label for="add-family" id="add-family-label">કુટુંબના વ્યક્તિઓ ઉમેરો:</label><br><br>
                <input type="button" id="open-popup" value="Add family members:"><br><br>
            </div>
        </div>

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
        </table>

        <label for="help" id="help-label">શું તમે પીઠવા ચેરિટેબલ ટ્રસ્ટને મદદ કરવા ઈચ્છતા છો?</label><br>
        <input type="radio" id="yes" name="help" value="yes">
        <label for="yes" id="yes-label">હા</label><br>
        <input type="radio" id="no" name="help" value="no">
        <label for="no" id="no-label">ના</label><br><br>

        <label for="suggestions" id="suggestions-label">અન્ય સૂચનાઓ/સંદેશો:</label>
        <textarea id="suggestions" name="suggestions" rows="4" cols="50"></textarea><br><br>

        <input type="submit" value="મોકલો" id="submit-button">
    </form>

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
                'popup-submit': 'Submit'
            },
            gu: {
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
                'popup-bdate-label': 'જન્મ તારીખ:',
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
    </script>
</body>
</html>
