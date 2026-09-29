 <!-- ========== Left Sidebar Start ========== -->
 <div class="left side-menu">
     <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
         <i class="ion-close"></i>
     </button>
     <?php $session = session() ?>
     <!-- LOGO -->
     <div class="topbar-left">
         <div class="text-center">
             <!--<a href="index.html" class="logo"><i class="mdi mdi-assistant"></i>Zoter</a>-->
             <a href="/" class="logo">
                 <!-- <img src="<?= base_url() ?>assets/images/logo-lg.png" alt="" class="logo-large"> -->
                 <img src="<?= base_url() ?>assets/images/logo-b7.png" alt="logo-light" height="60">
             </a>
         </div>
     </div>

     <div class="sidebar-inner niceScrollleft">

         <div id="sidebar-menu">
             <ul>
                 <li class="menu-title">Main</li>

                 <li>
                     <a href="<?= base_url() ?>" class="waves-effect">
                         <i class="mdi mdi-airplay"></i>
                         <span> Dashboard Ruangan <span class="badge badge-pill badge-primary float-right"></span></span>
                     </a>
                     <a href="<?= base_url('SwabController/dashboard') ?>" class="waves-effect">
                         <i class="mdi mdi-airplay"></i>
                         <span> Dashboard Swab <span class="badge badge-pill badge-primary float-right"></span></span>
                     </a>
                 </li>
                    <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                     <li class="has_sub">
                         <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-monitor-multiple"></i>
                             <span>Monitoring Ruang</span>
                             <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                         <ul class="list-unstyled">
                             <li><a href="<?= base_url() ?>DataPpoj">Data Kualifikasi & EHM</a></li>
                             <li><a href="<?= base_url() ?>Suhu">Suhu</a></li>
                             <li><a href='<?= base_url() ?>Rh'>RH</a></li>
                             <li><a href='<?= base_url() ?>Dp'>Differential Preassure</a></li>
                             <li><a href='<?= base_url() ?>Flow'>Flow</a></li>
                             <li><a href='<?= base_url() ?>Partikel'>Partikel</a></li>
                             <li><a href='<?= base_url() ?>Lux'>Lux</a></li>
                             <li><a href='<?= base_url() ?>Patogen'>Patogen</a></li>
                              <li><a href='<?= base_url() ?>MasterDataRuangan'>Master Data Ruangan</a></li>
                             <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                 <li><a href='<?= base_url() ?>Approval'>Approval For Edit</a></li>
                             <?php } ?>
                         </ul>
                     <?php } ?>

                     <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                     <li class="has_sub">
                         <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-monitor-multiple"></i>
                             <span>Monitoring Swab</span>
                             <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                         <ul class="list-unstyled">
                             <li><a href="<?= base_url() ?>MasterDataSwab">Master Data Swab</a></li>
                             <li><a href="<?= base_url() ?>DataPpojSwab">Data Swab</a></li>
                             <li><a href="<?= base_url() ?>AuditTrailSwab">Audit Trail</a></li>
                             <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                 <li><a href='<?= base_url() ?>Approval'>Approval For Edit</a></li>
                             <?php } ?>
                             <li><a href="<?= base_url() ?>OosPenyimpangan/TampilOOS">OOS/OOT Monitoring</a></li>
                              <li><a href="<?= base_url() ?>OosPenyimpangan/TampilPenyimpangan">Penyimpangan</a></li>
                         </ul>
                     <?php } ?>


                     <?php if ($session->get('jabatan') == 'QC Analis' or $session->get('jabatan') == 'Manager QC' or $session->get('jabatan') == 'Spv QC' or $session->get('jabatan') == 'Spv QA' or $session->get('jabatan') == 'Manager QC') { ?>
                     <li class="has_sub">
                         <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-arrange-send-backward"></i>
                             <span>Mikro Ruangan</span>
                             <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                         <ul class="list-unstyled">

                             <li><a href="<?= base_url() ?>DataPpoj">Data Kualifikasi & EHM</a></li>
                             <li><a href='<?= base_url() ?>Mas'>Volumetrik</a></li>
                             <li><a href='<?= base_url() ?>Capar'>Cawan Papar</a></li>
                             <li><a href='<?= base_url() ?>Patogen'>Patogen</a></li>
                             <!--<php if($session->get('jabatan') == 'Manager QA' OR $session->get('jabatan') == 'Spv QA' OR 1==1){ ?>-->
                             <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA' or $session->get('jabatan') == 'Manager QC' or $session->get('jabatan') == 'Spv QC') { ?>
                                 <li><a href='<?= base_url() ?>ApprovalMikro'>Approval For Edit</a></li>
                                 
                             <?php } ?>
                         </ul>

                     </li>
                 <?php } ?>

                 <?php if ($session->get('jabatan') == 'QC Analis' or $session->get('jabatan') == 'Manager QC' or $session->get('jabatan') == 'Spv QC' or $session->get('jabatan') == 'Spv QA' or $session->get('jabatan') == 'Manager QC') { ?>
                     <li class="has_sub">
                         <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-arrange-send-backward"></i>
                             <span>Mikro Swab</span>
                             <span class="float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                         <ul class="list-unstyled">

                             <li><a href="<?= base_url() ?>DataPpojSwab">Data Swab</a></li>

                             <li><a href='<?= base_url() ?>PatogenSwab'>Input Data Swab</a></li>
                             <li><a href="<?= base_url() ?>OosPenyimpangan/TampilOOS">OOS/OOT Monitoring</a></li>
                          
                             <!--<php if($session->get('jabatan') == 'Manager QA' OR $session->get('jabatan') == 'Spv QA' OR 1==1){ ?>-->
                             <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA' or $session->get('jabatan') == 'Manager QC' or $session->get('jabatan') == 'Spv QC') { ?>
                                 <li><a href='<?= base_url() ?>ApprovalMikro'>Approval For Edit</a></li>
                                 <li><a href="<?= base_url() ?>OosPenyimpangan/TampilOOS">OOS/OOT Monitoring</a></li>
                                 <li><a href="<?= base_url() ?>OosPenyimpangan/TampilPenyimpangan">Penyimpangan</a></li>
                             <?php } ?>
                         </ul>

                     </li>
                 <?php } ?>
                 <?php if ($session->get('jabatan') == 'administrator' ) { ?>
                    <li>
                        <a href="<?= base_url('UserManagement') ?>" class="waves-effect">
                            <i class="mdi mdi-account-cog me-1"></i> User Management
                        </a>
                    </li>
                <?php } ?>

                 <!-- end li -->

         </div>
         <div class="clearfix"></div>
     </div> <!-- end sidebarinner -->
 </div>
 <!-- Left Sidebar End -->
 <!-- Start right Content here -->

 <div class="content-page">
     <!-- Start content -->
     <div class="content">

         <!-- Top Bar Start -->
         <div class="topbar">

             <nav class="navbar-custom">

                 <ul class="list-inline float-right mb-0">
                     <!-- language-->


                     <!-- <li class="list-inline-item dropdown notification-list">
                         <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                             <i class="ti-bell noti-icon"></i>
                             <span class="badge badge-success noti-icon-badge">23</span>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                          
                             <div class="dropdown-item noti-title">
                                 <h5><span class="badge badge-danger float-right">87</span>Notification</h5>
                             </div>

                             
                             <a href="javascript:void(0);" class="dropdown-item notify-item">
                                 <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                                 <p class="notify-details"><b>Your order is placed</b><small class="text-muted">Dummy text of the printing and typesetting industry.</small></p>
                             </a>

                              item-
                             <a href="javascript:void(0);" class="dropdown-item notify-item">
                                 <div class="notify-icon bg-success"><i class="mdi mdi-message"></i></div>
                                 <p class="notify-details"><b>New Message received</b><small class="text-muted">You have 87 unread messages</small></p>
                             </a>

                             <-- item--
                             <a href="javascript:void(0);" class="dropdown-item notify-item">
                                 <div class="notify-icon bg-warning"><i class="mdi mdi-martini"></i></div>
                                 <p class="notify-details"><b>Your item is shipped</b><small class="text-muted">It is a long established fact that a reader will</small></p>
                             </a>

                             <- All--
                             <a href="javascript:void(0);" class="dropdown-item notify-item">
                                 View All
                             </a>

                         </div>
                     </li> -->

                     <li class="list-inline-item dropdown notification-list">
                         <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                             <span style="color: white;"><?= $session->get('username') ?></span>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                             <!-- item-->
                             <!-- <div class="dropdown-item noti-title">
                                 <h5><?= $session->get('username') ?></h5>
                             </div> -->
                             <a class="dropdown-item" href="<?= base_url() ?>Home/Setting"><i class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                             <!--<a class="dropdown-item" href="#"><i class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Lock screen</a>-->
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="<?= base_url() ?>Logout"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                         </div>
                     </li>

                 </ul>

                 <ul class="list-inline menu-left mb-0">
                     <li class="float-left">
                         <button class="button-menu-mobile open-left waves-light waves-effect">
                             <i class="mdi mdi-menu"></i>
                         </button>
                     </li>
                 </ul>

                 <div class="clearfix"></div>

             </nav>

         </div>
         <!-- Top Bar End -->