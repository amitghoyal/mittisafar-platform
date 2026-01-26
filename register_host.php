<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MittiSafar- Host Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
     <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
            <link rel="stylesheet" href="assets/css/flaticon.css">
            <link rel="stylesheet" href="assets/css/price_rangs.css">
            <link rel="stylesheet" href="assets/css/slicknav.css">
            <link rel="stylesheet" href="assets/css/animate.min.css">
            <link rel="stylesheet" href="assets/css/magnific-popup.css">
            <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
            <link rel="stylesheet" href="assets/css/themify-icons.css">
            <link rel="stylesheet" href="assets/css/slick.css">
            <link rel="stylesheet" href="assets/css/nice-select.css">
            <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body{
           background-color: #28395a;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 731px;
            background-image: url(assets/img/gallery/how-applybg.png);
        }
        .form-container {
            max-width: 700px;
            margin: 60px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
            border-top: 8px solid #ff7b00;
        }

        .form-title {
            text-align: center;
            color: #0b1c39;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .form-group label {
            font-weight: 600;
            color: #0b1c39;
        }

        input.error,
        select.error {
            border-color: red !important;
            background-color: #ffe6e6;
        }

        small.error-message {
            color: red;
            font-size: 13px;
            display: none;
        }

        .form-group.success input,
        .form-group.success select {
            border-color: #28a745;
        }

        .btn-primary {
            background-color: #ff7b00;
            border-color: #ff7b00;
        }

        .btn-primary:hover {
            background-color: #0b1c39;
            border-color: #0b1c39;
        }

        .btn-reset {
            background-color: #0b1c39;
            color: #fff;
        }
        
        .btn-reset:hover {
            background-color: #ff7b00;
        }
    input.error {
    border: 2px solid red !important;
    background-color: #ffe6e6;
}

input.success {
    border: 2px solid green !important;
    background-color: #e6ffe6;
}

    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">MittiSafar - Host Registration Form</h2>
            <?php
if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
}
?>
            <form id="registrationForm" enctype="multipart/form-data" method="post" action="process_host_registration.php">
                <!-- First Name & Last Name -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="first_name">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" oninput="validateFirstName()">
                        <small class="error-message" id="first_name_error">First name must contain only letters and be between 2-15 characters.</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="last_name">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" oninput="validateLastName()">
                        <small class="error-message" id="last_name_error">Last name must contain only letters and be between 2-15 characters.</small>
                    </div>
                </div>

                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="10-digit Phone Number" oninput="validatePhoneNumber()">
                    <small class="error-message" id="phone_number_error">Please enter a valid 10-digit phone number.</small>
                </div>

                <!-- Date of Birth -->
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" oninput="validateDOB()">
                    <small class="error-message" id="dob_error">You must be at least 14 years old to register.</small>
                </div>

                <!-- Gender -->
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="gender" oninput="validateGender()">
                        <option value="" disabled selected>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <small class="error-message" id="gender_error">Please select a gender.</small>
                </div>

                <div class="form-row">
    <!-- State Selection -->
    <div class="form-group col-md-4">
        <label for="state">State</label>
        <select class="form-control" id="state" name="state" onchange="loadDistricts()">
            <option value="" disabled selected>Select State</option>
            <option value="Gujarat">Gujarat</option>
            <option value="Maharashtra">Maharashtra</option>
            <option value="Rajasthan">Rajasthan</option>
            <option value="Madhya Pradesh">Madhya Pradesh</option>
            <option value="Uttar Pradesh">Uttar Pradesh</option>
        </select>
        <small class="error-message text-danger" id="state_error">Please select your state.</small>
    </div>

    <!-- District Selection -->
    <div class="form-group col-md-4">
        <label for="district">District</label>
        <select class="form-control" id="district" name="district" onchange="loadVillages()">
            <option value="" disabled selected>Select District</option>
        </select>
        <small class="error-message text-danger" id="district_error">Please select your district.</small>
    </div>

    <!-- Village Selection -->
    <div class="form-group col-md-4">
        <label for="village">Village</label>
        <select class="form-control" id="village" name="village">
            <option value="" disabled selected>Select Village</option>
        </select>
        <small class="error-message text-danger" id="village_error">Please select your village.</small>
    </div>
