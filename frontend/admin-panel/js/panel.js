function showUsersTable() {
    $('#users').css('display', 'block');
    $('#questions').css('display', 'none');
    $('#submissions').css('display', 'none');
}

function showSubmissionTable() {
    $('#users').css('display', 'none');
    $('#questions').css('display', 'none');
    $('#submissions').css('display', 'block');
}

function showQuestionsTable() {
    $('#users').css('display', 'none');
    $('#questions').css('display', 'block');
    $('#submissions').css('display', 'none');
}

function makeUsersActive() {
    console.log('happening');
    $('#p').addClass('active');
    $('#s').removeClass('active');
    $('#q').removeClass('active');
}

function makeSubmissionActive() {
    $('#p').removeClass('active');
    $('#s').addClass('active');
    $('#q').removeClass('active');
}

function makeQuestionsActive() {
    $('#p').removeClass('active');
    $('#s').removeClass('active');
    $('#q').addClass('active');
}

$(document).ready(function() {
    showSubmissionTable();
    makeSubmissionActive();
    $('#p').on('click', function() {
        showUsersTable();
        makeUsersActive();
    });
    $('#s').on('click', function() {
        showSubmissionTable();
        makeSubmissionActive();
    });
    $('#q').on('click', function() {
        showQuestionsTable();
        makeQuestionsActive();
    });
});
