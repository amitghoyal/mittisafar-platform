<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MittiSafar - Traveler Registration Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        body {
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
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <h2 class="form-title">MittiSafar - Traveller Registration Form</h2>
<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>

    <!-- Display Success Message -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success']; 
                unset($_SESSION['success']); // Clear success message after displaying
            ?>
        </div>
    <?php endif; ?>
        <form id="registrationForm" enctype="multipart/form-data" method="post" action="process_traveler_registration.php">
            
            <!-- First Name & Last Name -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name">
                    <small class="error-message">First name must contain only letters and be between 2-15 characters.</small>
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name">
                    <small class="error-message">Last name must contain only letters and be between 2-15 characters.</small>
                </div>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number">
                <small class="error-message">Please enter a valid 10-digit phone number.</small>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob">
                <small class="error-message">You must be at least 14 years old to register.</small>
            </div>

            <!-- Gender -->
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <small class="error-message">Please select a gender.</small>
            </div>

            <!-- Nationality -->
            <div class="form-group">
                <label for="nationality">Nationality</label>
                <input type="text" class="form-control" id="nationality" name="nationality">
                <small class="error-message">Nationality must contain only letters.</small>
            </div>

            <!-- Emergency Contact -->
            <div class="form-group">
                <label for="emergency_contact">Emergency Contact Number</label>
                <input type="text" class="form-control" id="emergency_contact" name="emergency_contact">
                <small class="error-message">Please enter a valid 10-digit emergency contact number.</small>
            </div>
            
            <!-- Profile Photo -->
            <div class="form-group">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" class="form-control-file" id="profile_photo" name="profile_photo">
                <small class="error-message">Profile photo must be JPG or PNG format and under 2.5 MB.</small>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
                <small class="error-message">Please enter a valid email address.</small>
            </div>

            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username">
                <small class="error-message">Username must be at least 6 characters long.</small>
            </div>

            <!-- Password & Confirm Password -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="error-message">Password must contain at least 6 characters, including a number and a special character.</small>
                </div>
                <div class="form-group col-md-6">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                    <small class="error-message">Passwords do not match.</small>
                </div>
            </div>

            <!-- Submit & Reset Buttons -->
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
            <button type="reset" class="btn btn-reset btn-block">Reset</button>
        </form>
    </div>
</div>
</body>
<script>
    // Validation flags
    let isFirstNameValid = false;
    let isLastNameValid = false;
    let isPhoneNumberValid = false;
    let isDobValid = false;
    let isGenderValid = false;
    let isNationalityValid = false;
    let isEmergencyContactValid = false;
    let isProfilePhotoValid = false;
    let isEmailValid = false;
    let isUsernameValid = false;
    let isPasswordValid = false;
    let isConfirmPasswordValid = false;

// Function to show error
function showError(input, message) {
    input.classList.add("error");
    
    // Find the error message within the same form-group
    let errorMessage = input.closest(".form-group").querySelector(".error-message");
    if (errorMessage) {
        errorMessage.style.display = "block";
        errorMessage.innerText = message;
    }
}

// Function to remove error
function removeError(input) {
    input.classList.remove("error");
    
    // Find the error message within the same form-group
    let errorMessage = input.closest(".form-group").querySelector(".error-message");
    if (errorMessage) {
        errorMessage.style.display = "none";
    }
}

    // First Name Validation
    document.getElementById("first_name").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^[A-Za-z]{2,15}$/;
        if (!regex.test(value)) {
            showError(this, "First name must contain only letters (2-15 characters).");
            isFirstNameValid = false;
        } else {
            removeError(this);
            isFirstNameValid = true;
        }
    });

    // Last Name Validation
    document.getElementById("last_name").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^[A-Za-z]{2,15}$/;
        if (!regex.test(value)) {
            showError(this, "Last name must contain only letters (2-15 characters).");
            isLastNameValid = false;
        } else {
            removeError(this);
            isLastNameValid = true;
        }
    });

    // Phone Number Validation
    document.getElementById("phone_number").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^[6-9]\d{9}$/;
        if (!regex.test(value)) {
            showError(this, "Please enter a valid 10-digit phone number.");
            isPhoneNumberValid = false;
        } else {
            removeError(this);
            isPhoneNumberValid = true;
        }
    });

    // Date of Birth Validation (Must be at least 14 years old)
    document.getElementById("dob").addEventListener("change", function() {
        let dob = new Date(this.value);
        let today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        if (age < 14) {
            showError(this, "You must be at least 14 years old.");
            isDobValid = false;
        } else {
            removeError(this);
            isDobValid = true;
        }
    });

    // Gender Validation
    document.getElementById("gender").addEventListener("change", function() {
        if (this.value === "") {
            showError(this, "Please select a gender.");
            isGenderValid = false;
        } else {
            removeError(this);
            isGenderValid = true;
        }
    });

    // Nationality Validation
    document.getElementById("nationality").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^[A-Za-z\s]+$/;
        if (!regex.test(value)) {
            showError(this, "Nationality must contain only letters.");
            isNationalityValid = false;
        } else {
            removeError(this);
            isNationalityValid = true;
        }
    });

    // Emergency Contact Validation
    document.getElementById("emergency_contact").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^[6-9]\d{9}$/;
        if (!regex.test(value)) {
            showError(this, "Please enter a valid 10-digit emergency contact number.");
            isEmergencyContactValid = false;
        } else {
            removeError(this);
            isEmergencyContactValid = true;
        }
    });

    // Profile Photo Validation
    document.getElementById("profile_photo").addEventListener("change", function() {
        let file = this.files[0];
        if (file) {
            let allowedTypes = ["image/jpeg", "image/png"];
            if (!allowedTypes.includes(file.type) || file.size > 2.5 * 1024 * 1024) {
                showError(this, "Profile photo must be JPG or PNG and under 2.5 MB.");
                isProfilePhotoValid = false;
            } else {
                removeError(this);
                isProfilePhotoValid = true;
            }
        }
    });

    // Email Validation
    document.getElementById("email").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!regex.test(value)) {
            showError(this, "Please enter a valid email address.");
            isEmailValid = false;
        } else {
            removeError(this);
            isEmailValid = true;
        }
    });

    // Username Validation
    document.getElementById("username").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^[a-zA-Z0-9._-]{6,}$/;
        if (!regex.test(value)) {
            showError(this, "Username must be at least 6 characters long.");
            isUsernameValid = false;
        } else {
            removeError(this);
            isUsernameValid = true;
        }
    });

    // Password Validation
    document.getElementById("password").addEventListener("input", function() {
        let value = this.value.trim();
        let regex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
        if (!regex.test(value)) {
            showError(this, "Password must contain at least 6 characters, including a number and a special character.");
            isPasswordValid = false;
        } else {
            removeError(this);
            isPasswordValid = true;
        }
    });

    // Confirm Password Validation
    document.getElementById("confirm_password").addEventListener("input", function() {
        let password = document.getElementById("password").value.trim();
        let confirmPassword = this.value.trim();
        if (confirmPassword !== password || confirmPassword === "") {
            showError(this, "Passwords do not match.");
            isConfirmPasswordValid = false;
        } else {
            removeError(this);
            isConfirmPasswordValid = true;
        }
    });

    // Form Submission
    document.getElementById("registrationForm").addEventListener("submit", function(event) {
        if (!isFirstNameValid || !isLastNameValid || !isPhoneNumberValid || !isDobValid || !isGenderValid ||
            !isNationalityValid || !isEmergencyContactValid || !isProfilePhotoValid || !isEmailValid ||
            !isUsernameValid || !isPasswordValid || !isConfirmPasswordValid) {
            
            event.preventDefault(); // Prevent form submission
            alert("Please fill in all required fields correctly.");
        }
    });
</script>
</html>
