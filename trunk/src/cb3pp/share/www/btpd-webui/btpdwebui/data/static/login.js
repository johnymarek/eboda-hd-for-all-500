
function innerText (node, text) {
    var attrname = document.all ? 'innerText' : 'textContent';
    if (arguments.length == 2) {
    	node[attrname] = text;
    }
    return node[attrname];
}

function enterPressed(evt) {
    var charCode;
    if (evt && evt.which) {
        charCode = evt.which;
    }
    else {
        charCode = evt.keyCode;
    }
    if (charCode == 13) {        
        return true;
    }
    return false;
}

function login() {
    innerText($('error'), '');
    new Ajax.Request('/login', { 
        method     : 'post',
        parameters : { 
            username : $('username').value, 
            password : $('password').value 
        },
        onSuccess  : function(t) {
            var resp = t.responseText || 'Invalid response';
            if (resp == 'OK') {                
                document.location = '/torrents';
            }
            else {
                innerText($('error'), resp);
            }
        },
        onFailure  : function() {
            innerText($('error'), 'Request failed');
        },
        onException : function () {
            innerText($('error'), 'Can\'t connect to server');
        }
    });
}

function loginKeypress(e) {
    if (enterPressed(e)) {
        login();
    }
}

