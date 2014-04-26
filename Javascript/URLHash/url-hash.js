  var unquote = function (string) {
          "use strict";
          var a = string.charCodeAt(0),
                  z = string.charCodeAt(string.length - 1);
          if (a === 34 && z === 34) {
                  return string.replace(/\x22/g, '');
          }
          if (a === 39 && z === 39) {
                  return string.replace(/\x27/g, '');
          }
          return false;
  };
  var sanitizeText = function (string) {
          "use strict";
          var result = string;
          try {
                  if (typeof html_sanitize === 'function') {
                          result = html_sanitize(string);
                  }
          } catch (exception) {
                  result = '';
          }
          return result;
  };
  var handleHash = function (hash) {
          "use strict";
          var doc = document;
          if (hash === false) {
                  doc.location.hash = '';
                  return false;
          }
          if (hash !== undefined) {
                  if (hash.indexOf('%') > -1) {
                          doc.location.hash = encodeURIComponent(hash);
                  } else {
                          doc.location.hash = hash;
                  }
                  return false;
          }
          hash = decodeURIComponent(doc.location.hash.substr(1));
          var quoted = unquote(hash);
          if (quoted) {
                  hash = quoted;
          }
          if (sanitizeText(hash) === '') {
                  doc.location.hash = '';
          }
          return false;
  };