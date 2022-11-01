<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }}">
    </head>
    <body>
        <div id="loader" class="bg nodisplay"></div> 
        <form id="form" class="box" action="{{route('comparecsv')}}" method="POST" enctype="multipart/form-data">
        @csrf <!-- {{ csrf_field() }} -->
        <div id="container" class="container">
            <h3>Upload your file</h3>
            <div class="drag-area" ondrop="upload_file(event, 0);">
                <label for="inputFile0" class="input_label">
                    Seleccionar archivo
                    <input name='csvfile' type="file" id="inputFile0" class="selectFile" accept="text/csv">
                </label>
                <span class="header"> o Drag & Drop</span>
                <span class ="support">Solo soporta archivos .csv</span>
            </div>
            <div class="selectDiv">
                <div>
                    <h3>Columna a comparar</h3>
                    <select name="file0" id="file0">
                    </select>
                </div>
                
                <div>
                    <h3>Columna a conectar</h3>
                    <select name="columnLink0" id="colLink0">
                    </select>
                </div>
            </div>
        </div>

        <div class="container">
            <h3>Upload your file</h3>
            <div class="drag-area" ondrop="upload_file(event, 1);">
                <label for="inputFile1" class="input_label">
                    Seleccionar archivo
                    <input  type="file" id="inputFile1" class="selectFile" accept="text/csv">
                </label>
                <span class="header"> o Drag & Drop</span>
                <span class ="support">Solo soporta archivos .csv</span>
            </div>
            <div class="selectDiv">
                <div>
                    <h3>Columna a comparar</h3>
                    <select name="file1" id="file1">
                    </select>
                </div>
                <div>
                    <h3>Columna a conectar</h3>
                    <select name="columnLink1" id="colLink1">
                    </select>
                </div>
            </div>
        </div>
        <input type="text" name="fileName0" style="display: none" id="FN0">
        <input type="text" name="fileName1" style="display: none" id="FN1">
        <button id="compareBtn" type="button" onclick="ajax_file_upload();" >Comparar Archivos</button>
        </form>
        <script src="js/main.js"></script>
    </body>
</html>
