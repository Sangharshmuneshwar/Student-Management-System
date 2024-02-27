function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}


$(document).ready(function (event) {
    // Function to get URL parameter by name
    
    
    var roll_no = getParameterByName('roll_no');
    var name = getParameterByName('name');
    
    
    document.getElementById('courseHeading').innerHTML = roll_no + "-"+ name + " enrolled in following courses";
    getEnrolledCourses(roll_no);
    
    document.getElementById("addCourses").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default form submission
    
        var url = 'notEnrolledCourses.php?roll_no=' + roll_no + '&name=' + encodeURIComponent(name);
        
        // Redirect to the URL
        window.location.href = url;
    });
    
    });


    function populateResponseTable(data, roll_no) {
        var tableBody = $('#enrolledCoursesTable');
    
        // Clear any existing rows
        tableBody.empty();
    
        if (data.length === 0) {
            // If no data, display "No data found" in a single row
            var noDataRow = $('<tr>');
            var noDataCell = $('<td style="text-align: center;">').attr('colspan', '3').text('No data found');
            noDataRow.append(noDataCell);
            tableBody.append(noDataRow);
        } else {
            // Iterate over the data array and add rows to the table
            $.each(data, function (index, course) {
                var row = $('<tr>');
                row.append('<td>' + course.CourseID + '</td>');
                row.append('<td>' + course.CourseName + '</td>');
    
                // Add a button to delete the student from the course
                var deleteButton = $('<button>').text('Delete').addClass('btn btn-danger');
                deleteButton.click(function () {
                    deleteStudentFromCourse(course.CourseID, roll_no); // Call function to delete student
                });
                var buttonCell = $('<td>').append(deleteButton);
                row.append(buttonCell);
    
                tableBody.append(row);
            });
        }
    }
    
    function deleteStudentFromCourse(CourseID, roll_no) {
        $.ajax({
            type: 'GET',
            url: '../Services/enrollment.php',
            data: { CourseID: CourseID, roll_no: roll_no, action: 'deleteEnrollment' },
            success: function (response) {
                console.log(response);
                getEnrolledCourses(roll_no);
                $('#toastBody').text("student removed from the course");
                $('.toast').toast('show');
            },
            error: function (xhr, status, error) {
                console.error('Form submission failed');
    
            }
    
        });
    
    }
    

    function getEnrolledCourses(roll_no) {
        $.ajax({
            type: 'GET',
            url: '../Services/enrollment.php',
            data: { roll_no: roll_no, action: 'getEnrolledCourses' },
            success: function (response) {
                console.log(response);
                var data = JSON.parse(response);
                populateResponseTable(data, roll_no)
    
    
    
            },
            error: function (xhr, status, error) {
                console.error('Form submission failed');
    
            }
    
        });
    }
    