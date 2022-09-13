<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">        
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/maintest.css') }}">
    </head>
<body>
    <!------ Include the above in your HEAD tag ---------->

    <div class="container">
        <div class="row">
        <div class="col-md-6">
            <form method="post" action="#" id="#">
            
                
                
                
                <div class="form-group files">
                    <label>Upload Your File </label>
                    <input type="file" class="form-control" multiple="">
                </div>
                
                
            </form>
            
            
        </div>
        <div class="col-md-6">
            <form method="post" action="#" id="#">
            
                
                
                
                <div class="form-group files color">
                    <label>Upload Your File </label>
                    <input type="file" class="form-control" multiple="">
                </div>
                
                
            </form>
            
            
        </div>
        </div>
    </div>
</body>
</html>