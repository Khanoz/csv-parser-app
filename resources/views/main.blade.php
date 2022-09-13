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
        <div class="box">
            <div class="container">
                <h3>Upload your file</h3>
                <div class="drag-area" ondrop="upload_file(event);">
                    <label for="selectFile" class="input_label">
                        Seleccionar archivo
                        <input type="file" id="selectFile" accept="text/csv">
                    </label>
                    <span class="header"> o Drag & Drop</span>
                    <span class ="support">Solo soporta archivos .csv</span>
                </div>
                <table>
                    <thead class="firstFile">
                    </thead>                
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <h3>Upload your file</h3>
                <div class="drag-area" ondrop="upload_file(event);">
                    <label for="selectFile" class="input_label">
                        Seleccionar archivo
                        <input type="file" id="selectFile" accept="text/csv">
                    </label>
                    <span class="header"> o Drag & Drop</span>
                    <span class ="support">Solo soporta archivos .csv</span>
                </div>
            </div>
        </div>
        <script src="js/main.js"></script>
    </body>
</html>
