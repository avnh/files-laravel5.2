<div class="page_content_wrap">
   <div class="content_wrap">
        
    </div>
</div>
<!DOCTYPE html>
<html>
    <head>
        <title>Page Not Found!</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
        <div class="text-align-center error-404">
          <h1 class="huge">404</h1>
          <hr class="sm">
          <h2><strong>Sorry - Page Not Found!</strong></h2>
          <h3>The page you are looking for was moved, removed, renamed<br>or might never existed. You stumbled upon a broken link :(</h3>
        </div>
            </div>
        </div>
        <script type="text/javascript">
            window.setTimeout(function(){

                // Move to a new location or you can do something else
                window.location.href = "<?php echo e(asset('/')); ?>";

            }, 2000);

        </script>
    </body>
</html>
