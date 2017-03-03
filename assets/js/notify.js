
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)", "i"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
var msg = getParameterByName('msg');
var success = getParameterByName('success');


jQuery(document).ready(function() {
    if(success == 'true'){
        jQuery.gritter.add({
            title: 'Success!',
            text: msg,
            class_name: 'growl-success',
            image: 'images/screen.png',
            sticky: false,
            time: ''
        });
        return false;
    }
    else if(success == 'false'){
        jQuery.gritter.add({
            title: 'Error!',
            text: msg,
            class_name: 'growl-danger',
            image: 'images/screen.png',
            sticky: false,
            time: ''
        });
        return false;
    }
});