</div>

<!-- Pincode -->
                <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" oninput="validatePincode()">
                    <small class="error-message" id="pincode_error">Please enter a valid 6-digit pincode.</small>
                </div>

                <!-- Profile Photo -->
                <div class="form-group">
                    <label for="profile_photo">Profile Photo</label>
                    <input type="file" class="form-control-file" id="profile_photo" name="profile_photo">
                    <small class="error-message" id="profile_photo_error">Profile photo must be JPG or PNG format and under 2.5 MB.</small>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com">
                    <small class="error-message" id="email_error">Please enter a valid email address.</small>
                </div>

                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                    <small class="error-message" id="username_error">Username must be a combination of letters, numbers, and special characters (min. 6 characters).</small>
                </div>

                <!-- Password & Confirm Password -->
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <small class="error-message" id="password_error">Password must be a combination of letters, digits, and special characters (min. 6 characters).</small>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                        <small class="error-message" id="confirm_password_error">Passwords do not match.</small>
                    </div>
                </div>

                <!-- Submit & Reset Buttons -->
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                <button type="reset" class="btn btn-reset btn-block">Reset</button>
            </form>
        </div>
    </div>

<script>
let isFirstNameValid = false;
let isLastNameValid = false;
let isPhoneNumberValid = false;
let isDobValid = false;
let isGenderValid = false;
let isStateValid = false;
let isDistrictValid = false;
let isVillageValid = false;
let isProfilePhotoValid = false;
let isEmailValid = false;
let isUsernameValid = false;
let isPasswordValid = false;
let isConfirmPasswordValid = false;

function validateFirstName() {
    let firstName = document.getElementById("first_name");
    let errorMessage = document.getElementById("first_name_error");
    let regex = /^[A-Za-z]{2,15}$/; 

    if (!regex.test(firstName.value)) {
        firstName.classList.add("error");
        firstName.classList.remove("success");
        errorMessage.style.display = "block";
        isFirstNameValid = false;
    } else {
        firstName.classList.add("success");
        firstName.classList.remove("error");
        errorMessage.style.display = "none";
        isFirstNameValid = true;
    }
}

function validateLastName() {
    let lastName = document.getElementById("last_name");
    let errorMessage = document.getElementById("last_name_error");
    let regex = /^[A-Za-z]{2,15}$/; 

    if (!regex.test(lastName.value)) {
        lastName.classList.add("error");
        lastName.classList.remove("success");
        errorMessage.style.display = "block";
        isLastNameValid = false;
    } else {
        lastName.classList.add("success");
        lastName.classList.remove("error");
        errorMessage.style.display = "none";
        isLastNameValid = true;
    }
}

function validatePhoneNumber() {
    let phone = document.getElementById("phone_number");
    let errorMessage = document.getElementById("phone_number_error");
    
    let regex = /^[6-9]\d{9}$/;  // Starts with 6-9, followed by 9 digits
    let invalidNumbers = ["0000000000", "1111111111", "2222222222", "3333333333",
                          "4444444444", "5555555555", "6666666666", "7777777777",
                          "8888888888", "9999999999"];  // Disallowed repeated numbers

    if (!regex.test(phone.value) || invalidNumbers.includes(phone.value)) {
        phone.classList.add("error");
        phone.classList.remove("success");
        errorMessage.style.display = "block";
        isPhoneNumberValid = false;
    } else {
        phone.classList.add("success");
        phone.classList.remove("error");
        errorMessage.style.display = "none";
        isPhoneNumberValid = true;
    }
}

