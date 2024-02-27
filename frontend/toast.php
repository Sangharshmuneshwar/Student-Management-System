<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <style>
  /* Custom CSS to remove red border on close button click */
  .close:focus {
    outline: none;
    box-shadow: none;
  }
</style>
</head>
<body>
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

<script src="../utitlityJS/student.js"></script>
<script src="../utitlityJS/course.js"></script>

</body>
</html>
