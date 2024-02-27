<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <style>
      /* Brighter links */
        .navbar-nav .nav-link {
          color: #fff; /* White color */
        }

       /* Brighter links */
.navbar-nav .nav-link {
  color: #ffffff; /* White color */
}

/* Active state */
.navbar-nav .nav-item.active .nav-link {
  background-color: #ffffff; /* White background color */
  color: #000000; /* Black text color */
}

/* Hover state */
.navbar-nav .nav-item .nav-link:hover {
  background-color: rgba(255, 255, 255, 0.2); /* Lighter background color on hover */
}

    </style>
</head>
<body>
    
<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-primary">
  <a class="navbar-brand" href="index.php">Student Management</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="studentList.php">Student Table</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="courses.php">Course</a>
      </li>
    </ul>
  </div>
</nav>

</body>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</html>