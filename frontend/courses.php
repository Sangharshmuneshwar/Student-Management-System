<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student-Management</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    
    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }
        .tablediv{
          display: flex;
          flex-direction: column;
          justify-content: center;
        }

        #resultTable {
            border-collapse: collapse;
            margin-top: 50px;
            margin-left: 50px;
            margin-right: 50px;
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
       

        .courseDiv{
            margin-top: 70px;
            width: 100%;

            
        }
        .courseForm{
            position: relative;
            left: 95px;
            bottom: 10px;
            display: flex;
            flex-direction: row;
            justify-content: center;
           
            margin-left: 500px;
        }
        h4{
            position: relative;
            top: 30px;
            left: 4%;
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .form-group{
           padding-left: 20px;
        }
        .submitButton{
          margin-top: 31px;
          background-color: red;
        }
        </style>

</head>
<body>
  <?php 
  include 'navbar.php';
  ?>
   
<h4 class="header">ADD COURSE</h4>


<div class="courseDiv">
<form class="row g-4 courseForm" id="courseForm" method="post">
  <div class="col-md-3">
    <label for="CourseName" class="form-label">Course Name</label>
    <input type="text" class="form-control is-valid" id="CourseName" placeholder="Course Name" required>
    <div class="valid-feedback" id="courseError">
    </div>
  </div>
  <div class="col-md-2">
    <label for="CourseCredits" class="form-label">Course Credits</label>
    <input type="number" class="form-control is-valid" id="CourseCredits" placeholder="00">
    <div class="valid-feedback" id="creditError">

    </div>
  </div>
  <div class="col-md-2">
    <label for="StartDate" class="form-label">Start Date</label>
    <div class="input-group has-validation">
      <input type="text" class="form-control is-invalid" placeholder="Start Date" id="StartDate" aria-describedby="inputGroupPrepend3 validationServerUsernameFeedback" required>
      <div id="startdateError" class="valid-feedback">
      
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <label for="EndDate" class="form-label">End Date</label>
    <input type="text" class="form-control is-invalid" id="EndDate" placeholder="End Date" aria-describedby="validationServer03Feedback" required>
    <div id="enddateError" class="invalid-feedback">
   
    </div>
  </div>

 
  <div class="col-3">
  <button type="submit" id="submitButton"class="btn btn-success submitButton">Submit</button>
  </div>
</form>
</div>

<h4 class="header">COURSE LIST</h4>

<div class="tablediv">
<table id="resultTable">
            <thead>
                <tr>
                    <td>Course ID</td>
                    <td>Course Name</td>
                    <td>Course Credit</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody id="resultTable1">
           
            </tbody>
        </table>
</div>



<!-- Modal for updating a course -->
<div class="modal fade" id="updateCourseModal" tabindex="-1" aria-labelledby="updateCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCourseModalLabel">Update Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">close</button>
            </div>
            <div class="modal-body">
                <form id="updateCourseForm" method="post">
                    <input type="hidden" id="updateCourseID" name="courseID">
                    <div class="mb-3">
                        <label for="updateCourseName" class="form-label">Course Name</label>
                        <input type="text" class="form-control form-control is-valid" id="updateCourseName" name="courseName">
                        <div class="valid-feedback" id="updateCourseError">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="updateCourseCredits" class="form-label">Course Credits</label>
                        <input type="number" class="form-control form-control is-valid" id="updateCourseCredits" name="courseCredits">
                        <div class="valid-feedback" id="updateCreditError">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="updateStartDate" class="form-label">Start Date</label>
                        <input type="text" class="form-control form-control is-valid" id="updateStartDate" name="startDate">

                    </div>
                    <div class="mb-3">
                        <label for="updateEndDate" class="form-label">End Date</label>
                        <input type="text" class="form-control form-control is-valid" id="updateEndDate" name="endDate">
                        <div id="updateEnddateError" class="valid-feedback">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="updateCourseButton" class="btn btn-primary"">Update</button>
                    </div>
                </form>
            </div>
           
        </div>
    </div>
</div>


<div class="modal fade" id="addStudentToCourseModel" tabindex="-1" aria-labelledby="updateCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateCourseModalLabel">Update Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">close</button>
            </div>
            <div class="modal-body">
                <form id="addStudentToCourse">
                    <input type="hidden" id="courseID" name="courseID">

                    <div class="mb-3">
                        <label for="courseName" class="form-label">Course Name</label>
                        <input type="text" readonly class="form-control" id="courseName" name="courseName">
                    </div>
                    <div class="mb-3">
                        <label for="addStudent" class="form-label">Student</label>
                        <select class="form-select" aria-label="Default select example" name="roll_no" id="addStudentToSelect">
                            <!-- <option selected>Select Student</option>
                           -->
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="submitAddStudentToCourse(document.getElementById('courseID').value,document.getElementById('addStudentToSelect').value,document.getElementById('courseName').value)">ADD</button>
            </div>
        </div>
    </div>
</div>


<?php include 'toast.php'; ?>


<script src="../utitlityJS/course.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Bootstrap Datepicker JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
$(document).ready(function(){
    $('#StartDate').datepicker({
        format: 'dd-mm-yyyy', // Date format
        autoclose: true, // Close the datepicker when date selected
        todayHighlight: true // Highlight today's date
    });

    $('#EndDate').datepicker({
        format: 'dd-mm-yyyy', // Date format
        autoclose: true, // Close the datepicker when date selected
        todayHighlight: true // Highlight today's date
    });

    
    $('#updateStartDate').datepicker({
        format: 'dd-mm-yyyy', // Date format
        autoclose: true, // Close the datepicker when date selected
        todayHighlight: true // Highlight today's date
    });

    
    $('#updateEndDate').datepicker({
        format: 'dd-mm-yyyy', // Date format
        autoclose: true, // Close the datepicker when date selected
        todayHighlight: true // Highlight today's date
    });
});
</script>
</body>
</html>