function validateDOB() {
    let dob = document.getElementById("dob");
    let errorMessage = document.getElementById("dob_error");

    let today = new Date();
    let minAge = 14;
    let maxAge = 85;

    let minDate = new Date(today.getFullYear() - minAge, today.getMonth(), today.getDate()); // 14 years ago
    let maxDate = new Date(today.getFullYear() - maxAge, today.getMonth(), today.getDate()); // 85 years ago

    let dobDate = new Date(dob.value);

    if (dob.value === "" || dobDate > minDate || dobDate < maxDate) {
        dob.classList.add("error");
        dob.classList.remove("success");
        errorMessage.style.display = "block";
        isDobValid = false;
    } else {
        dob.classList.add("success");
        dob.classList.remove("error");
        errorMessage.style.display = "none";
        isDobValid = true;
    }
}

function validateGender() {
    let gender = document.getElementById("gender");
    let errorMessage = document.getElementById("gender_error");

    if (gender.value === "") {
        gender.classList.add("error");
        gender.classList.remove("success");
        errorMessage.style.display = "block";
        isGenderValid = false;
    } else {
        gender.classList.add("success");
        gender.classList.remove("error");
        errorMessage.style.display = "none";
        isGenderValid = true;
    }
}


function validateState() {
    let state = document.getElementById("state");
    let errorMessage = document.getElementById("state_error");

    if (state.value === "") {
        state.classList.add("error");
        state.classList.remove("success");
        errorMessage.style.display = "block";
        isStateValid = false;
    } else {
        state.classList.add("success");
        state.classList.remove("error");
        errorMessage.style.display = "none";
        isStateValid = true;
    }
}

function validateDistrict() {
    let district = document.getElementById("district");
    let errorMessage = document.getElementById("district_error");

    if (district.value === "") {
        district.classList.add("error");
        district.classList.remove("success");
        errorMessage.style.display = "block";
        isDistrictValid = false;
    } else {
        district.classList.add("success");
        district.classList.remove("error");
        errorMessage.style.display = "none";
        isDistrictValid = true;
    }
}

function validateVillage() {
    let village = document.getElementById("village");
    let errorMessage = document.getElementById("village_error");

    if (village.value === "") {
        village.classList.add("error");
        village.classList.remove("success");
        errorMessage.style.display = "block";
        isVillageValid = false;
    } else {
        village.classList.add("success");
        village.classList.remove("error");
        errorMessage.style.display = "none";
        isVillageValid = true;
    }
}

const districtData = {
    Gujarat: ["Ahmedabad", "Surat", "Vadodara", "Rajkot"],
    Maharashtra: ["Mumbai", "Pune", "Nagpur", "Nashik"],
    Rajasthan: ["Jaipur", "Udaipur", "Jodhpur", "Kota"],
    "Madhya Pradesh": ["Bhopal", "Indore", "Gwalior", "Jabalpur"],
    "Uttar Pradesh": ["Lucknow", "Kanpur", "Varanasi", "Agra"]
};

const villageData = {
    Ahmedabad: ["Village A1", "Village A2", "Village A3"],
    Surat: ["Village S1", "Village S2", "Village S3"],
    Mumbai: ["Village M1", "Village M2", "Village M3"],
    Pune: ["Village P1", "Village P2", "Village P3"],
    Jaipur: ["Village J1", "Village J2", "Village J3"],
    Bhopal: ["Village B1", "Village B2", "Village B3"],
    Lucknow: ["Village L1", "Village L2", "Village L3"]
};

function loadDistricts() {
    const state = document.getElementById("state").value;
    const districtSelect = document.getElementById("district");

    districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';
    
    if (districtData[state]) {
        districtData[state].forEach(district => {
            let option = new Option(district, district);
            districtSelect.add(option);
        });
    }
}

