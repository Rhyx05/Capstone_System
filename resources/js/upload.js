const input = document.getElementById("document");
const browse = document.getElementById("browseButton");
const dropzone = document.getElementById("dropzone");

const fileName = document.getElementById("fileName");
const fileSize = document.getElementById("fileSize");
const fileType = document.getElementById("fileType");
const previewIcon = document.getElementById("previewIcon");

if (browse) {

    browse.onclick = () => input.click();

}

function updatePreview(file)
{
    if (!file) return;

    fileName.innerHTML = file.name;

    fileSize.innerHTML =
        (file.size / 1024 / 1024).toFixed(2) + " MB";

    let extension =
        file.name.split('.').pop().toUpperCase();

    fileType.innerHTML = extension;

    if (extension === "PDF") {

        previewIcon.innerHTML = "📕";

    }

    else if (extension === "DOC" || extension === "DOCX") {

        previewIcon.innerHTML = "📘";

    }

    else {

        previewIcon.innerHTML = "📄";

    }

}

input?.addEventListener("change", function () {

    updatePreview(this.files[0]);

});

dropzone?.addEventListener("dragover", function(e){

    e.preventDefault();

    dropzone.classList.add("bg-blue-100");

});

dropzone?.addEventListener("dragleave", function(){

    dropzone.classList.remove("bg-blue-100");

});

dropzone?.addEventListener("drop", function(e){

    e.preventDefault();

    dropzone.classList.remove("bg-blue-100");

    input.files = e.dataTransfer.files;

    updatePreview(e.dataTransfer.files[0]);

});