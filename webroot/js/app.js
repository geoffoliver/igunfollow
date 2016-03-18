$(document).ready(function(){

    var elements = {};

    var removeSuccess = function(resp){
        if(elements.hasOwnProperty(resp.t)){
            if(resp.deleted === true){
                elements[resp.t].remove();
            }else{
                elements[resp.t].removeClass('removing');
            }
            delete(elements[resp.t]);
        }
    };

    var removeError = function(){
        $('.removing').removeClass('removing');
    };

    $('.unfollow').on('click', function(e){
        var el = $(e.target),
            url = el.attr('href')+'.json',
            media = el.parents('.media');

        media.addClass('removing');

        elements[e.timestamp] = media;

        $.post(url, {t: e.timestamp}).
            done(removeSuccess).
            error(removeError);

        return false;
    });
});
