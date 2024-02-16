document.addEventListener('DOMContentLoaded', function() {
    var showCommentFormButton = document.getElementById('show-comment-form-btn');
    
    var commentForm = document.getElementById('comment-form');
    
    showCommentFormButton.addEventListener('click', function() {
        if (commentForm.style.display === 'none') {
            commentForm.style.display = 'block';
        } else {
            commentForm.style.display = 'none';
        }
    });
});