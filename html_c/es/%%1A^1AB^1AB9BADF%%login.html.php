<?php /* Smarty version 2.6.20, created on 2017-04-10 10:14:13
         compiled from login.html */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <meta name="viewport" content="width=1024, user-scalable=no" />

    <title>BROADCASTERWEBSMS | </title>

    <!-- Bootstrap core CSS -->

    <link href="../html/es/css/bootstrap.min.css" rel="stylesheet">

    <link href="../html/es/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="../html/es/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="../html/es/css/custom.css" rel="stylesheet">
    <link href="../html/es/css/icheck/flat/green.css" rel="stylesheet">


    <script src="../html/es/js/jquery.min.js"></script>

    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


        <style type="text/css">
    select {
    text-indent: 38% !important;
}
</style>

</head>

<body style="background-image: url('../html/es/images/fondo_a.png'); background-size: 100%; background-repeat: no-repeat;">
    
    <div class="">
        <a class="hiddenanchor" id="toregister"></a>
        <a class="hiddenanchor" id="tologin"></a>

        <div id="wrapper">
            <div id="login" class="animate form">
                <section class="login_content">
                    <form role="form" action="login.php" method="POST">
                        <img src="../html/es/images/logo.png" width="350px">
                        <br>
                        <br>
                        <div>
                            <input type="text" class="form-control" placeholder="Usuario" required="" name="username"/>
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Contraseña" required="" name="password"/>
                        </div>
                        <div>
                            <!-- <a class="btn btn-default submit" href="javascript:$('form').submit();">Entrar</a> -->
                            <a class="reset_pass" href="restorep.php">¿Olvidaste tu contraseña?</a>
                            <button class="btn btn-default submit" type="submit">
                                Entrar
                            </button>
                        </div>
                        <div class="clearfix"></div>
                        <div class="separator">

                            <p class="change_link" style="font-weight: bold;"><a href="signup.php" class="to_register">¿Eres nuevo?
                                 Crear cuenta </a>
                            </p>

                            <br>
                           <br>
                           <br>
                           <br>
                           <br>
                            <div class="clearfix"></div>
                            <br />
                            <div>
                                <center><img src="../html/es/images/concepto.png" width="80" height="80"></center>

                                <p style="color: white; font-weight: 100;">©2017 Todos los derechos reservados</p>
                            </div>
                        </div>
                    </form>
                    <!-- form -->
                </section>
                <!-- content -->
            </div>
        </div>
    </div>

</body>

</html>