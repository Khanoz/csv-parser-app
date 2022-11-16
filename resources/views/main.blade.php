<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }}">
    </head>
    <body>
        <div id="loader" class="bg nodisplay"></div> 
        <form id="form" class="box" action="{{route('comparecsv')}}" method="POST" enctype="multipart/form-data">
        @csrf <!-- {{ csrf_field() }} -->
        <div id="container" class="container">
            <p>Upload your file</p>
            <div class="drag-area" ondrop="upload_file(event, 0);">
                <label for="inputFile0" class="">
                    <input name='csvfile' type="file" id="inputFile0" class="selectFile" accept="text/csv">
                </label>
                <span class="header"> o Drag & Drop</span>
                <span class ="support">Solo soporta archivos .csv</span>
            </div>
            <div class="selectDiv">
                <div>
                    <p>Columna a comparar</p>
                    <select name="file0" id="file0">
                    </select>
                </div>
                
                <div>
                    <p>Columna a conectar</p>
                    <select name="columnLink0" id="colLink0">
                    </select>
                </div>
            </div>
        </div>

        <div class="container">
            <p>Upload your file</p>
            <div class="drag-area" ondrop="upload_file(event, 1);">
                <label for="inputFile1">
                    <input  type="file" id="inputFile1" class="selectFile" accept="text/csv">
                </label>
                <span class="header"> o Drag & Drop</span>
                <span class ="support">Solo soporta archivos .csv</span>
            </div>
            <div class="selectDiv">
                <div>
                    <p>Columna a comparar</p>
                    <select name="file1" id="file1">
                    </select>
                </div>
                <div>
                    <p>Columna a conectar</p>
                    <select name="columnLink1" id="colLink1">
                    </select>
                </div>
            </div>
        </div>
        <input type="text" name="fileName0" style="display: none" id="FN0">
        <input type="text" name="fileName1" style="display: none" id="FN1">
        
        </form>
        <div id="captchaDiv">
            <div class="g-recaptcha" data-sitekey="6Le9GxAjAAAAADwntvA1hJjmfBcDmEtKKsZFovT7"></div>
            <button class="btn btn-primary" id="compareBtn" type="button" onclick="ajax_file_upload();">Comparar Archivos</button>   
            <br/>

        </div>
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Error:</h4>
            </div>
            <div class="modal-body">
                <p id="modalText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
        </div>



        <script src="https://www.google.com/recaptcha/api.js" async defer></script>   
        <script src="js/main.js"></script>
    </body>
</html>
