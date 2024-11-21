document.getElementById("add-item-form").addEventListener("submit", function(event) {
    let name = document.getElementById("name").value;
    let description = document.getElementById("description").value;

    if (name === "" || description === "") {
        event.preventDefault();
        alert("Nama dan Deskripsi harus diisi!");
    }
});
