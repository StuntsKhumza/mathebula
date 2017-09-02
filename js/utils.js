/*
 * this file was created to expose commonly used functions
 */

/*encode a string*/
function _b64EncodeUnicode(str) {
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, function (match, p1) {
        return String.fromCharCode('0x' + p1);
    }));
}

function _b64DecodeUnicode(str) {
    return decodeURIComponent(atob(str).split('').map(function (c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}

function _decodeCookieObject(cookie) {

    if (cookie != null) {

        cookie = _b64DecodeUnicode(cookie);

        cookie = JSON.parse(cookie);
    }

    return cookie;
}

function _find_Item(list, query) {

    var result = _.find(list, function (o) {
        return o.ID == query;
    });

    return result;

}

function _find_ItemIndexByID(list, query) {

    var result = _.findIndex(list, function (o) {
        return o.ID == query;
    });

    return result;

}

function _writeCookie_object(obj, cookie_name, cookiesservice) {
    var str = _b64EncodeUnicode(JSON.stringify(obj));
    cookiesservice.put(cookie_name, str);
}

function _getCookie(cookie_name, cookieservice) {

    var cookie = cookieservice.get(cookie_name);

    if (cookie !== null) {

        cookie = _decodeCookieObject(cookie);

    }


    return cookie;

}

function isMember(role, userRoles) {

    var str = JSON.stringify(userRoles);

    if (str.indexOf(role) > 0) {

        return true;

    }

    return false;
}

/*directives*/
