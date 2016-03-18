$(document).ready(function(){

    var elements = {};

    var removeSuccess = function(resp){
        if(elements.hasOwnProperty(resp.t)){
            if(resp.deleted === true){
                elements[resp.t].remove();
            }else{
                elements[resp.t].removeClass('removing');
            }
            if(resp.message){
                alert(resp.message);
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

        elements[e.timeStamp] = media;

        $.post(url, {t: e.timeStamp}).
            done(removeSuccess).
            error(removeError);

        return false;
    });
});