function loadVillages() {
    const district = document.getElementById("district").value;
    const villageSelect = document.getElementById("village");

    villageSelect.innerHTML = '<option value="" disabled selected>Select Village</option>';
    
    if (villageData[district]) {
        villageData[district].forEach(village => {
            let option = new Option(village, village);
            villageSelect.add(option);
        });
    }
}

// Pincode Data Based on State and District
const pincodeData = {
    Gujarat: {
        Ahmedabad: ["380001", "380002", "380003"],
        Surat: ["395001", "395002", "395003"]
    },
    Maharashtra: {
        Mumbai: ["400001", "400002", "400003"],
        Pune: ["411001", "411002", "411003"]
    },
    Rajasthan: {
        Jaipur: ["302001", "302002", "302003"],
        Udaipur: ["313001", "313002", "313003"]
    },
    "Madhya Pradesh": {
        Bhopal: ["462001", "462002", "462003"],
        Indore: ["452001", "452002", "452003"]
    },
    "Uttar Pradesh": {
        Lucknow: ["226001", "226002", "226003"],
        Kanpur: ["208001", "208002", "208003"]
    }
};

// Validate Pincode Based on Selected State and District
function validatePincode() {
    let pincode = document.getElementById("pincode");
    let errorMessage = document.getElementById("pincode_error");

    let selectedState = document.getElementById("state").value;
    let selectedDistrict = document.getElementById("district").value;
    let enteredPincode = pincode.value.trim();

    if (!selectedState || !selectedDistrict) {
        errorMessage.innerText = "Please select a state and district first.";
        errorMessage.style.display = "block";
        pincode.classList.add("error");
        isPincodeValid = false;
        return;
    }

    let regex = /^[1-9][0-9]{5}$/;
    if (!regex.test(enteredPincode)) {
        errorMessage.innerText = "Pincode must be a 6-digit valid number.";
        errorMessage.style.display = "block";
        pincode.classList.add("error");
        isPincodeValid = false;
        return;
    }

    if (pincodeData[selectedState] && pincodeData[selectedState][selectedDistrict]) {
        if (pincodeData[selectedState][selectedDistrict].includes(enteredPincode)) {
            pincode.classList.add("success");
            pincode.classList.remove("error");
            errorMessage.style.display = "none";
            isPincodeValid = true;
        } else {
            errorMessage.innerText = "Invalid pincode for the selected district.";
            errorMessage.style.display = "block";
            pincode.classList.add("error");
            isPincodeValid = false;
        }
    } else {
        errorMessage.innerText = "No pincode data available for the selected district.";
        errorMessage.style.display = "block";
        pincode.classList.add("error");
        isPincodeValid = false;
    }
}

// Auto-Fill Pincode Suggestions Based on State & District Selection
function autofillPincode() {
    let pincodeInput = document.getElementById("pincode");
    let selectedState = document.getElementById("state").value;
    let selectedDistrict = document.getElementById("district").value;

    if (pincodeData[selectedState] && pincodeData[selectedState][selectedDistrict]) {
        let firstPincode = pincodeData[selectedState][selectedDistrict][0]; 
        pincodeInput.value = firstPincode; 
        validatePincode(); 
    }
}


// Validate Profile Photo
function validateProfilePhoto() {
    let fileInput = document.getElementById("profile_photo");
    let errorMessage = document.getElementById("profile_photo_error");

    if (fileInput.files.length === 0) {
        errorMessage.innerText = "Profile photo is required.";
        errorMessage.style.display = "block";
        fileInput.classList.add("error");
        isProfilePhotoValid = false;
        return false;
    }

    let file = fileInput.files[0];
    let fileSize = file.size / 1024 / 1024; // Convert to MB
    let fileType = file.type;

    let allowedTypes = ["image/jpeg", "image/png"];

    if (!allowedTypes.includes(fileType)) {
        errorMessage.innerText = "Only JPG and PNG images are allowed.";
        errorMessage.style.display = "block";
        fileInput.classList.add("error");
        isProfilePhotoValid = false;
        return false;
    }

    if (fileSize > 2.5) {
        errorMessage.innerText = "File size must be under 2.5 MB.";
        errorMessage.style.display = "block";
        fileInput.classList.add("error");
        isProfilePhotoValid = false;
        return false;
    }

    // If valid
    fileInput.classList.remove("error");
    errorMessage.style.display = "none";
    isProfilePhotoValid = true;
    return true;
}


