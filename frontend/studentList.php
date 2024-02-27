


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap Datepicker JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        #resultTable {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            margin-left: 30px;
            margin-right: 30px;
        }

        #resultTable th, #resultTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            
        }
        #resultTable1 td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #resultTable th {
            background-color: #f2f2f2;
        }
        .header{
            position: relative;
            top: 20px;
            left: 2%;
            bottom: 30px;
        }
        .close:focus {
          outline: none;
          box-shadow: none;
        }
        </style>
</head>
<body>

<?php 
include 'navbar.php';
?>
 <h4 class="header">ADD STUDENT</h4>
<div class="container" style="margin-top: 50px;">
  <div class="row justify-content-center align-items-center">
    <div class="col-md-12">
     
      <form class="StudentForm" id="StudentForm" method="post">
        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label for="rollNo" class="form-label">Roll Number</label>
              <input type="number" class="form-control is-valid" id="rollNo" placeholder="enter roll number" required>
              <div class="valid-feedback" id="rollnoError"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" class="form-control is-valid" id="firstName" placeholder="enter first name">
              <div class="valid-feedback" id="firstNameError"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="lastName" class="form-label">Last Name</label>
              <div class="input-group has-validation">
                <input type="text" class="form-control is-invalid" placeholder="enter last name" id="lastName" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
                <div id="lastNameError" class="invalid-feedback"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="mb-3">
              <label for="datepicker" class="form-label">Date of Birth</label>
              <input type="text" class="form-control is-invalid" id="datepicker" placeholder="enter date of birth" aria-describedby="validationServer03Feedback" required>
              <div id="dateOfBirthError" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" id="gender" style="width: 100%; height: 38px;  border-radius: 5px;">
                <option selected>Male</option>
                <option value="Female">Female</option>
              </select>
              <div id="genderError" class="invalid-feedback"></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="mb-3">
              <label for="class" class="form-label">Class</label>
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
        </div>

        <div class="row">
        <div class="col-md-12 d-flex justify-content-end">
              <button type="submit" id="submitButton"  class="btn btn-success" onclick="submitStudentForm(event)">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>



<h4 class="header" style="margin-bottom: 50px;">STUDENTS LIST</h4>
<table id="resultTable">
            <thead>
                <tr>
                    <td>Roll No</td>
                    <td>Name</td>
                    <td>Surname</td>
                    <td>DOB</td>
                    <td>Gender</td>
                    <td>Class</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody id="resultTable1">
           

<div class="modal fade" id="addCourseToStudentModel" tabindex="-1" aria-labelledby="addCourseToStudent" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCourseModalLabel">Get Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">close</button>
            </div>
            <div class="modal-body">
                <form id="addCourseToStudentForm">
                    <input type="hidden" id="hiddenRollNo" name="hidden_roll_no">
                    <input type="hidden" id="hiddenStudentName" name="hidden_student_name">


                    <div class="mb-3">
                        <label for="roll_no" class="form-label"> Roll No</label>
                        <input type="number" readonly class="form-control" id="StudentRollNo" name="roll_no">
                    </div>
                    <div class="mb-3">
                        <label for="addCourse" class="form-label">Course</label>
                        <select class="form-select" aria-label="Default select example" name="Course Name" id="addCourseToSelect">
                            <!-- <option selected>Select Student</option>
                           -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="submitAddCourseToStudent(document.getElementById('hiddenRollNo').value,document.getElementById('addCourseToSelect').value,document.getElementById('hiddenStudentName').value)">ADD</button>
            </div>
        </div>
    </div>
</div>
            </tbody>
        </table>


         <!-- table to get all students who arr enrolled in perticular course -->

<div class="modal fade" id="getEnrolledCoursesModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Courses Enrolled</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">close</button>
      </div>
      <div class="modal-body">
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">Course ID</th>
              <th scope="col">Course Name</th>
            </tr>
          </thead>
          <tbody id="enrolledCoursesTable">
            <!-- Table rows will be added here dynamically -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
  <div class="toast bg-info" role="alert" aria-live="assertive" aria-atomic="true" data-delay="100" style="width: 300px;">
    <div class="toast-header">
      <strong class="mr-auto">Success!</strong>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body text-white" id="toastBody" style="height: 50px;">
      Form submitted successfully!
    </div>
  </div>
</div>
<script>
    // Initialize toast
    $(document).ready(function(){
    $('#datepicker').datepicker({
        format: 'dd-mm-yyyy', // Date format
        autoclose: true, // Close the datepicker when date selected
        todayHighlight: true // Highlight today's date
    });
    });
    $(document).ready(function(){
        $('.toast').toast();
    });

    // Show toast
    $('#showToastBtn').click(function(){
        $('.toast').toast('show');
    });

    // Hide toast when close button is clicked
    $('.close').click(function(){
        $('.toast').toast('hide');
    });
</script>

        <script src="../utitlityJS/enrollment.js"></script>
        <script src="../utitlityJS/student.js"></script>



</body>
</html>