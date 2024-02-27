function isValidName(name) {
    // Regular expression pattern to allow letters and hyphens
    var pattern = /^[a-zA-Z\-]+$/;

    if (pattern.test(name) && name.length <= 50) {
        return true; // Name is valid
    } else {
        return false; // Name is not valid
    }
}


$('#rollNo').on('input', function (e) {
    e.preventDefault();
    var rollNO = $(this).val();
    if (rollNO === '') {
        $('#rollnoError').text('');
    }
    if( $('#rollnoError').text()!== '' && rollNO !== ''){
        $('#rollnoError').text('');

    }
});

$('#firstName').on('input', function (e) {
    e.preventDefault();

    var firstname = $(this).val();
    if(isValidName(firstname)){
        $('#firstNameError').text('');
    }
    if (firstname === '') {
        $('#firstNameError').text('Enter a first name');
    }
});

$('#lastName').on('input', function (e) {
    e.preventDefault();
    var lastname = $(this).val();
    
    if(isValidName(lastname)){
        $('#lastNameError').text('');
    }
    if (lastname === '') {
        $('#lastNameError').text('Enter a first name');
    }
     
});
$('#datepicker').on('focus', function (e) {
    e.preventDefault();

    $('#dateOfBirthError').text('');
});


function getUrlParameter(name) {
    name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Check if isRedirectFromUpdate is set to true

function checkForRedirection() {
    var isRedirectFromUpdate = getUrlParameter('isRedirectFromUpdate');
    if (isRedirectFromUpdate === 'true') {
        // Do something if true
        $('#toastBody').text("student updated sucsesfully");
        $('.toast').toast('show');
        isRedirectFromUpdate = false;
    }
}

$(document).ready(function (event) {
    getAllStudents();
    checkForRedirection();


    //update student info
    $('#updateForm').submit(function (event) {
        event.preventDefault();

        // Get form data
        var formData = {
            rollNo: $('#rollNo').val(),
            name: $('#firstName').val(),
            surname: $('#lastName').val(),
            dob: $('#datepicker').val(),
            gender: $('#gender').val(),
            class: $('#class').val(),
        };

        // Send AJAX POST request
        $.ajax({
            type: 'PUT',
            url: '../Services/student.php',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.dateOfBirthError || response.lastNameError || response.firstNameError) {
                    $('#dateOfBirthError').html(response.dateOfBirthError);
                    $('#lastNameError').html(response.lastNameError);
                    $('#firstNameError').html(response.firstNameError);
                }
                else {
                    // $('#toastBody').text("student info updated sucsesfully"); 
                    // $('.toast').toast('show');
                    console.log("first submit");
                    $('#dateOfBirthError').html('');
                    $('#lastNameError').html('');
                    $('#firstNameError').html('');
                    getAllStudents();

                    var url = 'studentList.php?isRedirectFromUpdate=true';
                    window.location.href = url;
                }
            },
            error: function (xhr, status, error) {
                console.error('Form submission failed');
                // Handle error response here
            }
        });
    });

});

function submitStudentForm(event) {

    event.preventDefault();

    // Get form data
    var formData = {
        rollNo: $('#rollNo').val(),
        name: $('#firstName').val(),
        surname: $('#lastName').val(),
        dob: $('#datepicker').val(),
        gender: $('#gender').val(),
        class: $('#class').val(),
        action: "submitForm",
    };
    
    // Send AJAX POST request
   if(formData.rollNo != '' && formData.name != '' && formData.surname != '' && formData.dob != '' && formData.gender != '' && formData.class != '' ){ 
    $.ajax({
        type: 'POST',
        url: '../Services/student.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.dateOfBirthError || response.lastNameError || response.firstNameError) {
                $('#dateOfBirthError').html(response.dateOfBirthError);
                $('#lastNameError').html(response.lastNameError);
                $('#firstNameError').html(response.firstNameError);
            } else if (response.checkDuplicate === true) {
                $('#rollnoError').html('* Roll no already exists *');
                console.log("double submit");
            } else {
                console.log("first submit");

                $('#rollnoError').html('');
                $('#StudentForm')[0].reset();
                $('#dateOfBirthError').html('');
                $('#lastNameError').html('');
                $('#firstNameError').html('');
                $('#toastBody').text("student added sucsesfully");
                $('.toast').toast('show');
                getAllStudents();

            }
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }
    });
}else{
    if(formData.rollNo == ''){
        $('#rollnoError').html('* Enter a roll no *');
    }
    if(formData.name == ''){
        $('#firstNameError').html("Enter a first name");
    }
    if(formData.surname == ''){
        $('#lastNameError').html("Enter a surname");
    }
    if(formData.dob == ''){
        $('#dateOfBirthError').html("Enter a DOB");
    }
   return;
}
};

