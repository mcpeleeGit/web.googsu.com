/*global toastr*/
/* eslint-disable no-unused-vars */
console.stdlog = console.log.bind(console);
console.log = function () {
    var output = JSON.stringify(Array.from(arguments));
    setToastr(output);
    console.stdlog.apply(console, arguments);
}

function setToastr(output) {
    toastr.options.timeOut = 4000;
    toastr.options.closeButton = true;
    if (output.indexOf("msg") > -1 && output.indexOf("code") > -1) toastr.error(output);
    else toastr.success(output);
}