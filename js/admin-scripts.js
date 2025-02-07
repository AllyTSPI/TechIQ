var jqueryScript = document.createElement('script');
jqueryScript.src = 'https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js';
document.head.appendChild(jqueryScript);

// Dynamically load Bootstrap
var bootstrapScript = document.createElement('script');
bootstrapScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js';
document.head.appendChild(bootstrapScript);




$(document).ready(function() {
    // Hide all sections
    $('.dashboard-content, .activities-content, .quiz-content, .learning-materials-content, .users-content, .list-of-admins-content, .list-of-subjects-content').hide();

    // Use PHP session variable to determine which section to show
    var activeSection = "<?= $activeSection ?>";
    if (activeSection === "list-of-subjects") {
        $('.list-of-subjects-content').show();
    } else {
        $('.dashboard-content').show(); // Default to Dashboard
    }

    // Handle sidebar clicks
    $('#quizzes').click(function() {
        setActiveSection('quiz-content');
    });

    $('#dashboard').click(function() {
        setActiveSection('dashboard-content');
    });

    $('#activities').click(function() {
        setActiveSection('activities-content');
    });

    $('#learning-materials').click(function() {
        setActiveSection('learning-materials-content');
    });

    $('#users').click(function() {
        setActiveSection('users-content');
    });
    
    $('#list-of-admins').click(function() {
        setActiveSection('list-of-admins-content');
    });

    $('#list-of-subjects').click(function() {
        setActiveSection('list-of-subjects-content');
    });


    function setActiveSection(sectionClass) {
        // Hide all sections
        $('.dashboard-content, .activities-content, .quiz-content, .learning-materials-content, .users-content, .list-of-admins-content, .list-of-subjects-content').hide();
        // Show selected section
        $('.' + sectionClass).show();
    }
});