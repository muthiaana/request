<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="<?= base_url('assets/img/des.jpg'); ?>">

    <title><?= $title; ?></title>
    <!-- FONT  -->
        <link href=" <?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- BOOTSTRAP AND TEMPLATE -->
        <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DATATABLES -->
        <link href="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.css" rel="stylesheet">

        <link href="<?= base_url('assets/'); ?>vendor/datatables/responsive.dataTables.min.css" rel="stylesheet">
        <link href="<?= base_url('assets/'); ?>vendor/datatables/scroller.dataTables.min.css" rel="stylesheet">
        <link href="<?= base_url('assets/'); ?>vendor/datatables/select.dataTables.min.css" rel="stylesheet">
    <!-- BUTTONS -->
        <link href="<?= base_url('assets/'); ?>vendor/buttons/buttons.dataTables.min.css" rel="stylesheet">
</head>
<!-- Script JS -->
    <!-- jquery -->
        <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
    
    <!-- bootstrap and template -->
        <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- QRcode -->
        <script src="<?= base_url('assets/'); ?>js/qrcode.min.js"></script>
        <script src="<?= base_url('assets/'); ?>js/instascan.min.js"></script>

    <!-- DATA TABLES -->
        <script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>

        <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.responsive.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.scroller.min.js"></script>
        <script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.select.min.js"></script>


    <!-- BUTTONS -->
        <script src="<?= base_url('assets/'); ?>vendor/buttons/dataTables.buttons.min.js"></script>
    <!-- CHART -->
        <script src="<?= base_url('assets/'); ?>vendor/chart/Chart.bundle.min.js"></script>
    <!-- JSZip -->
        <script src="<?= base_url('assets/'); ?>vendor/JSZip/jszip.min.js"></script>
    <!-- PDFMAKE -->
        <script src="<?= base_url('assets/'); ?>vendor/pdfmake/pdfmake.min.js"></script>

<!-- script -->
    
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
            <ul class="navbar-nav bg-gray-900 sidebar sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url() ?>">
                    <div class="sidebar-brand-icon">
                        <!-- <i class="fas fa-code"></i> -->
                        <img src="<?= base_url('assets/img/des.jpg')?>" width="50vw" height="50vh">
                    </div>
                    <div class="sidebar-brand-text mx-3">IT Support</div>
                </a>
                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- query menu -->
                <?php 
                    $id_role = $this->session->userdata('id_role');
                    $querymenu = "SELECT 
                              `ecrm_menu`.`id_menu`,
                              `menu`, `icon`
                              FROM `ecrm_menu`
                              JOIN `ecrm_menu_access`
                              ON `ecrm_menu`.`id_menu` = `ecrm_menu_access`.`id_menu`
                              WHERE `ecrm_menu_access`.`id_role` = $id_role
                              AND `status` = 1
                              ORDER BY `ecrm_menu_access`.`id_menu` ASC ";

                    $menu = $this->db->query($querymenu)->result_array();
                ?>

                <?php foreach ($menu as $m) : ?>
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu<?= $m['id_menu']; ?>" aria-expanded="true" aria-controls="menu<?= $m['id_menu']; ?>">
                            <i class="<?= $m['icon']; ?>"></i>
                            <span><?= $m['menu']; ?></span>
                        </a>
                        <div id="menu<?= $m['id_menu']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                            <div class="bg-white py-2 collapse-inner rounded">
                                <?php 
                                    $id_menu = $m['id_menu'];
                                    $querysubmenu = "SELECT * 
                                        FROM `ecrm_menu_sub`
                                        JOIN `ecrm_menu`
                                        ON `ecrm_menu_sub`.`id_menu` = `ecrm_menu`.`id_menu`
                                        WHERE `ecrm_menu_sub`.`id_menu` = $id_menu
                                        AND `ecrm_menu_sub`.`status` = 1 ";

                                    $submenu = $this->db->query($querysubmenu)->result_array();
                                ?>

                                <?php foreach ($submenu as $sm) :?>
                                    <a class="collapse-item" href="<?= base_url($sm['url']) ?>">
                                        <span><?= $sm['title'] ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <!-- End of Sidebar -->
    
        <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">
                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <h3><?= $title; ?></h3>
                        </div>
                        
                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img class="img-profile rounded-circle border" src="<?= base_url('assets/img/profile/') . $user['image'];  ?>">
                                    <span>&nbsp;&nbsp;&nbsp;</span>
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['name']; ?></span>
                                </a>
                                <!-- Dropdown - User Information -->
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <a class="dropdown-item" href="<?= base_url('User/Edit'); ?>">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Edit Profiles
                                    </a>
                                    <a class="dropdown-item" href="<?= base_url('User/Change_pass'); ?>">
                                        <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Change password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="<?= base_url('Auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
        <!-- End of Topbar -->

        <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure want to logout ?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Click logout to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="<?= base_url('Auth/logout') ?>">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        <!-- end modal logout -->


        <!-- UNIVERSAL MODAL -->
            <div class="modal fade text-left" id="universalModal" tabindex="-1" role="dialog" aria-labelledby="modaltitle" aria-hidden="true">
                <div class="modal-dialog" role="document" id="modaldialog">
                    <div class="modal-content">
                        <div class="modal-header" id="modalheader">
                            <h4 class="modal-title" id="modaltitle">Modal</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modalbody">                                          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-danger" id="modalSave">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        <!-- END UNIVERSAL MODAL -->
