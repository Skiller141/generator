document.addEventListener('DOMContentLoaded', function() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 & this.status === 200) {
            var myObj = JSON.parse(this.responseText);
            console.log(myObj);
            document.getElementsByClassName('logo')[0].style.background = "url('" + myObj['site logo'] + "') 0 0 / 100% 100%";
            // document.getElementsByClassName('logo')[0].style.backgroundSize = '100% 100%';
            document.getElementsByTagName('title')[0].innerHTML = myObj['site title'];
        }
    }
    xhr.open('GET', 'config.json');
    xhr.send();
});