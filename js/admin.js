document.getElementById('search').addEventListener('keyup', function (e) {
    var searchBy = document.getElementById('searchBy').value;
    var search = document.getElementById('search').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'usersSearch.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.querySelector('.wrapperV2').innerHTML = xhr.responseText;
        }
    };

    var data = 'searchBy=' + encodeURIComponent(searchBy) + '&search=' + encodeURIComponent(search);
    xhr.send(data);
});

function hide() {
    var modal = document.getElementById("addUserModal");
    modal.style.top = "100vh";
    setTimeout(() => {
        modal.style.display = "none";
    }, 500);
}

function hide2() {
    // Hide the modal
    var modal = document.getElementById('modifyUserModal');
    modal.style.top = "100vh";
    setTimeout(() => {
        modal.style.display = "none";
    }, 500);

    var urlWithoutEdit = window.location.href.split('?')[0];
    history.replaceState({}, document.title, urlWithoutEdit);
}

function modal() {
    var modal = document.getElementById("addUserModal");
    modal.style.display = "flex";
    setTimeout(() => {
        modal.style.top = "0";
    }, 100);
}

//To show
var url = window.location.href;
var str = url.substring(url.indexOf("?") + 1);
console.log(str);
if (str.includes("edit")) {
    var modifyUserModal = document.getElementById("modifyUserModal");
    modifyUserModal.style.display = "flex";
    setTimeout(() => {
        modifyUserModal.style.top = "0";
    }, 100);
}