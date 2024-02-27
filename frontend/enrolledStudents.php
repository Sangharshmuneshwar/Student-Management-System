<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">

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
        .head1{
            position: relative;
            left: 30%;
            margin-top: 20px;
        }
        .table-container {
            margin: 0 auto; /* Center the table horizontally */
            width: 70%; /* Adjust the width as needed */
            align-items: center;
         }

         #addStudents {
            position: relative;
            top: 10%;
            margin-left: 197px;
            margin-top: 30px;
            margin-bottom: 20px;
         }
    </style>
    </head>
    <body>
    <?php 
  include 'navbar.php';
  ?>

  <h3 id="courseHeading" class="head1"></h3>
  <a href="#"><button type="submit" id="addStudents" class="btn btn-primary">Add Students</button></a>

  <div class="table-container">
  <table class="table" id="myTable">
          <thead>
            <tr>
              <th scope="col">Roll No</th>
              <th scope="col">Name</th>
            </tr>
          </thead>
          <tbody id="enrolledStudentTable">
            <!-- Table rows will be added here dynamically -->
          </tbody>
        </table>
</div>
      <?php include "toast.php" ?>
        <script src="../utitlityJS/enrolledStudents.js"></script>

    </body>
</html>