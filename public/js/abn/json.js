/*------------------------------------------------------------------
   Class for accessing services using JSON
  ------------------------------------------------------------------*/
function jsonRequest(url) {
    this.url = url;
    this.noCacheIE = "&noCacheIE=" + new Date().getTime();
    this.headLoc = document.getElementsByTagName("head").item(0);
    this.scriptId = "sflScriptId" + jsonRequest.Counter++;
}
jsonRequest.Counter = 1;
jsonRequest.prototype.buildScriptTag = function () {
    // Create  script tag with unique id
    this.scriptObject = document.createElement("script");
    this.scriptObject.setAttribute("type", "text/javascript");
    this.scriptObject.setAttribute("src", this.url + this.noCacheIE);
    this.scriptObject.setAttribute("id", this.scriptId);
};
// remove script tag
jsonRequest.prototype.removeScriptTag = function () {
    this.headLoc.removeChild(this.scriptObject);
};
// add script tag
jsonRequest.prototype.addScriptTag = function () {
    this.headLoc.appendChild(this.scriptObject);
};
/*------------------------------------------------------------------
  return value of field
------------------------------------------------------------------*/
function getFieldValue(fieldId) {
    var oField = document.getElementById(fieldId);
    if (oField) {
        return oField.value;
    } else {
        return "";
    }
}
/*------------------------------------------------------------------
  populate field with value
------------------------------------------------------------------*/
function setFieldValue(fieldId, value) {
    var oField = document.getElementById(fieldId);
    if (oField) {
        oField.value = value;
    }
}
/*------------------------------------------------------------------
Add value to listbox
------------------------------------------------------------------*/
function addValueToListBox(fieldId, value) {
    var oField = document.getElementById(fieldId);
    if (oField) {
        var o = document.createElement("option");
        o.text = value;
        o.value = value;
        oField.add(o);
    }
}
/*------------------------------------------------------------------
Clear values in listbox
------------------------------------------------------------------*/
function clearListBox(fieldId) {
    var oField = document.getElementById(fieldId);
    if (oField) {
        var length = oField.options.length;
        for (var i = length - 1; i >= 0; i--) {
            oField.options.remove(i);
        }
    }
}
