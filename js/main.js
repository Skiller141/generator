var rightMenu = document.getElementsByClassName('right-menu')[0];
var toggle = document.getElementsByClassName('toggle')[0];
toggle.addEventListener('change', function() {
    if (toggle.checked == true) {
        rightMenu.style.display = 'block';
        console.log(1);
    } else {
        rightMenu.style.display = 'none';
        console.log(0);
    }
});

var logoPos = document.getElementsByClassName('logo-pos-radio');
var logo = document.getElementsByClassName('logo')[0];
for (var i = 0; i < logoPos.length; i++) {
    logoPos[i].addEventListener('change', function() {
        if (logoPos[0].checked) {
            logo.className = 'logo';
            logo.classList.add('logo-pos-left');
        } else if (logoPos[1].checked) {
            logo.className = 'logo';
            logo.classList.add('logo-pos-center');
        } else if (logoPos[2].checked) {
            logo.className = 'logo';
            logo.classList.add('logo-pos-right');
        }
    });
}

var uploadLogoForm = document.getElementById('upload-logo-form');
uploadLogoForm.addEventListener('submit', function(e) {
    e.preventDefault();
    var form = e.target;
    var xhr = new XMLHttpRequest;
    var data = new FormData(this);
    xhr.onreadystatechange = function() {
        // if (xhr.readyState === 4 && xhr.status === 200) {
        document.getElementById('out').innerHTML = xhr.responseText;
        document.getElementsByClassName('logo')[0].innerHTML = xhr.responseText;
        // } else {
        //     alert('error');
        // }
    }
    xhr.open(this.method, this.action);
    xhr.send(data);
});