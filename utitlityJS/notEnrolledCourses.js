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


document.getElementById('header').innerHTML = "Enroll " + roll_no +"-" + name +" in following courses";
getNotEnrolledCourses(roll_no);

});




function addCoursesToTable(data) {
    if (window.location.href.indexOf("/index.php") === -1) {
        var tableBody = document.getElementById("notEnrolledCourses");

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
                newRow.setAttribute("data-CourseID", row.CourseID);

                newRow.innerHTML = `
                <td>${row.CourseID}</td>
                <td>${row.CourseName}</td>
                <td>${row.CourseCredits}</td>
                <td>${row.StartDate}</td>
                <td>${row.EndDate}</td>
                <td style="display: flex; flex-direction: row; justify-content: space-evenly;">
                <input type="checkbox" class="student-checkbox" onchange='getSelectedCourses(this,"${row.CourseID}")' data-CourseID="${row.CourseID}" />
                </td>
            `;

                tableBody.appendChild(newRow);
            });
        }
    }
}

function getNotEnrolledCourses(roll_no){
    $.ajax({
        type: 'GET',
        url: '../Services/enrollment.php',
        data: { roll_no: roll_no, action: 'getNotEnrolledCourses' },
        success: function (response) {
            console.log(response);
            var data = JSON.parse(response);
            
            console.log(data);
            addCoursesToTable(data);


        },
        error: function (xhr, status, error) {
            console.error('Form submission failed');

        }

    });
}

var selectedCourses = []; // Array to store selected students' roll numbers

function getSelectedCourses(checkbox,CourseID) {
    console.log("comming here1");
    
      
       
        if (checkbox.checked) {
            // Student is checked, add to selectedStudents array
            selectedCourses.push(CourseID);
            console.log(selectedCourses);
            console.log("comming here");
        } else {
            // Student is unchecked, remove from selectedStudents array
            var index = selectedCourses.indexOf(CourseID);
            if (index !== -1) {
                selectedCourses.splice(index, 1);
            }
        }
}

//this i have to edit
var buttons = document.querySelectorAll(".submitCourses");


buttons.forEach(function(button){
    
    button.addEventListener("click",function(){
        // Get the course ID
        var roll_no = getParameterByName('roll_no');
    
        if (selectedCourses.length === 0) {
            $('#toastBody').text("Please Select Atleast One Course");
            $('.toast').toast('show');
            return;
        }
    
        $.ajax({
            type: 'GET',
            url: '../Services/enrollment.php',
            data: { roll_no: roll_no,selectedCourses: selectedCourses, action: 'addSelectedCoursesToEnrollment' },
            success: function (response) {
                console.log(response);
                getNotEnrolledCourses(roll_no);
                selectedCourses = [];
                $('#toastBody').text(response);
                $('.toast').toast('show');
                
               
            },
            error: function (xhr, status, error) {
                console.error('Form submission failed');
    
            }
    
        });
       
    })
});

document.getElementById("backButton").addEventListener("click", function() {
    // Get the course ID
    var roll_no = getParameterByName('roll_no');
    var name = getParameterByName('name');
    
    var url = 'enrolledCourses.php?roll_no=' + roll_no + '&name=' + name;
    
    // Redirect to the URL
    window.location.href = url;
   
});
