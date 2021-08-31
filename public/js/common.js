$(function() {
    $('.comments-section').on('click', '.comment__reply', function() {
        $(this).parent().next().toggle(300);
        return false
    }) 
})
$.ajaxSetup({
    headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});
$(function() {
    $(document).on('click', '#btn-answer-id', function() {
        let parent = $(this).parents('.parent-answer'),
            parentId = 0,
            commentText = $('#comment-answer').val(),
            commentDepth = 0,
            commentMargin =  0;
             $.post(
              '/comments/reply',
               {   comment: commentText,
                   parentId: parentId,
                },
            function(commentData) {
                if (commentData.message) {
                   parent.before(`
                        <div class="comment" style="margin-left: ${commentMargin}px" data-comment-depth="${commentDepth}" data-comment-id="${commentData.id}">
                            <header class="comment__header">
                                <span class="comment__author">${commentData.name}</span>
                                <hr class ="line-user">
                                <span class="date-messages">'${commentData.created_at}</span>
                            </header>
                            <div class="comment__body">${commentData.message}</div>
                            <footer class="comment__footer">
                                <a class="comment__reply" href="#">Reply</a>
                            </footer>
                            <form class="form-reply">
                                <div class="form-group">
                                    <textarea class="form-control form-reply__textarea" name="comment" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary form-reply__btn" type="submit" name="submit">Reply a comment</button>
                                </div>
                            </form>
                    `)
                } else {
                    parent.find('.validation-error').remove();
                    parent.append(`<span class="validation-error">${(commentData.commentErr)}</span>`);
                }
            }
        )
        return false
    })
})

$(function() {
    $(document).on('click', '#btn-answer-reply', function() {
        let parent = $(this).parents('.comment'),
            parentId = parent.attr('data-comment-id'),
            commentText = $(this).parents('.comment').find('.form-reply__textarea').val(),
            parentDepth = parent.attr('data-comment-depth'),
            parentMargin = parseInt(parent.css('margin-left'))
        $.post(
            '/comments/reply',
            {
                comment: commentText,
                parentId: parentId
            },
            function(commentData) {
                if (commentData.message) {
                    let commentDepth = +parentDepth + 1,
                    commentMargin = parentMargin + 20
                        parent.after(`
                            <div class="comment" style="margin-left: ${commentMargin}px" data-comment-depth="${commentDepth}" data-comment-id="${commentData.id}">
                            <header class="comment__header">
                            <span class="comment__author">${commentData.name}</span>
                                <hr class ="line-user">
                                <span class="date-messages">'${commentData.created_at}</span>
                            </header>
                            <div class="comment__body">${commentData.message}</div>
                        `)                                                              
                    let comment = $(`[data-comment-id="${commentData.id}"]`)
                    if (commentDepth < 3) {
                        comment.append(`
                            <footer class="comment__footer">
                                <a class="comment__reply" href="#">Reply</a>
                            </footer>
                            <form class="form-reply">
                                <div class="form-group">
                                    <textarea class="form-control form-reply__textarea" name="comment" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary form-reply__btn" type="submit" name="submit">Reply a comment</button>
                                </div>
                            </form>
                        `)
                    }
                } else {
                    parent.find('.validation-error').remove();
                    parent.append(`<span class="validation-error">${(commentData.commentErr)}</span>`);
                }
            }
        )
        return false
    })
})
