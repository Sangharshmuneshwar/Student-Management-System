function isValidName(name) {
    // Regular expression pattern to allow letters and hyphens
    var pattern = /^[a-zA-Z\- ]+$/;

    if (pattern.test(name) && name.length <= 50) {
        return true; // Name is valid
    } else {
        return false; // Name is not valid
    }
}

$('#CourseName').on('input', function (e) {
    e.preventDefault();
    var courseName = $(this).val();
    if(isValidName(courseName)){
        $('#courseError').text('');
    }
    if (courseName === '') {
        $('#courseError').text('Enter a course name');
    }
});

$('#CourseCredits').on('input', function () {
    var courseCredit = $(this).val();
    if (courseCredit === '') {
        $('#creditError').text('');
    }
    if(courseCredit < 100){
        $('#creditError').text(''); 
    }
});
$('#EndDate').on('focus', function () {
    $('#enddateError').text('');
});


$(document).ready(function () {
    getAllCourses();

});

$('#courseForm').submit(function (event) {
    event.preventDefault();
    event.stopImmediatePropagation();
    submitCourseForm();
});


function submitCourseForm() {
    // Get form data
    var formData = {
        courseName: $('#CourseName').val(),
        courseCredits: $('#CourseCredits').val(),
        startDate: $('#StartDate').val(),
        endDate: $('#EndDate').val(),
        action: 'addCourse'
    };

    // Send AJAX POST request
    $.ajax({
        type: 'POST',
        url: '../Services/course.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.endDateError || response.CourseCreditError || response.CourseNameError) {
                $('#creditError').html(response.CourseCreditError);
                $('#courseError').html(response.CourseNameError);
                $('#enddateError').html(response.endDateError);
            } else {
                console.log("first time");
                $('#toastBody').text("course added successfully");
                $('.toast').toast('show');
                getAllCourses();
                $('#courseForm')[0].reset();
                $('#creditError').html("");
                $('#courseError').html("");
                $('#enddateError').html("");
            }
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');
            // Handle error response here
        }
    });
}

function addRowstoTbody(courses) {
    var tbody = $('#resultTable1');

    // Clear existing table rows
    tbody.empty();

    if (courses.length === 0) {
        // If no data is available, show "No data found" message
        tbody.append('<tr><td colspan="5" style="text-align: center;"><h5>No data found</h5></td></tr>');
    } else {
        // Iterate over the courses array and generate table rows
        courses.forEach(function (course) {
            var row = $('<tr>');
            row.attr('data-CourseID', course.CourseID);
            row.append('<td>' + course.CourseID + '</td>');
            row.append('<td><a href="enrolledStudents.php?CourseID=' + course.CourseID + '&CourseName=' + encodeURIComponent(course.CourseName) + '">' + course.CourseName + '</a></td>');
            row.append('<td>' + course.CourseCredits + '</td>');
            row.append('<td>' + course.StartDate + '</td>');
            row.append('<td>' + course.EndDate + '</td>');
            row.append('<td class="actions" style="display: flex; flex-direction: row; justify-content: space-evenly;">' +
                '<button class="btn btn-primary btn-sm" onclick="updateCourse(' + course.CourseID + ')">Update</button>' +
                '<button class="btn btn-danger btn-sm" onclick="deleteCourse(' + course.CourseID + ')">Delete</button>' +
                '</td>');

            // Append the row to the tbody element
            tbody.append(row);
        });
    }
}


//thia is a button removed to add a student to perticular course

{/* <button style="background-color: #007bff; color: #fff; font-weight: 400; font-size: 1rem; border: none;" onclick="addStudentToCourse(' + course.CourseID + ')">Add Student</button> + */}


function getAllCourses() {

    // Send AJAX POST request
    $.ajax({
        type: 'GET',
        url: '../Services/course.php',
        success: function (response) {
            // console.log("comming here2");
            var data = JSON.parse(response);
            addRowstoTbody(data);
            // $('#resultTable1').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');
            // Handle error response here
        }

    });
}

function deleteCourse(id) {
    $.ajax({
        type: 'post',
        url: '../Services/course.php',
        data: {
            id: id,
            action: 'delete',
        },
        success: function () {
            //  $('#resultTable1').load('../Services/course.php'); 
            $('#toastBody').text("course deleted sucsesfully");
            $('.toast').toast('show');
            getAllCourses();
            //  $('#massage').html('');

        }
    });
}

function formatDate(dob) {
    var dateParts = dob.split('-');
    var year = dateParts[0];
    var month = dateParts[1];
    var day = dateParts[2];

    var formattedDate = day + '-' + month + '-' + year;

    return formattedDate;
}

