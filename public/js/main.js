//TODO: Check file for csv format
/*
    if (file_obj.type != 'text/csv'){
        suppText.textContent = "Solo acepta archivos .csv";
        suppText.style.color = 'red';
    }
    */
class InputFile{
    constructor(element, index){
        this.element = element;
        this.index = index;
    }
}

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


var fileArray = [null, null];
var time = Date.now();

const suppText = document.querySelector('.support');

const firstFile = document.querySelector('.firstFile');
file_explorer();
function upload_file(e, index) {
    e.preventDefault();
    var fileobj = e.dataTransfer.files[0];
    console.log("index is: "+index);
    fileArray[index] = fileobj;
    readFile(fileobj, index);
}
  
function file_explorer() {
    for(var i = 0; i < dragAreas.length; i++){
        let inputFile = new InputFile(document.getElementById('inputFile'+i), i);
        inputFile.element.click();
        inputFile.element.onchange = function() {
            var fileobj = inputFile.element.files[0];
            fileArray[inputFile.index] = fileobj;
            console.log("explorar index is: "+inputFile.index);
            readFile(fileobj, inputFile.index);
        };
    }
}
  
function readFile(fileobj, selectIndex){
    let reader = new FileReader();
    reader.readAsText(fileobj);
    reader.onload = function() {
        const headers = reader.result.slice(0, reader.result.indexOf("\n")).split(",");
        select = document.getElementById('file'+selectIndex);
        select.options.length = 0;
        colLinkSelect = document.getElementById('colLink'+selectIndex);
        colLinkSelect.options.length = 0;
        for (var i = 0; i<headers.length; i++){
            var opt = document.createElement('option');
            opt.value = i;
            opt.innerHTML = headers[i];
            select.appendChild(opt);
            var optCol = document.createElement('option');
            optCol.value = i;
            optCol.innerHTML = headers[i];
            colLinkSelect.appendChild(optCol);
        }
    };

    reader.onerror = function() {
        console.log(reader.error);
    };
}

function spinning_loader(){
    loader = document.getElementById("loader");
    loader.classList.remove("nodisplay");
    loader.classList.add("loader");
}

function ajax_file_upload() {
    var response = grecaptcha.getResponse();
    var errormsg = "";
    var showModal = false;
    var isRecaptcha = response.length == 0;
    var isFile0 = fileArray[0] == undefined;
    var isFile1 = fileArray[1] == undefined;

    errormsg  = isRecaptcha ? "Verificar que no es robot.<br>" : "";
    errormsg += isFile0     ? "Carga el primer archivo.<br>" : "";
    errormsg += isFile1     ? "Carga el segundo archivo." : "";
    
    showModal = isRecaptcha || isFile0 || isFile1;
    if(showModal){
        document.getElementById("modalText").innerHTML = errormsg;
        $("#myModal").modal();
    }
    else{
        spinning_loader();
        var form_data = new FormData();                  
        form_data.append('file0', fileArray[0]);         
        form_data.append('file1', fileArray[1]);
        form_data.append('time', time);
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "ajax.php", true);
        xhttp.onload = function(event) {
            if (xhttp.status == 200) {
                console.log('http finished, submitting form');
                submitForm();
                //oOutput.innerHTML = "<img src='"+ this.responseText +"' alt='The Image' />";
            } else {
                console.log(xhttp.status);
                //oOutput.innerHTML = "Error " + xhttp.status + " occurred when trying to upload your file.";
            }
        };
        xhttp.send(form_data);
    }
}

function submitForm(){
    document.getElementById('FN0').value = time+"_"+fileArray[0].name;
    document.getElementById('FN1').value = (time+5)+"_"+fileArray[1].name;
    document.getElementById('form').submit();
}
/* Captcha v3
function onClickCaptcha() {
    grecaptcha.ready(function() {
      grecaptcha.execute('key', {action: 'submit'}).then(function(token) {
          ajax_file_upload();
      });
    });
  }*/