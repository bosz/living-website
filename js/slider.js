$(document).ready(function() {
        var cwidth = parseInt($("#container").css("width").replace("px", ""));
        var img_count = $("#img_container").children().length;
        var img_width = $("#img1").width();
        var divider = cwidth / img_count;
        var small_space = (cwidth - img_width) / (img_count - 1);

        // set position
        var cssleft = Array();
        $("#img_container img").each(function(index) {
            cssleft[index] = new Array();
            // set default position
            cssleft[index][0] = (index * divider) - (index * img_width);
            $(this).css("left", cssleft[index][0] + "px");

            // set left position
            cssleft[index][1] = (index * small_space) - (index * img_width);

            // set right position
            var index2 = index;
            if (index2 == 0) {
                index2++;
            }
            cssleft[index][2] = cssleft[index2 - 1][1];
        });

        // image hover 
        $("#img_container img").mouseenter(function() {
            var img_id = parseInt($(this).attr("id").replace("img", "")) - 1;

            if ($(this).attr("id") != "img1") {
                $(this).animate({ 
                    left: cssleft[img_id][1] 
                }, 300);
            }                
            loopNext(this);
            loopPrev(this);
        });

        // image container hover out back to default position
        $("#img_container").mouseleave(function() {
            $("#img_container img").each(function(index) {
                $(this).animate({
                    left: cssleft[index][0]
                }, 300);
            });
        });

        function loopPrev(el) {
            if ($(el).prev().is("img")) {
                var imgprev_id = parseInt($(el).attr("id").replace("img", ""));

                if ($(el).prev().attr("id") != "img1") {
                    $(el).prev().animate({
                        left: cssleft[imgprev_id - 2][1]
                    }, 300);
                }
                loopPrev($(el).prev());
            }
        }

        function loopNext(el) {
            if ($(el).next().is("img")) {
                var imgnext_id = parseInt($(el).attr("id").replace("img", ""));

                $(el).next().animate({
                    left: cssleft[imgnext_id][2]
                }, 300);
                loopNext($(el).next());
            }
        }
    });