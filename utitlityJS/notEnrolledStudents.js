

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


document.getElementById('header').innerHTML = "Add Students in " + courseName;
getNotEnrolledStudents(courseID);


});




var selectedStudents = []; // Array to store selected students' roll numbers

function getSelectedStudent(checkbox,roll_no) {
    console.log("comming here1");
    
      
       
        if (checkbox.checked) {
            // Student is checked, add to selectedStudents array
            selectedStudents.push(roll_no);
            console.log(selectedStudents);
            console.log("comming here");
        } else {
            // Student is unchecked, remove from selectedStudents array
            var index = selectedStudents.indexOf(roll_no);
            if (index !== -1) {
                selectedStudents.splice(index, 1);
            }
        }
}



var buttons = document.querySelectorAll(".submitStudents");

buttons.forEach(function(button){
    button.addEventListener("click",function() {
        // Get the course ID
        var courseID = getParameterByName('CourseID');
    
        if (selectedStudents.length === 0) {
            alert("Please select at least one student.");
            return;
        }
    
        $.ajax({
            type: 'GET',
            url: '../Services/enrollment.php',
            data: { courseID: courseID,selectedStudents: selectedStudents, action: 'addSelectedStudentsToEnrollment' },
            success: function (response) {
                console.log(response);
                getNotEnrolledStudents(courseID);
                selectedStudents = [];
                $('#toastBody').text(response);
                $('.toast').toast('show');
                
               
            },
            error: function (xhr, status, error) {
                console.error('Form submission failed');
    
            }
    
        });
       
    })
})


function addStudentsToTable(data) {
    if (window.location.href.indexOf("/index.php") === -1) {
        var tableBody = document.getElementById("resultTable3");

        // Clear existing table rows
        tableBody.innerHTML = "";

        if (data.length === 0) {
            // If no data, display "No data found" in a single row
            var noDataRow = document.createElement("tr");
            var noDataCell = document.createElement("td");
            noDataCell.setAttribute("colspan", "6"); // Span across all columns
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
                <td onclick="getEnrolledCourses(${row.roll_no})">${row.name}</td>
                <td>${row.dob}</td>
                <td>${row.gender}</td>
                <td>${row.class}</td>
                <td style="display: flex; flex-direction: row; justify-content: space-evenly;">
                <input type="checkbox" class="student-checkbox" onchange='getSelectedStudent(this,"${row.roll_no}")' data-rollno="${row.roll_no}" />
                </td>
            `;

                tableBody.appendChild(newRow);
            });
        }
    }
}



function getNotEnrolledStudents(CourseID){
    $.ajax({
        type: 'GET',
        url: '../Services/enrollment.php',
        data: { CourseID: CourseID, action: 'getNotEnrolledStudents' },
        success: function (response) {
            var data = JSON.parse(response);
            
            addStudentsToTable(data);


        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });
}


document.getElementById("backButton").addEventListener("click", function() {
    // Get the course ID
    var CourseID = getParameterByName('CourseID');
    var CourseName = getParameterByName('CourseName');
    
    var url = 'enrolledStudents.php?CourseID=' + CourseID + '&CourseName=' + CourseName;
    
    // Redirect to the URL
    window.location.href = url;
   
});


// var selectedStudents = []; // Array to store selected students' roll numbers

// var checkboxes = document.querySelectorAll('.student-checkbox');
// checkboxes.forEach(function(checkbox) {
//     checkbox.addEventListener('change', function() {
//         var rollNo = this.getAttribute('data-rollno');
//         if (this.checked) {
//             // Student is checked, add to selectedStudents array
//             selectedStudents.push(rollNo);
//             console.log(selectedStudents);
//             console.log("comming here");
//         } else {
//             // Student is unchecked, remove from selectedStudents array
//             var index = selectedStudents.indexOf(rollNo);
//             if (index !== -1) {
//                 selectedStudents.splice(index, 1);
//             }
//         }
//     });
// });


// document.getElementById("submitStudents").addEventListener("click", function() {
//     // Get the course ID
//     var courseID = getParameterByName('CourseID');

//     if (selectedStudents.length === 0) {
//         alert("Please select at least one student.");
//         return;
//     }

//     $.ajax({
//         type: 'GET',
//         url: '../Services/enrollment.php',
//         data: { courseID: courseID,selectedStudents: selectedStudents, action: 'addSelectedStudentsToEnrollment' },
//         success: function (response) {
//             console.log(response);
           
            
//             console.log(response);
           


//         },
//         error: function (xhr, status, error) {
//             console.error('Form submission failed');

//         }

//     });
   
// });
