function save_data() {
    var form_element = document.getElementsByClassName('form_data');
    var form_data = new FormData();
    for (var count = 0; count < form_element.length; count++) {
        form_data.append(form_element[count].name, form_element[count].value);
    }
    document.getElementById('contact-button').disabled = true;
    var ajax_request = new XMLHttpRequest();
    ajax_request.open('post', './porfolio/php/validate.php');
    ajax_request.send(form_data);
    ajax_request.onreadystatechange = function() {
        if (ajax_request.readyState == 4 && ajax_request.status == 200) {
            document.getElementById('contact-button').disabled = false;
            var response = JSON.parse(ajax_request.responseText);
            if (response.success != '') {
                document.getElementById('my_form').reset();
                document.getElementById('message').innerHTML = response.success;
                setTimeout(function() {
                    document.getElementById('message').innerHTML = '';
                    document.getElementById('name_error').innerHTML = '';
                    document.getElementById('email_error').innerHTML = '';
                    document.getElementById('comment_error').innerHTML = '';
                }, 5000);
            } else {
                document.getElementById('name_error').innerHTML = response.name_error;
                document.getElementById('email_error').innerHTML = response.email_error;
                document.getElementById('comment_error').innerHTML = response.comment_error;
            }
        }
    };
}
