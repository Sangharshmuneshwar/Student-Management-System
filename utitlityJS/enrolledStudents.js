
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


var courseID = getParameterByName('CourseID');
var courseName = getParameterByName('CourseName');


// Example of getting data attributes
// var cell = $('td[data-course-id="' + courseID + '"][data-course-name="' + courseName + '"]');
// var courseID = cell.data('course-id');
// var courseName = cell.data('course-name');
// console.log('CourseID:', courseID);
// console.log('CourseName:', courseName);
document.getElementById('courseHeading').innerHTML = "Students enrolled in " + courseName;
getEnrolledStudents(courseID);

document.getElementById("addStudents").addEventListener("click", function(event) {
    event.preventDefault();

    var url = 'notEnrolledStudent.php?CourseID=' + courseID + '&CourseName=' + encodeURIComponent(courseName);

    console.log(url);
    
    // Redirect to the URL
    window.location.href = url;
});



});


function populateResponseTable(data) {
    var tableBody = $('#enrolledStudentTable');

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
        $.each(data, function (index, student) {
            var row = $('<tr>');
            row.append('<td>' + student.roll_no + '</td>');
            row.append('<td>' + student.name + '</td>');

            // Add a button to delete the student from the course
            var deleteButton = $('<button>').text('Delete').addClass('btn btn-danger');
            deleteButton.click(function () {
                deleteStudentFromCourse(student.CourseID, student.roll_no); // Call function to delete student
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
            $('#toastBody').text("student removed from course");
            $('.toast').toast('show');
            getEnrolledStudents(CourseID);
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });
}


function getEnrolledStudents(CourseID) {

    $.ajax({
        type: 'GET',
        url: '../Services/enrollment.php',
        data: { CourseID: CourseID, action: 'getEnrolledStudents' },
        success: function (response) {
            console.log(response);
            var data = JSON.parse(response);
            populateResponseTable(data);
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });


}


