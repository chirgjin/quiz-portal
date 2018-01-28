var no_of_questions = 1;

const formHTML = function(no_of_questions) {
    return `
        <div class="form-group">
            <label>Question 1</label>
            <textarea class="form-control" name="question" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label>Option 1</label>
            <input type="text" name="option1" class="form-control">
        </div>
        <div class="form-group">
            <label>Option 2</label>
            <input type="text" name="option2" class="form-control">
        </div>
        <div class="form-group">
            <label>Option 3</label>
            <input type="text" name="option3" class="form-control">
        </div>
        <div class="form-group">
            <label>Option 4</label>
            <input type="text" name="option4" class="form-control">
        </div>
        <div class="form-group">
            <label>Correct Option</label>
            <br>
            <label class="radio-inline">
                <input type="radio" name="correctOption">
                Option 1
            </label>
            <label class="radio-inline">
                <input type="radio" name="correctOption">
                Option 2
            </label>
            <label class="radio-inline">
                <input type="radio" name="correctOption">
                Option 3
            </label>
            <label class="radio-inline">
                <input type="radio" name="correctOption">
                Option 4
            </label>
        </div>
        <hr id="line">
        `;
}

$(document).ready(function() {
    $('#add').on('click', function() {
        no_of_questions += 1;
        $('form').append(formHTML(no_of_questions));
    })
});
