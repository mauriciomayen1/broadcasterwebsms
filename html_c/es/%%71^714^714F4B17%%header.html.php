<?php /* Smarty version 2.6.20, created on 2017-04-10 12:32:09
         compiled from header.html */ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <meta name="viewport" content="width=1024, user-scalable=no" />

    <title>BROADCASTERWEBSMS </title>

    <!-- Bootstrap core CSS -->

    <link href="../html/es/css/bootstrap.min.css" rel="stylesheet">

    <link href="../html/es/fonts/css/font-awesome.min.css" rel="stylesheet">
    <link href="../html/es/css/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="../html/es/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../html/es/css/maps/jquery-jvectormap-2.0.1.css" />
    <link href="../html/es/css/icheck/flat/green.css" rel="stylesheet" />
    <link href="../html/es/css/floatexamples.css" rel="stylesheet" type="text/css" />
    <link href="../html/es/css/dataTable.css" rel="stylesheet" type="text/css" />

    <script src="../html/es/js/jquery.min.js"></script>
    <script src="../html/es/js/nprogress.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>    
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>

    
    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

    <div class="container body">


        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="mt.php" class="site_title"><img src="../html/es/images/cm.png" width="190" height="40"></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <!-- <div class="profile">
                        <div class="profile_pic">
                            <img src="../html/es/images/img.jpg" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bienvenido</span>
                            <h2>Anthony Fernando</h2>
                        </div>
                    </div> -->
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li><a href="home.php"><i class="fa fa-home"></i> Home</a>
                                </li>
                                <!-- <li><a href="mt.php"><i class="fa fa-bar-chart" aria-hidden="true"></i>Dashboard</a> -->

                                <li>
                                    <a href="javascript:;" data-toggle="collapse" data-target="#demo11"><i class="fa fa-bar-chart" aria-hidden="true"></i>Dashboard<i class="fa fa-fw fa-caret-down glyphicon-chevron-right glyphicon-chevron-down"></i></a>
                                    <ul id="demo11" class="collapse in">

                                        <?php if ($this->_tpl_vars['activo'] == 'Administrador'): ?>
                                           <li><a href="mtgeneral.php"><i class="fa fa-pie-chart" aria-hidden="true"></i>Reporte gráfico</a>
                                           </li>
                                           <li><a href="detailgeneral.php"><i class="fa fa-area-chart" aria-hidden="true"></i>Reporte Detallado</a>
                                        </li>
                                        <?php else: ?>
                                            <li><a href="mt.php"><i class="fa fa-pie-chart" aria-hidden="true"></i>Reporte gráfico</a>
                                            </li>
                                            <li><a href="detail.php"><i class="fa fa-area-chart" aria-hidden="true"></i>Reporte Detallado</a>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>


                                </li>
                                <li><a href="payment.php"><i class="fa fa-credit-card"></i>Pago</a>
                                </li>

                                <li><a href="load.php"><i class="fa fa-upload"></i> Administrar Campañas</a>
                                </li>

                                <?php if ($this->_tpl_vars['activo'] == 'Administrador'): ?>
                                   <li><a href="approve.php"><i class="fa fa-check"></i> Costos</a>
                                </li>
                                <?php endif; ?>  


                                <li>
                                    <a href="javascript:;" data-toggle="collapse" data-target="#demo12"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Envíos<i class="fa fa-fw fa-caret-down glyphicon-chevron-right glyphicon-chevron-down"></i></a>
                                    <ul id="demo12" class="collapse in">
                                        <li><a href="unique.php"><i class="fa fa-envelope"></i> Único</a>
                                        </li>
                                        <li><a href="masivesend.php"><i class="fa fa-files-o" aria-hidden="true"></i> Masivo</a>
                                        </li>
                                        <li><a href="programmed.php"><i class="fa fa-clock-o" aria-hidden="true"></i> Programado</a>
                                        </li>
                                        <li><a href="email.php"><i class="fa fa-at" aria-hidden="true"></i> Email</a>
                                        </li>
                                        <li><a href="webservice.php"><i class="fa fa-link" aria-hidden="true"></i> API</a>
                                        </li>
                                    </ul>
                                </li>

                                <li><a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> Mi cuenta</a>
                                </li>
                                <!-- <li><a href="tutorial.php"><i class="fa fa-info" aria-hidden="true"></i> Ayuda</a>
                                </li> -->
                                <li><a href="contact.php"><i class="fa fa-envelope" aria-hidden="true"></i> Contáctanos</a>
                                </li>
                            </ul>
                        </div>
                        <!-- <div class="menu_section">
                            <h3>Live On</h3>
                            <ul class="nav side-menu">
                                <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="e_commerce.html">E-commerce</a>
                                        </li>
                                        <li><a href="projects.html">Projects</a>
                                        </li>
                                        <li><a href="project_detail.html">Project Detail</a>
                                        </li>
                                        <li><a href="contacts.html">Contacts</a>
                                        </li>
                                        <li><a href="profile.html">Profile</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li><a href="page_404.html">404 Error</a>
                                        </li>
                                        <li><a href="page_500.html">500 Error</a>
                                        </li>
                                        <li><a href="plain_page.html">Plain Page</a>
                                        </li>
                                        <li><a href="login.html">Login Page</a>
                                        </li>
                                        <li><a href="pricing_tables.html">Pricing Tables</a>
                                        </li>

                                    </ul>
                                </li>
                                <li><a><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a>
                                </li>
                            </ul>
                        </div> -->

                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <!-- <div class="sidebar-footer hidden-small col-md-12">
                        <a href="configuration.php" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="modal" data-target="#myModal" title="Remove">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="logout.php">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div> -->
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <!-- <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div> -->


                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="<?php echo $this->_tpl_vars['help']; ?>
" target="_blank">
                                   <i class="fa fa-question-circle fa-2x" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>  <?php echo $this->_tpl_vars['activo']; ?>

                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li><a href="profile.php">  Perfil</a>
                                    </li>
                                    <li><a href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>

                            </li>
                        </ul>
                    </nav>

                    <a href="payment.php" id="mau1"><h5>SALDO: $<?php echo $this->_tpl_vars['credito']; ?>
 <strong>MXN</strong></h5></a>
                </div>

            </div>
            <!-- /top navigation -->


            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <!-- <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">¿Desea eliminar su base de datos?</h4>
                  </div> -->
                  <div class="modal-body">
                    <h4 class="modal-title" id="myModalLabel">¿Desea eliminar su base de datos?</h4>
                    <form role="form" action="delete.php" method="POST">
                  </div>
                  <div class="modal-footer">
                    <input type="hidden" name="accion" value="eliminar">
                    <select name="campanas" id="campanas" class="form-control">
                        <option value="Todos">Todos</option>
                        <?php $_from = $this->_tpl_vars['campanas']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['campana']):
?>            
                          <option value="<?php echo $this->_tpl_vars['campana']['usuario_categoria']; ?>
"><?php echo $this->_tpl_vars['campana']['usuario_categoria']; ?>
</option>
                        <?php endforeach; endif; unset($_from); ?> 
                    </select>
                    <br>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>