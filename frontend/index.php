<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student-Management</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap Datepicker JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

</head>
<body>
  <?php 
  include 'navbar.php';
  ?>

<div class="container" style="margin-top: 50px;">
  <div class="row justify-content-center align-items-center">
    <div class="col-md-6">
      <h3 class="header" style="text-align: center;">Add Student</h3>

      <form class="StudentForm" id="StudentForm" method="post">
        <div class="mb-3">
          <label for="rollNo" class="form-label">Roll Number</label>
          <input type="number" class="form-control is-valid" id="rollNo" placeholder="enter roll number" required>
          <div class="valid-feedback" id="rollnoError"></div>
        </div>
        <div class="mb-3">
          <label for="firstName" class="form-label">First Name</label>
          <input type="text" class="form-control is-valid" id="firstName" placeholder="enter first name">
          <div class="valid-feedback" id="firstNameError"></div>
        </div>
        <div class="mb-3">
          <label for="lastName" class="form-label">Last Name</label>
          <div class="input-group has-validation">
            <input type="text" class="form-control is-invalid" placeholder="enter last name" id="lastName" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
            <div id="lastNameError" class="invalid-feedback"></div>
          </div>
        </div>
        <div class="mb-3">
          <label for="datepicker" class="form-label">Date of birth</label>
          <input type="text" class="form-control is-invalid" id="datepicker" placeholder="enter date of birth" aria-describedby="validationServer03Feedback" required>
          <div id="dateOfBirthError" class="invalid-feedback"></div>
        </div>
        <div class="row">
  <div class="col-md-12">
    <label for="gender" class="form-label">Gender</label>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="gender" style="width: 100%; height: 38px;  border-radius: 5px;">
      <option selected>Male</option>
      <option value="Female">Female</option>
    </select>
    <div id="genderError" class="invalid-feedback"></div>
  </div>
</div>

        <div class="row">
  <div class="col-md-12">
    <label for="class" class="form-label">Class</label>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="class" style="width: 100%;  height: 38px;  border-radius: 5px;">
      <option selected>1st</option>
      <option value="2nd">2nd</option>
      <option value="3rd">3rd</option>
      <option value="4th">4th</option>
      <option value="5th">5th</option>
    </select>
    <div id="classError" class="invalid-feedback"></div>
  </div>
</div>
<button type="submit" style="width: 100%;" id="submitButton" class="btn btn-primary" onclick="submitStudentForm(event)">Submit</button>
      </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    $('#datepicker').datepicker({
        format: 'dd-mm-yyyy', // Date format
        autoclose: true, // Close the datepicker when date selected
        todayHighlight: true // Highlight today's date
    });
});
</script>

<script src="../utitlityJS/student.js"></script>



<?php include 'toast.php'; ?>


</body>


</html>