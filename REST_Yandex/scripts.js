function ajaxScript() {
    let res = true;
    let form = new FormData(document.getElementById('form'));
    fetch('/intaro-PHP/REST_Yandex/REST.php', {
            method: 'POST',
            body: form
        }
    )
        .then(response => response.json())
        .then((result) => {
            document.getElementById('list').innerText = "";

            let a = document.createElement("a");
            a.innerText = result.address;
            a.className = "list-group-item list-group-item-action";
            document.getElementById('list').appendChild(a);

            a = document.createElement("a");
            a.innerText = result.coordinates;
            a.className = "list-group-item list-group-item-action";
            document.getElementById('list').appendChild(a);

            a = document.createElement("a");
            a.innerText = result.metro;
            a.className = "list-group-item list-group-item-action";
            document.getElementById('list').appendChild(a);
        })
        .catch(error => console.log(error));
}