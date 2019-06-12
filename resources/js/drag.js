let dropzone = document.getElementById('dropzone');
document.addEventListener('drag', function (e) {
    console.log(e);
}, false);

document.addEventListener('dragstart', function (e) {
    console.log(e);
}, false);

document.addEventListener('dragend', function (e) {
    console.log(e);

}, false);

document.addEventListener('dragover', function (e) {
    // prevent default to allow drop
    e.preventDefault();
    console.log(e);
}, false);

document.addEventListener('dragenter', function (e) {

}, false);

document.addEventListener('dragleave', function (e) {

}, false);

document.addEventListener('drop', function (e) {
    console.log(e);
}, false);
