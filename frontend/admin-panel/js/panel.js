function showUsersTable() {
    $('#users').css('display', 'block');
    $('#questions').css('display', 'none');
    $('#submissions').css('display', 'none');
    $('#settings').css('display', 'none');
}

function showSubmissionTable() {
    $('#users').css('display', 'none');
    $('#questions').css('display', 'none');
    $('#submissions').css('display', 'block');
    $('#settings').css('display', 'none');
}

function showQuestionsTable() {
    $('#users').css('display', 'none');
    $('#questions').css('display', 'block');
    $('#submissions').css('display', 'none');
    $('#settings').css('display', 'none');
}

function showSettings() {
    $('#users').css('display', 'none');
    $('#questions').css('display', 'none');
    $('#submissions').css('display', 'none');
    $('#settings').css('display', 'block');

}

function makeUsersActive() {
    $('#p').addClass('active');
    $('#s').removeClass('active');
    $('#q').removeClass('active');
    $('#set').removeClass('active');
}

function makeSubmissionActive() {
    $('#p').removeClass('active');
    $('#s').addClass('active');
    $('#q').removeClass('active');
    $('#set').removeClass('active');
}

function makeQuestionsActive() {
    $('#p').removeClass('active');
    $('#s').removeClass('active');
    $('#q').addClass('active');
    $('#set').removeClass('active');
}

function makeSettingsActive() {
    $('#p').removeClass('active');
    $('#s').removeClass('active');
    $('#q').removeClass('active');
    $('#set').addClass('active');
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
    $('#set').on('click', function() {
        showSettings();
        makeSettingsActive();
    });

});
