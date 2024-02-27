<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connection.php';

function compareDates($startDate, $endDate) {
    $startDateTime = new DateTime($startDate);
    $endDateTime = new DateTime($endDate);

    // Compare the dates
    if ($endDateTime < $startDateTime) {
        return true; 
    } else {
        return false; 
    }
}

function isValidName($name) {
    $pattern = '/^[a-zA-Z\- ]+$/'; // Updated pattern to allow spaces

    if (preg_match($pattern, $name) && strlen($name) <= 50) {
        return true; // Name is valid
    } else {
        return false; // Name is invalid
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'addCourse' ) {
    $courseName = $_POST['courseName'];
    $courseCredits = $_POST['courseCredits'];
    $StartDate = $_POST['startDate'];
    $EndDate = $_POST['endDate'];
   
    $endDateError = "";
    $CourseCreditError = "";
    $CourseNameError = "";
    if (compareDates($StartDate, $EndDate)) {
        $endDateError = "End date should be greater than start date";
    } if($courseCredits > 100){
        $CourseCreditError = "course credit should be less than 100";
    }
    if (isValidName($courseName) == false) {
        $CourseNameError =  "Enter a valid name";
    } 


    if($endDateError != "" || $CourseCreditError != "" || $CourseNameError != ""){
        $response = array(
            "endDateError" => $endDateError,
            "CourseCreditError" => $CourseCreditError,
            "CourseNameError" => $CourseNameError
        );

        echo json_encode($response); 
        exit();
    }
    // Create a DateTime object from the input string date
    $dateObj1 = DateTime::createFromFormat('d-m-Y', $StartDate);
    $dateObj2 = DateTime::createFromFormat('d-m-Y', $EndDate);
    


    // Format the DateTime object into MySQL date format (YYYY-MM-DD)
    $mysqlDate1 = $dateObj1->format('Y-m-d');
    $mysqlDate2 = $dateObj2->format('Y-m-d');


    $stmt_insert = mysqli_prepare($db, "INSERT INTO Courses (CourseName, CourseCredits, StartDate, EndDate) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt_insert, "ssss", $courseName, $courseCredits, $mysqlDate1, $mysqlDate2);

    if (!$stmt_insert) {
        $message = "Error: " . mysqli_error($db); // Error during preparation of statement
    } else {
        try {
            mysqli_stmt_execute($stmt_insert); // Execute the prepared statement
            $message = "course added successfully";
        } catch (mysqli_sql_exception $e) {
        
                $message = "Error: " . $e->getMessage(); // General error
            
        }

        mysqli_stmt_close($stmt_insert); 
    }

    $response = array(
        "message" => $message,
    );


    echo json_encode($response); 
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $select_stmt = mysqli_prepare($db, "SELECT * FROM Courses");
    mysqli_stmt_execute($select_stmt);
    mysqli_stmt_bind_result($select_stmt, $CourseID, $CourseName, $CourseCredits, $StartDate, $EndDate);
   

    $rows = array();

    while (mysqli_stmt_fetch($select_stmt)) {
        $rowData = array(
            "CourseID" => $CourseID,
            "CourseName" => $CourseName,
            "CourseCredits" => $CourseCredits,
            "StartDate" => $StartDate,
            "EndDate" => $EndDate
        );
        
        $rows[] = $rowData;
        
    }
    mysqli_stmt_close($select_stmt);
    
    
    echo json_encode($rows);
}

function DeleteAllEnrollments($CourseID, $db) {
    $select_stmt = mysqli_prepare($db,"DELETE FROM enrollments WHERE CourseID = ?");
    mysqli_stmt_bind_param($select_stmt,"i",$CourseID);
    mysqli_stmt_execute($select_stmt);
    mysqli_stmt_close($select_stmt);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete'){
    $Delvalue = $_POST['id'];
    DeleteAllEnrollments($Delvalue, $db);
    $select_stmt = mysqli_prepare($db,"DELETE FROM Courses WHERE CourseID = ?");
    mysqli_stmt_bind_param($select_stmt,"i",$Delvalue);
    mysqli_stmt_execute($select_stmt);
    mysqli_stmt_close($select_stmt);
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update'){
    
    $courseID = $_POST['courseID'];
$CourseName = $_POST['CourseName'];
$CourseCredits = $_POST['CourseCredits'];
$StartDate = $_POST['StartDate'];
$EndDate = $_POST['EndDate'];


$endDateError = "";
$CourseCreditError = "";
$CourseNameError = "";



    // Create a DateTime object from the input string date
    $dateObj3 = DateTime::createFromFormat('d-m-Y', $StartDate);
    $dateObj4 = DateTime::createFromFormat('d-m-Y', $EndDate);


    // Format the DateTime object into MySQL date format (YYYY-MM-DD)
    $mysqlDate3 = $dateObj3->format('Y-m-d');
    $mysqlDate4 = $dateObj4->format('Y-m-d');

    if (compareDates($mysqlDate3, $mysqlDate4)) {
        $endDateError = "End date should be greater than start date";
    } if($CourseCredits > 100){
        $CourseCreditError = "course credit should be less than 100";
    }
    if (isValidName($CourseName) == false) {
        $CourseNameError =  "Enter a valid name";
    } 
    
    
    if($endDateError != "" || $CourseCreditError != "" || $CourseNameError != ""){
        $response = array(
            "endDateError" => $endDateError,
            "CourseCreditError" => $CourseCreditError,
            "CourseNameError" => $CourseNameError
        );
    
        echo json_encode($response); 
        exit();
    }

    $stmt_update = mysqli_prepare($db, "UPDATE Courses SET  CourseName=?, CourseCredits=?, StartDate=?, EndDate=? WHERE CourseID=?");
    mysqli_stmt_bind_param($stmt_update, "ssssi", $CourseName, $CourseCredits, $mysqlDate3, $mysqlDate4,$courseID);


    if (!$stmt_update) {
        $message = "Error: " . mysqli_error($db); // Error during preparation of statement
    } else {
        try {
            mysqli_stmt_execute($stmt_update); // Execute the prepared statement
            $message = "course updated successfully";
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
