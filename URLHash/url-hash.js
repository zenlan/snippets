var handleHash = function(hash) {
  if (hash === false) {
    document.location.hash = '';
    return false;
  }
  if (hash !== undefined) {
    if (hash.indexOf('%') > -1) {
      document.location.hash = encodeURIComponent(hash);
    } else {
      document.location.hash = hash;
    }
    return false;
  }
  hash = document.location.hash.substr(1);
  hash = decodeURIComponent(hash);
  var quoted = unquote(hash);
  if (quoted) {
    hash = quoted;
  }
  if (sanitizeText(hash) === '') {
    document.location.hash = '';
  }
  return false;
};
var unquote = function(string) {
  var a = string.charCodeAt(0);
  var z = string.charCodeAt(string.length - 1);
  if (a === 34 && z === 34) {
    return string.replace(/\x22/g, '');
  }
  else if (a === 39 && z === 39) {
    return string.replace(/\x27/g, '');
  }
  return false;
};
var sanitizeText = function(string) {
  var result = string;
  try {
    if (typeof html_sanitize === 'function') {
      result = html_sanitize(string);
    }
  }
  catch (exception) {
    result = '';
  }
  return result;
};
