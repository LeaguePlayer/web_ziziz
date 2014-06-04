$("div.select_file").live('click', function(){
    $(this).prev("input[type=file]").trigger('click');
});

$(document).ready(function () {
    alignmentBlocks($("#announcements-form .right .gallery_body .preview"), 3);
});

function alignmentBlocks(blocks, columns){
    var len = blocks.length;
    var maxHeight;
    $(blocks).each(function(i, item){
        switch(i%3){
            case 0:
                maxHeight = $(this).height();
                break;
            case 1:
            case 2:
                if($(this).height() > maxHeight)
                    maxHeight = $(this).height();
                break;
        }
        if (i%3 == 2 || (len == 2 && i == 1)){
            var j = 0;
            while(j <= i%3){
                $(blocks[i-j]).height(maxHeight);
                j++;
            }
        }
    });
}