function addStudentsToTable(data) {
    if (window.location.href.indexOf("studentList.php") !== -1) {
        var tableBody = document.getElementById("resultTable1");

        // Clear existing table rows
        tableBody.innerHTML = "";

        if (data.length === 0) {
            // If no data is available, show "No data found" message
            var noDataRow = document.createElement("tr");
            var noDataCell = document.createElement("td");
            noDataCell.setAttribute("colspan", "7");
            noDataCell.style.textAlign = "center";
            noDataCell.textContent = "No data found";
            noDataRow.appendChild(noDataCell);
            tableBody.appendChild(noDataRow);
        } else {
            // Loop through the data and create table rows
            data.forEach(function (row) {
                var newRow = document.createElement("tr");
                newRow.setAttribute("data-rollno", row.roll_no);

                newRow.innerHTML = `
                <td>${row.roll_no}</td>
                <td>
                <a href="enrolledCourses.php?roll_no=${row.roll_no}&name=${row.name}">
                    ${row.name}
                </a>
                </td>
                <td>${row.surname}</td>
                <td>${row.date_of_birth}</td>
                <td>${row.gender}</td>
                <td>${row.class}</td>
                <td style="display: flex; flex-direction: row; justify-content: space-evenly;">
                    <button class="btn btn-primary btn-sm" onclick="updateStudent(${row.roll_no})">Update</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteStudent(${row.roll_no})">Delete</button>
                </td>
                `;

                tableBody.appendChild(newRow);
            });
        }
    }
}


//this is the button to add course to a perticular studen
{/* <button style="background-color: #007bff; color: #fff; font-weight: 400; font-size: 1rem; border: none;" onclick="addCourseToStudentFromStudent(${row.roll_no})">Get Course</button> */}


function getAllStudents() {

    // Send AJAX POST request
    $.ajax({
        type: 'GET',
        url: '../Services/student.php',
        success: function (response) {
            
            var data = JSON.parse(response);
            

            addStudentsToTable(data);
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');
            // Handle error response here
        }

    });

}


function deleteStudent(rollNo) {
    $.ajax({
        type: 'DELETE',
        url: '../Services/student.php',
        data: { rollNo: rollNo },
        success: function (response) {
            $('#toastBody').text(response);
            $('.toast').toast('show');
            // console.log("comming here");
            // $('#resultTable1').find('tr[data-rollno="' + rollNo + '"]').remove();
            getAllStudents();

        },
        error: function (xhr, status, error) {
            console.error('student deletion failed failed');
            // Handle error response here
        }
    });
}

function updateStudent(rollNo) {
    // Redirect to index.php

    // Once redirected, populate the form fields with the retrieved data
    $(document).ready(function () {
        // Find the row in the table corresponding to the roll number
        var row = $('#resultTable1').find('tr[data-rollno="' + rollNo + '"]');

        // Retrieve the data from the table cells within the row
        var name = row.find('td:nth-child(2)').text().trim();
        var surname = row.find('td:nth-child(3)').text().trim();
        var dob = row.find('td:nth-child(4)').text().trim();
        var gender = row.find('td:nth-child(5)').text().trim();
        var classValue = row.find('td:nth-child(6)').text().trim();

        // Set the values of the input fields in the form
        var formData = {
            rollNo: rollNo,
            name: name,
            surname: surname,
            dob: dob,
            gender: gender,
            class: classValue
        };
        console.log(formData);
        window.location.href = '../frontend/updateStudent.php' +
            '?rollNo=' + rollNo +
            '&name=' + encodeURIComponent(name) +
            '&surname=' + encodeURIComponent(surname) +
            '&dob=' + encodeURIComponent(dob) +
            '&gender=' + encodeURIComponent(gender) +
            '&class=' + encodeURIComponent(classValue);
    });
}
function populateResponseTable(data, roll_no) {
    var tableBody = $('#enrolledCoursesTable');

    // Clear any existing rows
    tableBody.empty();

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

    $('#getEnrolledCoursesModel').modal('show');
}
