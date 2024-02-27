function populateSelect(data) {
    var selectElement = $('#addCourseToSelect');
    // console.log(selectElement);
    selectElement.empty();

    // Add a default option
    selectElement.append($('<option>', {
        value: '',
        text: 'Select Course'
    }));

    data.forEach(function (course) {
        // console.log(course.name);
        selectElement.append($('<option>', {
            value: course.CourseID,
            text: course.CourseName
        }));
    });
}

function getAllCoursesPopulateToSelect() {
    $.ajax({
        type: 'GET',
        url: '../Services/course.php',
        success: function (response) {
            var data = JSON.parse(response);
            populateSelect(data);
        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });
}

function addCourseToStudentFromStudent(roll_no) {
    var row = $('#resultTable1').find('tr[data-rollno="' + roll_no + '"]');


    // Retrieve the data from the table cells within the row
    var name = row.find('td:nth-child(2)').text().trim();
    var surname = row.find('td:nth-child(3)').text().trim();
    var fullName = name + ' ' + surname;

    console.log(name);
    //  console.log(roll_no);
    getAllCoursesPopulateToSelect();

    $('#hiddenRollNo').val(roll_no);
    $('#hiddenStudentName').val(fullName);




    $('#StudentRollNo').val(roll_no);
    $('#addCourseToStudentModel').modal('show');
}


function submitAddCourseToStudent(roll_no, CourseID, StudentName) {
    var selectedCourseName = $('#addCourseToSelect option:selected').text();

    $.ajax({
        type: 'POST',
        url: '../Services/enrollment.php',
        data: { CourseID: CourseID, roll_no: roll_no, StudentName: StudentName, CourseName: selectedCourseName, action: 'enrollStudent' },
        success: function (response) {
            console.log(response);
            $('#addCourseToStudentModel').modal('hide');
            $('#toastBody').text("student added to course");
            $('.toast').toast('show');


        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });
}


