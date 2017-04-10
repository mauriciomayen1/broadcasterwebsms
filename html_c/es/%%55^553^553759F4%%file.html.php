<?php /* Smarty version 2.6.13, created on 2015-12-30 09:39:49
         compiled from file.html */ ?>
<body>


        <div id="wrapper">

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                File
                            </h1>
                        </div>
                    </div>

                    <form id="fileForm" class="form-horizontal" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-xs-3 control-label">Avatar</label>
                            <div class="col-xs-6">
                                <input type="file" class="form-control" name="avatar" id="file" />
                            </div>
                        </div>
                        <input type="submit" name="subir" id="subir" value="Subir" />
                    </form>
                    <!-- /.row -->

                    <!-- Page Heading -->
            
                <!-- /.container-fluid -->

                </div>
            <!-- /#page-wrapper -->

            </div>
        <!-- /#wrapper -->
        </div>


    <!-- jQuery -->
    <script src="../html/es/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../html/es/js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
   <!--  <script src="../html/es/js/plugins/morris/raphael.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris.min.js"></script>
    <script src="../html/es/js/plugins/morris/morris-data.js"></script> -->
    <script src="../html/es/js/bootstrapValidator.js"></script>

    <script>

   
        $(document).ready(function() {
            $('#fileForm').bootstrapValidator({
                framework: 'bootstrap',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    avatar: {
                        validators: {
                            file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 422940,   // 2048 * 1024
                                //minSize: 1024 * 1024,
                                message: 'El peso de la imagen no es correcto, favor de validar.'
                            }/*,file: {
                                extension: 'jpeg,jpg,png',
                                type: 'image/jpeg,image/png',
                                maxSize: 422940,   // 2048 * 1024
                                //minSize: 1024 * 1024,
                                message: 'El peso de la imagen no es correcto, favor de validar.'
                            }*/
                        }
                    }
                }
            })/*.on('success.form.bv', function(e) {
                        var _URL = window.URL || window.webkitURL;
                        
                        var image, file;

                        var f = $(this);
                        console.log($(this)[0].file);

                        //return false;
                        //alert($(this));

                        if ((file = $(this)[0].file)) {
                           
                                image = new Image();
                                
                                image.onload = function() {
                                    
                                    alert("The image width is " +this.width + " and image height is " + this.height);
                                };

                                image.src = _URL.createObjectURL(file);
                        }         
                    
                });*/
        });


    var _URL = window.URL || window.webkitURL;

/*$("#file").change(function(e) {
    
    var image, file;

    if ((file = this.files[0])) {
       
        image = new Image();
        
        image.onload = function() {
            
            alert("The image width is " +this.width + " and image height is " + this.height);
        };
    
        image.src = _URL.createObjectURL(file);


    }

});*/
    </script>

</body>

</html>