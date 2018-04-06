var newPrjBtn = document.getElementsByClassName('new-project-btn')[0];
var newPrjPupup = document.getElementsByClassName('new-project-pupup')[0];
var mask = document.getElementsByClassName('mask')[0];
var close = document.getElementsByClassName('close')[0];

newPrjBtn.addEventListener('click', function() {
    newPrjPupup.style.display = 'block';
    mask.style.display = 'block';
    close.style.display = 'block';
});

mask.addEventListener('click', function() {
    newPrjPupup.style.display = 'none';
    mask.style.display = 'none';
    close.style.display = 'none';
});

close.addEventListener('click', function() {
    newPrjPupup.style.display = 'none';
    mask.style.display = 'none';
    close.style.display = 'none';
});

// var addProjectForm = document.getElementById('add-project');
// addProjectForm.addEventListener('submit', function(e) {
//     var xhr = new XMLHttpRequest();
//     var data = new FormData(this);
//     xhr.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             location.reload();
//         }
//     };
//     xhr.open(this.method, this.action);
//     xhr.send(data);

//     newPrjPupup.style.display = 'none';
//     mask.style.display = 'none';
//     e.preventDefault();
// });

// document.forms['add-project'].addEventListener('submit', function() {
//     var xhr = new XMLHttpRequest();
//     var prjTitleVal = this['project-title'].value;

//     xhr.open('GET', 'add-project2.php?project-title=' + prjTitleVal);
//     xhr.send();

//     newPrjPupup.style.display = 'none';
//     mask.style.display = 'none';
// });