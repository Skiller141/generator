document.addEventListener('DOMContentLoaded', function() {
    var newPrjBtn = document.getElementsByClassName('new-project-btn')[0];
    var newPrjPopup = document.getElementsByClassName('new-project-popup')[0];
    var prjErrorPopup = document.getElementsByClassName('prj-error-popup')[0];
    var mask = document.getElementsByClassName('mask')[0];
    var close = document.getElementsByClassName('close')[0];

    newPrjBtn.addEventListener('click', function() {
        newPrjPopup.style.display = 'block';
        mask.style.display = 'block';
        close.style.display = 'block';
    });

    mask.addEventListener('click', function() {
        newPrjPopup.style.display = 'none';
        mask.style.display = 'none';
        close.style.display = 'none';
        prjErrorPopup.style.display = 'none';
    });

    close.addEventListener('click', function() {
        newPrjPopup.style.display = 'none';
        mask.style.display = 'none';
        close.style.display = 'none';
        prjErrorPopup.style.display = 'none';
    });


    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === 4 & this.status === 200) {
            var myObj = JSON.parse(this.responseText);
            console.log(myObj);
            document.getElementById('project-title').value = myObj['site title'];
            if (myObj['switch_2'] == 'yes') {
                document.getElementById('switch_left').checked = 'true';
                document.getElementsByClassName('add-logo-field')[0].style.display = 'block';
                document.getElementsByClassName('add-text-field')[0].style.display = 'none';

            } else if (myObj['switch_2'] == 'no') {
                document.getElementById('switch_right').checked = 'true';
                document.getElementsByClassName('add-text-field')[0].style.display = 'block';
                document.getElementsByClassName('add-logo-field')[0].style.display = 'none';
            }
            document.querySelector('.logo-now').style.background = "url("+myObj['site logo']+")";
        }
    }
    xhr.open('GET', 'config.json');
    xhr.send();

    document.forms['settings-form'].addEventListener('change', function(){
        if(document.getElementById('switch_left').checked){
            document.getElementsByClassName('add-logo-field')[0].style.display = 'block';
            document.getElementsByClassName('add-text-field')[0].style.display = 'none';
        } else if (document.getElementById('switch_right').checked){
            document.getElementsByClassName('add-text-field')[0].style.display = 'block';
            document.getElementsByClassName('add-logo-field')[0].style.display = 'none';

        }
    });
});