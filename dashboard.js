/* // dashboard.js

function showAllData() {
    // AJAX-Anfrage senden
    $.get('get_all_data.php', function(data) {
        // Daten in JSON formatiert
        data = JSON.parse(data);
        
        // HTML für die Daten erstellen und anzeigen
        var html = '<table class="table table-bordered">';
        html += '<tr><th>Last Name</th><th>First Name</th><th>Speciality</th><th>Job Title</th><th>Skillset</th><th>Specialty</th><th>Interests</th><th>Comment</th><th>Profile Picture</th><th>Max Mentee</th><th>Is Mentor</th></tr>';
        data.forEach(function(row) {
            html += '<tr>';
            html += '<td>' + row.nachname + '</td>';
            html += '<td>' + row.vorname + '</td>';
            html += '<td>' + row.specialty + '</td>';
            html += '<td>' + row.job_title + '</td>';
            html += '<td>' + row.skillset + '</td>';
            html += '<td>' + row.speciality + '</td>';
            html += '<td>' + row.interests + '</td>';
            html += '<td>' + row.comment + '</td>';
            html += '<td>' + row.profile_picture + '</td>';
            html += '<td>' + row.max_mentee + '</td>';
            html += '<td>' + row.is_mentor + '</td>';
            html += '</tr>';
        });
        html += '</table>';
        
        // Daten in ein Element mit der ID "dataContainer" einfügen
        $('#dataContainer').html(html);
        
        // Button zum Verstecken der erweiterten Informationen hinzufügen
        $('#hideDetailsButton').show();
    });
}
// dashboard.js */

function showProfileDetails(userId) {
    var profileDetails = $('#profileDetails_' + userId);
    if (profileDetails.css('display') === 'none') {
        // Alle anderen Details verstecken
        $('tr[id^="profileDetails_"]').hide();
        // Erweiterte Informationen für den ausgewählten Benutzer anzeigen
        profileDetails.show();
    } else {
        // Erweiterte Informationen verstecken
        profileDetails.hide();
    }
}


// Funktion zum Verstecken der erweiterten Informationen
function hideDetails() {
    $('#dataContainer').empty(); // Leeren des Datencontainers
    $('#hideDetailsButton').hide(); // Verstecken des Buttons
}
