
function torrentUpdate(tab) {
    var date = new Date();
    new Ajax.Updater('content', '/torrents', {
        method     : 'get',
        parameters : {
            tab    : tab,
            action : 'update',
            /* to stop ie7 from caching responses */
            time   : date.getTime()
        },
        onFailure  : function() {
            document.location = '/logout';
        },
        onException : function () {
            document.location = '/logout';
        }
    });
}

function startUpdater(freq, tab) {
    torrentUpdate(tab);
    new PeriodicalExecuter(function() {
        torrentUpdate(tab);
    }, freq);
}

function torrentAction(num, action) {
    new Ajax.Request('/torrents', {
        method     : 'post',
        parameters : {
            num    : num,
            action : action
        }
    });
}

