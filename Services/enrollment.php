<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connection.php';

function checkEnrollmentExistence($roll_no, $CourseID, $db) {
    // Prepare the SQL statement to check for existence
    $query = "SELECT COUNT(*) FROM enrollments WHERE roll_no = ? AND CourseID = ?";
    $stmt = mysqli_prepare($db, $query);

    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "ii", $roll_no, $CourseID);
    mysqli_stmt_execute($stmt);

    // Bind the result variable
    mysqli_stmt_bind_result($stmt, $count);

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // If count is greater than 0, record exists; otherwise, it does not
    return $count > 0;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] ==='enrollStudent'){

    $CourseID = $_POST['CourseID'];
    $roll_no = $_POST['roll_no'];
    $CourseName = $_POST['CourseName'];
    $StudentName = $_POST['StudentName'];


    $result = checkEnrollmentExistence($roll_no, $CourseID, $db);

    if($result){

        $message = "Student Already Enrolled in the course";
       
    }else{
        $stmt_insert = mysqli_prepare($db, "INSERT INTO enrollments (roll_no,CourseID,StudentName,CourseName) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_insert, "iiss", $roll_no, $CourseID, $StudentName,$CourseName);

        if (!$stmt_insert) {
            $message = "Error: " . mysqli_error($db); // Error during preparation of statement
        } else {
            try {
                mysqli_stmt_execute($stmt_insert); // Execute the prepared statement
                $message = "Student added to the course ";
            } catch (mysqli_sql_exception $e) {
            
                    $message = "Error: " . $e->getMessage(); // General error
                
            }

            mysqli_stmt_close($stmt_insert); 
        }

    }
    // $message = "Student Already Enrolled in the course .". $result ."";

    echo $message;

}




if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'getEnrolledStudents') {
    $CourseID = $_GET['CourseID'];

    $stmt_selct = mysqli_prepare($db, "SELECT enrollments.roll_no, students.name, students.surname, enrollments.CourseID 
    FROM enrollments 
    JOIN students ON enrollments.roll_no = students.roll_no 
    WHERE enrollments.CourseID = ?"); 
    mysqli_stmt_bind_param($stmt_selct, "i", $CourseID);

    if (!$stmt_selct) {
        echo "Error: " . mysqli_error($db); 
    } else {
        try {
            mysqli_stmt_execute($stmt_selct);
            mysqli_stmt_bind_result($stmt_selct, $roll_no, $name, $surname, $CourseID);

            $rows = array();

            while (mysqli_stmt_fetch($stmt_selct)) {
                $rowData = array(
                    "roll_no" => $roll_no,
                    "name" => $name . ' ' . $surname ,
                    "CourseID" => $CourseID
                );

                $rows[] = $rowData;
            }

            echo json_encode($rows);
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage(); 
        }

        mysqli_stmt_close($stmt_selct);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'getEnrolledCourses') {
    $roll_no = $_GET['roll_no']; // Correct variable name
    
    $stmt_selct = mysqli_prepare($db, "SELECT enrollments.CourseID, courses.CourseName 
                                        FROM enrollments 
                                        JOIN courses ON enrollments.CourseID = courses.CourseID 
                                        WHERE enrollments.roll_no = ?");
    mysqli_stmt_bind_param($stmt_selct, "i", $roll_no);

    if (!$stmt_selct) {
        echo "Error: " . mysqli_error($db); 
    } else {
        try {
            mysqli_stmt_execute($stmt_selct);
            mysqli_stmt_bind_result($stmt_selct, $CourseID, $CourseName); // Correct order of variables

            $rows = array();

            while (mysqli_stmt_fetch($stmt_selct)) {
                $rowData = array(
                    "CourseID" => $CourseID,
                    "CourseName" => $CourseName
                );

                $rows[] = $rowData;
            }

            echo json_encode($rows);
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage(); 
        }

        mysqli_stmt_close($stmt_selct);
    }
}



if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'deleteEnrollment') {
    $roll_no = $_GET['roll_no']; // Correct variable name
    $CourseID = $_GET['CourseID'];
    
    $delete_stmt = mysqli_prepare($db, "DELETE FROM enrollments WHERE roll_no =? AND CourseID =?");
    mysqli_stmt_bind_param($delete_stmt, "ii", $roll_no,$CourseID);

    if (!$delete_stmt) {
        echo "Error: " . mysqli_error($db); 
    } else {
        try {
            mysqli_stmt_execute($delete_stmt);
            echo "Enrollment deleted succsefully";

           
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage(); 
        }

        mysqli_stmt_close($delete_stmt);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'getNotEnrolledStudents') {
   
    $CourseID = $_GET['CourseID'];

    $stmt_selct = mysqli_prepare($db, "SELECT students.*
    FROM students
    LEFT JOIN enrollments
    ON students.roll_no = enrollments.roll_no
    AND enrollments.courseID=?
    WHERE enrollments.roll_no IS NULL");
    mysqli_stmt_bind_param($stmt_selct, "i", $CourseID);



    if (!$stmt_selct) {
        echo "Error: " . mysqli_error($db); 
    } else {
        try {
            mysqli_stmt_execute($stmt_selct);
            mysqli_stmt_bind_result($stmt_selct, $roll_no, $name,$surname,$dob,$gender,$class); // Correct order of variables

            $rows = array();

            while (mysqli_stmt_fetch($stmt_selct)) {
                $rowData = array(
                    "roll_no" => $roll_no,
                    "name" => $name .' '. $surname,
                    "dob" => $dob,
                    "gender" => $gender,
                    "class" => $class
                );

                $rows[] = $rowData;
            }

            echo json_encode($rows);
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage(); 
        }

        mysqli_stmt_close($stmt_selct);
    }
    
  
}



if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'addSelectedStudentsToEnrollment') {
    $CourseID = $_GET['courseID'];
    $selectedStudents = $_GET['selectedStudents'];
    
    // Establish database connection (replace with your credentials)
   

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Prepare SQL statement
    $query = "INSERT INTO enrollments (roll_no, CourseID) VALUES ";
    $valueSets = [];
    foreach ($selectedStudents as $student) {
        $rollNo = $student;
        // Make sure to sanitize your input to prevent SQL injection
        $valueSets[] = "('" . mysqli_real_escape_string($db, $rollNo) . "', " . $CourseID . ")";
    }
    $query .= implode(', ', $valueSets);

    // Execute the query
    if (!mysqli_query($db, $query)) {
        echo "Error: " . mysqli_error($db);
    } else {
        echo "Students added to course successfully.";
    }

    // Close connection
    mysqli_close($db);
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'getNotEnrolledCourses') {
   
    $roll_no = $_GET['roll_no'];

    $stmt_selct = mysqli_prepare($db, "SELECT courses.*
    FROM courses
    LEFT JOIN enrollments
    ON courses.CourseID = enrollments.CourseID
    AND enrollments.roll_no=?
    WHERE enrollments.roll_no IS NULL");
    mysqli_stmt_bind_param($stmt_selct, "i", $roll_no);



    if (!$stmt_selct) {
        echo "Error: " . mysqli_error($db); 
    } else {
        try {
            mysqli_stmt_execute($stmt_selct);
            mysqli_stmt_bind_result($stmt_selct, $CourseID,$CourseName,$CourseCredits,$StartDate,$EndDate); // Correct order of variables

            $rows = array();

            while (mysqli_stmt_fetch($stmt_selct)) {
                $rowData = array(
                    "CourseID" => $CourseID,
                    "CourseName" => $CourseName,
                    "CourseCredits" => $CourseCredits,
                    "StartDate" => $StartDate,
                    "EndDate" => $EndDate
                );

                $rows[] = $rowData;
            }

            echo json_encode($rows);
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage(); 
        }

        mysqli_stmt_close($stmt_selct);
    }
    
  
}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] === 'addSelectedCoursesToEnrollment') {
    $roll_no = $_GET['roll_no'];
    $selectedCourses = $_GET['selectedCourses'];
    
    // Establish database connection (replace with your credentials)
   

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Prepare SQL statement
    $query = "INSERT INTO enrollments (roll_no, CourseID) VALUES ";
    $valueSets = [];
    foreach ($selectedCourses as $Course) {
        $CourseID = $Course;
        // Make sure to sanitize your input to prevent SQL injection
        $valueSets[] = "('" . mysqli_real_escape_string($db, $roll_no) . "', " . $CourseID . ")";
    }
    $query .= implode(', ', $valueSets);

    // Execute the query
    if (!mysqli_query($db, $query)) {
        echo "Error: " . mysqli_error($db);
    } else {
        echo "Courses Added Successfully.";
    }

    // Close connection
    mysqli_close($db);
}


?>