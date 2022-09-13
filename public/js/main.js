const dragAreas = document.querySelectorAll('.drag-area');

for(i = 0; i < dragAreas.length; i++){ 
    dragAreas[i].addEventListener('dragenter', (event)=>{
        event.preventDefault();
    });
    dragAreas[i].addEventListener('dragover', (event)=>{
        event.preventDefault();
    });
    dragAreas[i].addEventListener('dragleave', (event)=>{
        event.preventDefault();
    });
}



var fileobj;
const suppText = document.querySelector('.support');

const firstFile = document.querySelector('.firstFile');
file_explorer();
function upload_file(e) {
    e.preventDefault();
    fileobj = e.dataTransfer.files[0];
    ajax_file_upload(fileobj);
    let reader = new FileReader();
    reader.readAsText(fileobj);
    reader.onload = function() {
        const headers = reader.result.slice(0, reader.result.indexOf("\n")).split(",");
        console.log(headers);
        suppText.textContent = headers;
        
        var row = firstFile.insertRow();
        for(i = 0; i < headers.length; i++){
            var td = row.insertCell(i);
            td.innerText = headers[i];
        }
    };

    reader.onerror = function() {
        console.log(reader.error);
    };
}
  
function file_explorer() {
    document.getElementById('selectFile').click();
    document.getElementById('selectFile').onchange = function() {
        fileobj = document.getElementById('selectFile').files[0];
        ajax_file_upload(fileobj);
    };
}
  
function ajax_file_upload(file_obj) {
    if (file_obj.type != 'text/csv'){
        suppText.textContent = "Solo acepta archivos .csv";
        suppText.style.color = 'red';
    }
    if(file_obj != undefined) {
        var form_data = new FormData();                  
        form_data.append('file', file_obj);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "ajax.php", true);
        xhttp.onload = function(event) {
            oOutput = document.querySelector('.img-content');
            if (xhttp.status == 200) {
                oOutput.innerHTML = "<img src='"+ this.responseText +"' alt='The Image' />";
            } else {
                oOutput.innerHTML = "Error " + xhttp.status + " occurred when trying to upload your file.";
            }
        }
        console.log(file_obj)
        xhttp.send(form_data);
        document.getElementById("selectFile").value = "";
    }
}