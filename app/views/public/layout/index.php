<!DOCTYPE html>
<html class="full" lang="en">    

    <head>
        {% include head.php %}
    </head>

    <body>

        {% include navigation.php %}

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h1>{{page_title}}</h1>
                    <p>{{page_content}}</p>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->

        {% include script.php %}
        
    </body>

</html>
