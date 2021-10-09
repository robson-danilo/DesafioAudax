<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="<?php echo base_url('imagens/favicon.ico') ?>" />


    <!-- Bootstrap -->
    <link href="/template/2.0/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/template/2.0/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">


    <!-- Custom Theme Style -->
    <link href="/template/2.0/build/css/custom.min.css" rel="stylesheet">



    <!--  jquery mask-->
    <script src="<?php echo base_url('js/jquery.mask.js') ?>"></script>
    <!-- Bootstrap -->
    <script src="/template/2.0/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="/template/2.0/vendors/jquery/dist/jquery.js"></script>

</head>



<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div  style="background-color: white;" class="col-md-3 left_col">
        <div  style="background-color: white;" class="left_col scroll-view">
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div  style="background-color: white;" class="menu_section">
                <ul class="nav side-menu">     
                <?php if ($this->session->userdata('tipo_usuario') == 1) { ?>                 
                    <li><a href="<?php echo site_url("welcome/ListarUsuario");?>"><div style="color: blue; "><img src="/images/usuarios_icone.svg" alt="some text" width=12 height=40> Usuários</div></a></li>  
                        <li><a href="<?php echo site_url("welcome/ListarMateriais");?>"><div style="color: blue;"><img src="/images/materiais_icone.svg" alt="some text" width=12 height=40> Materias</div></a> </li>  
                        <?php } ?>
                        <?php if ($this->session->userdata('tipo_usuario') != 1) { ?>  
                            <li><a href="<?php echo site_url("welcome/ListarSolicitacoes");?>"><div style="color: blue;"><img src="/images/solicitacoes_icone.svg" alt="some text" width=12 height=40> Solicitações</div></a>   </li>
                        <?php } ?>  
                                <li style="top: 500px;"><a href="<?php echo site_url("welcome/index");?>"><div style="color: blue;"><img src="/images/sair_icone.svg" alt="some text" width=12 height=40> Sair</div></a>  </li>  
                                </ul>
                            </div>

                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>

                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="">
                        <div class="clearfix"></div>
                        <div class="row">
                            <div id="divPrincipalCorpo" class="col-md-12 col-sm-12 col-xs-12">
                              <div class="x_panel">
                                <div class="x_content">
                                   <div  id = "contents" > <?php echo $contents ?> </div> 
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>




   <!-- jQuery -->
   <script src="/template/2.0/vendors/jquery/dist/jquery.js"></script>
   <!--  jquery mask-->
   <script src="<?php echo base_url('js/jquery.mask.js') ?>"></script>
   <!-- Bootstrap -->
   <script src="/template/2.0/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

   <!-- Custom Theme Scripts -->
   <script src="/template/2.0/build/js/custom.min.js"></script>
  

</body>
</html>