function updateCourse(courseID) {
    // Find the row in the table corresponding to the course ID
    var row = $('tr[data-CourseID="' + courseID + '"]');

    // Retrieve the data from the table cells within the row
    var courseName = row.find('td:nth-child(2)').text().trim();
    var courseCredits = row.find('td:nth-child(3)').text().trim();
    var startDate = row.find('td:nth-child(4)').text().trim();
    var endDate = row.find('td:nth-child(5)').text().trim();

    // Set the values of the input fields in the 


    var formattedDate1 = formatDate(startDate);
    var formattedDate2 = formatDate(endDate);






    $('#updateCourseID').val(courseID);
    $('#updateCourseName').val(courseName);
    $('#updateCourseCredits').val(courseCredits);
    $('#updateStartDate').val(formattedDate1);
    $('#updateEndDate').val(formattedDate2);

    $('#updateCreditError').html("");
    $('#updateCourseError').html("");
    $('#updateEnddateError').html("");

    // Show the update form modal
    $('#updateCourseModal').modal('show');
}
$(document).ready(function () {
    // Add event listener to the "Update" button
    $('#updateCourseForm').submit(function (event) {
        event.preventDefault();
        submitUpdateCourse();
    });
});

function submitUpdateCourse() {
    // event.preventDefault();
    // onclick="submitUpdateCourse(document.getElementById('updateCourseID').value)

    // Get form data
    var formData = {
        courseID: $('#updateCourseID').val(),
        CourseName: $('#updateCourseName').val(),
        CourseCredits: $('#updateCourseCredits').val(),
        StartDate: $('#updateStartDate').val(),
        EndDate: $('#updateEndDate').val(),
        action: 'update'
    };

    // Send AJAX POST request
    $.ajax({
        type: 'POST',
        url: '../Services/course.php',
        data: formData,
        dataType: 'json',
        success: function (response) {


            if (response.endDateError || response.CourseCreditError || response.CourseNameError) {
                $('#updateCreditError').html(response.CourseCreditError);
                $('#updateCourseError').html(response.CourseNameError);
                $('#updateEnddateError').html(response.endDateError);
            }
            else {
                $('#toastBody').text("course updated sucsesfully");
                $('.toast').toast('show');
                $('#updateCreditError').html("");
                $('#updateCourseError').html("");
                $('#updateEnddateError').html("");
                getAllCourses();
                $('#updateCourseModal').modal('hide');
            }

        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');
            // Handle error response here
        }
    });
}


function populateSelect(data) {
    var selectElement = $('#addStudentToSelect');
    // console.log(selectElement);
    selectElement.empty();

    // Add a default option
    selectElement.append($('<option>', {
        value: '',
        text: 'Select Student'
    }));

    data.forEach(function (student) {
        selectElement.append($('<option>', {
            value: student.roll_no,
            text: student.name + ' ' + student.surname
        }));
    });
}

function getAllStudentsToPopulateSelect() {

    // Send AJAX POST request
    $.ajax({
        type: 'GET',
        url: '../Services/student.php',
        success: function (response) {
            var data = JSON.parse(response);
            populateSelect(data);
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });
    // window.location.href = 'studentList.php';

}
function addStudentToCourse(CourseID) {

    getAllStudentsToPopulateSelect();

    var row = $('tr[data-CourseID="' + CourseID + '"]');
    // console.log(row);


    // Retrieve the data from the table cells within the row
    var courseName = row.find('td:nth-child(2)').text().trim();
    // console.log(courseName);

    $('#courseID').val(CourseID);
    $('#courseName').val(courseName);
    console.log("i am finding courseName");



    $('#addStudentToCourseModel').modal('show');

}


function submitAddStudentToCourse(CourseID, roll_no, CourseName) {
    var selectedSTudentName = $('#addStudentToSelect option:selected').text();

    $.ajax({
        type: 'POST',
        url: '../Services/enrollment.php',
        data: { CourseID: CourseID, roll_no: roll_no, CourseName: CourseName, StudentName: selectedSTudentName, action: 'enrollStudent' },
        success: function (response) {
            console.log(response);
            $('#addStudentToCourseModel').modal('hide');
            $('#toastBody').text(response);
            $('.toast').toast('show');


        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });
}

function populateResponseTable(data) {
    var tableBody = $('#enrolledStudentTable');

    // Clear any existing rows
    tableBody.empty();

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
            populateResponseTable(data)



        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });

    $('#getEnrolledStudentModel').modal('show');

}


