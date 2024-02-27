<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
        #resultTable3 td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #resultTable th {
            background-color: #f2f2f2;
        }
        .header{
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .btn1{
            position: relative;
            left:81%;
        }
        .btn2{
            position: relative;
            left:87%;
            margin-top: 30px;
        }
        #backButton{
            position: relative;
            left: 3%;
        }
       
        </style>
<body>
<?php 
  include 'navbar.php';
  ?>

        <h3 id="header" class="header"></h3>
<button type="submit"  id="backButton" class="btn btn-primary" >Go Back</button>
       
<button type="submit"  id="submitStudents" class="btn btn-primary btn1 submitStudents" >add students</button>
        
        <table id="resultTable">
            <thead>
                <tr>
                    <td>Roll No</td>
                    <td>Name</td>
                    <td>DOB</td>
                    <td>Gender</td>
                    <td>Class</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody id="resultTable3">
           


            </tbody>
        </table>

<button type="submit"  id="submitStudents" class="btn btn-primary btn2 submitStudents" >add students</button>

<?php include 'toast.php' ?>

        <script src="../utitlityJS/notEnrolledStudents.js"></script>

</body>
</html>