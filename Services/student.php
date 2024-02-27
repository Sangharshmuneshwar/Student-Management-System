<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connection.php';



function isValidName($name) {
    $pattern = '/^[a-zA-Z\-]+$/';

    if (preg_match($pattern, $name) && strlen($name) <= 50) {
        return true; // Name is valid
    } else {
        return false; 
    }
}

function isDateGreaterThanToday($inputDate) {
    // Get today's date
    $today = date('Y-m-d');

    // Compare input date with today's date
    if ($inputDate >= $today) {
        return true; // Input date is greater than or equal to today's date
    } else {
        return false; // Input date is not greater than today's date
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rollNo = $_POST['rollNo'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];


    $firstNameError = "";
    $lastNameError = "";
    $dateOfBirthError = "";
    $checkDuplicate = false;
    // Create a DateTime object from the input string date
    $dateObj = DateTime::createFromFormat('d-m-Y', $dob);

    // Format the DateTime object into MySQL date format (YYYY-MM-DD)
    $mysqlDate = $dateObj->format('Y-m-d');


    if (isDateGreaterThanToday($mysqlDate)) {
        $dateOfBirthError = "date of birth cannot be greater than todays date";
    } if(isValidName($name) == false){
        $firstNameError = "enter a valid name";
    }
    if (isValidName($surname) == false) {
        $lastNameError =  "Enter a valid surname";
    } 

    if($firstNameError != "" || $lastNameError != "" || $dateOfBirthError != ""){
        $response = array(
            "dateOfBirthError" => $dateOfBirthError,
            "lastNameError" => $lastNameError,
            "firstNameError" => $firstNameError
        );

        echo json_encode($response); 
        exit();
    }


    $stmt_insert = mysqli_prepare($db, "INSERT INTO students (roll_no, name, surname, date_of_birth, gender, class) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt_insert, "ssssss", $rollNo, $name, $surname, $mysqlDate, $gender, $class);

    if (!$stmt_insert) {
        $message = "Error: " . mysqli_error($db); // Error during preparation of statement
    } else {
        try {
            mysqli_stmt_execute($stmt_insert); // Execute the prepared statement
            $message = "Student added successfully";
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { 
                $message = "Error: Duplicate entry for roll no";
                $checkDuplicate = true;
            } else {
                $message = "Error: " . $e->getMessage(); // General error
            }
        }

        mysqli_stmt_close($stmt_insert); 
    }

    $response = array(
        "message" => $message,
        "checkDuplicate" => $checkDuplicate
    );


    echo json_encode($response); 
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $select_stmt = mysqli_prepare($db, "SELECT * FROM students");
    mysqli_stmt_execute($select_stmt);
    mysqli_stmt_bind_result($select_stmt, $roll_no, $name, $surname, $date_of_birth, $gender, $class);
    $counter = 1; // Initialize a counter for Sr No

    // Initialize an empty variable to store the table rows

    $rows = array();

while (mysqli_stmt_fetch($select_stmt)) {
    $rowData = array(
        "roll_no" => $roll_no,
        "counter" => $counter,
        "name" => $name,
        "surname" => $surname,
        "date_of_birth" => $date_of_birth,
        "gender" => $gender,
        "class" => $class
    );
    
    $rows[] = $rowData;
    
    $counter++; // Increment the counter for the next row
}
mysqli_stmt_close($select_stmt);


echo json_encode($rows);

}

function DeleteAllEnrollments($roll_no, $db) {
    $select_stmt = mysqli_prepare($db,"DELETE FROM enrollments WHERE roll_no = ?");
    mysqli_stmt_bind_param($select_stmt,"i",$roll_no);
    mysqli_stmt_execute($select_stmt);
    mysqli_stmt_close($select_stmt);
}


if ($_SERVER["REQUEST_METHOD"] == "DELETE"){

    parse_str(file_get_contents("php://input"), $_DELETE);
    $Delvalue = $_DELETE['rollNo'];
    try{
        DeleteAllEnrollments($Delvalue, $db);

            $select_stmt = mysqli_prepare($db,"DELETE FROM students WHERE roll_no = ?");
            mysqli_stmt_bind_param($select_stmt,"i",$Delvalue);
            mysqli_stmt_execute($select_stmt);
            mysqli_stmt_close($select_stmt);

            $message = "Student deleted successfully";

    }catch(mysqli_sql_exception $e){
        $message = "Error: " . $e->getMessage(); // General error
    }

    echo json_encode($message); 
    exit();
}




if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    $inputData = file_get_contents('php://input');

// Parse the raw input data (assuming it's in URL-encoded format)
parse_str($inputData, $_PUT);

// Now you can access the values from $_PUT array
$rollNo = $_PUT['rollNo'];
$name = $_PUT['name'];
$surname = $_PUT['surname'];
$dob = $_PUT['dob'];
$gender = $_PUT['gender'];
$class = $_PUT['class'];

$firstNameError = "";
$lastNameError = "";
$dateOfBirthError = "";
    // Create a DateTime object from the input string date
    $dateObj = DateTime::createFromFormat('d-m-Y', $dob);

    // Format the DateTime object into MySQL date format (YYYY-MM-DD)
    $mysqlDate = $dateObj->format('Y-m-d');


    if (isDateGreaterThanToday($mysqlDate)) {
        $dateOfBirthError = "date of birth cannot be greater than todays date";
    } if(isValidName($name) == false){
        $firstNameError = "enter a valid name";
    }
    if (isValidName($surname) == false) {
        $lastNameError =  "Enter a valid surname";
    } 

    if($firstNameError != "" || $lastNameError != "" || $dateOfBirthError != ""){
        $response = array(
            "dateOfBirthError" => $dateOfBirthError,
            "lastNameError" => $lastNameError,
            "firstNameError" => $firstNameError
        );

        echo json_encode($response); 
        exit();
    }

    $stmt_update = mysqli_prepare($db, "UPDATE students SET name=?, surname=?, date_of_birth=?, gender=?, class=? WHERE roll_no=?");
    mysqli_stmt_bind_param($stmt_update, "sssssi", $name, $surname, $mysqlDate, $gender, $class, $rollNo);


    if (!$stmt_update) {
        $message = "Error: " . mysqli_error($db); // Error during preparation of statement
    } else {
        try {
            mysqli_stmt_execute($stmt_update); // Execute the prepared statement
            $message = "Student updated successfully";
        } catch (mysqli_sql_exception $e) {

                $message = "Error: " . $e->getMessage(); 
            
        }

        mysqli_stmt_close($stmt_update); 
    }

    $response = array(
        "message" => $message,
    );


    echo json_encode($response); 
    // header("Location: ../frontend/studentList.php");

    exit();
}

?>
