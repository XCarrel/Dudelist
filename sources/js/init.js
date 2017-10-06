

$(document).ready(function () {
    if (typeof initForm == 'function') initForm(); // invoke function only if it has been defined
    $('.moduleinfo').draggable({
        revert : function(event, ui) {
            $(this).data("uiDraggable").originalPosition = {
                top : 0,
                left : 0
            };
            return !event;
        }
    });
    $('#content').droppable({
        drop: function(event, ui) {
            console.log('dropped '+$(ui.draggable).attr('id')+' on '+$(this).attr('id'));
        }
    });
});