var no_of_questions = 1;

const formHTML = function(no_of_questions) {
    return `
    <div class="form-group">
        <label>Question ${no_of_questions}</label>
        <textarea class="form-control" name="question[]" rows="5" required></textarea>
    </div>
    <div class="form-group">
        <label>Option 1</label>
        <input type="text" name="option1[]" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Option 2</label>
        <input type="text" name="option2[]" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Option 3</label>
        <input type="text" name="option3[]" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Option 4</label>
        <input type="text" name="option4[]" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Correct Option</label>
        <input type="number" name="correct[]" class="form-control" required>
    </div>
    <hr id="line">
        `;
}

$(document).ready(function() {
    $('#add').on('click', function() {
        no_of_questions += 1;
        $('#sub').before(formHTML(no_of_questions));
    })
});
