/**
 * Created with JetBrains PhpStorm.
 * User: Andy
 * Date: 23/10/13
 * Time: 16:17
 * TODO: progress
 */
(function (window) {
    window.URL = window.URL || window.webkitURL;
    var _ = function (label, attr) {
        _.fn.addChild(label, attr);
        return this;
    };
    _.target = window.document.body;
    _.context = document;
    _.tag = 'jload';
    _.prefix = 'jload_';
    _.expire = 'expire_';
    _.expTime = 60 * 60 * 24 * 365;
    _.ls = window.localStorage;
    _._url = { script: 'src' };
    _._mime = { script: 'application/javascript' };
    _.files = {};
    _.totalSize = 0;
    _.doneSize = 0;

    _.onprogress = null;

    _.fn = _.prototype = {
        appendChild: function (label, attr, url) {
            var js = _.context.createElement(label);
            for (var key in attr)if (attr.hasOwnProperty(key)) js.setAttribute(key, attr[key]);
            js.setAttribute(_._url[label], url);
            _.target.appendChild(js);
        },
        init: function () {
            var child = _.context.getElementsByTagName(_.tag);
            for (var i = 0; i < child.length; ++i) {
                var attr = {};
                for (var j = 0; j < child[i].attributes.length; ++j)
                    attr[child[i].attributes[j].name] = child[i].attributes[j].value;
                _.fn.addChild('script', attr);
            }
        },
        addChild: function (label, attr) {
            var url = attr[_._url[label]]
                , item, exp;
            if (!_.ls) {
                _.fn.appendChild(label, attr, url);
                return;
            }
            if (exp = _.ls.getItem(_.expire + url) && exp < (new Date()).getTime())_.removeItem(url);
            if (!(item = _.ls.getItem(_.prefix + url))) {
                var _req = null;
                if (window.XMLHttpRequest)
                    try {
                        _req = new XMLHttpRequest();
                    } catch (e) {
                        _req = null;
                    }
                if (_req) {
                    _req.open("GET", url, true);
                    _req.onprogress = function (e) {
                        if (!_.files[url]) {
                            _.files[url] = {
                                size: _req.getResponseHeader("Content-Length") * 1,
                                done: e.loaded
                            };
                            _.totalSize += _.files[url].size;
                            _.doneSize += e.loaded;
                        } else {
                            _.doneSize += e.loaded - _.files[url].done;
                            _.files[url].done = e.loaded;
                        }
                        if (_.onprogress)_.onprogress(_.totalSize, _.doneSize, _.files);
                    };
                    _req.onreadystatechange = function () {
                        if (_req.readyState == 4 && _req.status == 200) {
                            _.ls.setItem(_.prefix + url, _req.response);
                            _.ls.setItem(_.expire + url, (new Date()).getTime() + _.expTime);
                            var a = _.fn.getBlob([item], _._mime[label]);
                            url = window.URL.createObjectURL(a);
                        }
                        _.fn.appendChild(label, attr, url);
                    };
                    _req.setRequestHeader("Content-Type", _._mime[label]);
                    _req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
                    _req.send("");
                    return;
                }
                _.fn.appendChild(label, attr, url);
                return;
            }
            var a = _.fn.getBlob([item], _._mime[label]);
            url = window.URL.createObjectURL(a);
            _.fn.appendChild(label, attr, url);
        },
        removeItem: function (url) {
            if (!_.ls) return;
            _.ls.removeItem(_.expire + url);
            _.ls.removeItem(_.prefix + url);
        },
        getBlob: function (jarray, type) {
            var blob = null;
            try {
                blob = new Blob(jarray, { type: type });
            }
            catch (e) {
                window.BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder || window.MSBlobBuilder;
                var bb = new BlobBuilder();
                for (var i in jarray) bb.append(jarray[i]);
                blob = bb.getBlob(type);
            }
            return blob;
        }
    };

// Expose jLoad to the global object
    window.jLoad = window._ = _;
    _.fn.init();
})(window);