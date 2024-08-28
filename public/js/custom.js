function show(value) {
    document.getElementById('loader').style.display = value ? 'block' : 'none';
}

function loadPage(URL) {
    show(true);
    location = URL;
}

function newTab(URL) {
    window.open(URL, '_blank');
}

setTimeout(function() {
    show(false);
}, 2000);