// Attach event listener
document.getElementById("profile_photo").addEventListener("change", validateProfilePhoto);

function validateEmail() {
        let email = document.getElementById("email");
        let errorMessage = document.getElementById("email_error");

        let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (!regex.test(email.value)) {
            errorMessage.innerText = "Enter a valid email address (example@example.com).";
            email.classList.add("error");
            email.classList.remove("success");
            errorMessage.style.display = "block";
            isEmailValid = false;
        } else {
            email.classList.add("success");
            email.classList.remove("error");
            errorMessage.style.display = "none";
            isEmailValid = true;
        }
    }

document.getElementById("email").addEventListener("input", validateEmail);

function validateUsername() {
        let username = document.getElementById("username");
        let errorMessage = document.getElementById("username_error");

        let regex = /^[a-zA-Z0-9@_.-]{6,15}$/;

        if (!regex.test(username.value)) {
            errorMessage.innerText = "Username must be 6-15 characters and can include letters, numbers, @, _, -, .";
            username.classList.add("error");
            username.classList.remove("success");
            errorMessage.style.display = "block";
            isUsernameValid = false;
        } else {
            username.classList.add("success");
            username.classList.remove("error");
            errorMessage.style.display = "none";
            isUsernameValid = true;
        }
    }

    function validatePassword() {
    let password = document.getElementById("password");
    let errorMessage = document.getElementById("password_error");
    let strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,15}$/;

    if (!strongPasswordRegex.test(password.value)) {
        errorMessage.innerText = "Password must be 6-15 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.";
        password.classList.add("error");
        password.classList.remove("success");
        errorMessage.style.display = "block";
        isPasswordValid = false;
    } else {
        password.classList.add("success");
        password.classList.remove("error");
        errorMessage.style.display = "none";
        isPasswordValid = true;
    }
}

    function validateConfirmPassword() {
        let password = document.getElementById("password").value;
        let confirmPassword = document.getElementById("confirm_password");
        let errorMessage = document.getElementById("confirm_password_error");

        if (confirmPassword.value !== password) {
            errorMessage.innerText = "Passwords do not match.";
            confirmPassword.classList.add("error");
            confirmPassword.classList.remove("success");
            errorMessage.style.display = "block";
            isConfirmPasswordValid = false;
        } else {
            confirmPassword.classList.add("success");
            confirmPassword.classList.remove("error");
            errorMessage.style.display = "none";
            isConfirmPasswordValid = true;
        }
    }
document.getElementById("username").addEventListener("input", validateUsername);
document.getElementById("password").addEventListener("input", validatePassword);
document.getElementById("confirm_password").addEventListener("input", validateConfirmPassword);

document.getElementById("registrationForm").addEventListener("submit", function(event) {
    validateFirstName();
    validateLastName();
    validatePhoneNumber();
    validateDOB();
    validateGender();
    validateState();
    validateDistrict();
    validateVillage();
    validatePincode();
    validateProfilePhoto(); 
    validateEmail();
    validateUsername();
    validatePassword();
    validateConfirmPassword();

    if (!isFirstNameValid || !isLastNameValid || !isPhoneNumberValid || !isDobValid || 
        !isGenderValid || !isStateValid || !isDistrictValid || !isVillageValid ||  !isProfilePhotoValid ||
        !isPincodeValid || !isEmailValid || !isUsernameValid || !isPasswordValid || !isConfirmPasswordValid) {
        event.preventDefault();
        alert("Please correct the errors before submitting!");
    }
});
</script>
</body>
</html>
