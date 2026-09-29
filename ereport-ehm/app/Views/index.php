<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>

        <div class="page-content-wrapper ">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="btn-group float-right">
                                <ol class="breadcrumb hide-phone p-0 m-0">
                                    <!-- <li class="breadcrumb-item"><a href="#">Zoter</a></li> -->
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- end page title end breadcrumb -->
                <div class="row">
                    

               
                   


                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="header-title mt-0 mb-3">Calendar</h5>
                                <div id="v-cal">
                                    <div class="vcal-header">
                                        <button class="vcal-btn" data-calendar-toggle="previous">
                                            <svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M20,11V13H8L13.5,18.5L12.08,19.92L4.16,12L12.08,4.08L13.5,5.5L8,11H20Z"></path>
                                            </svg>
                                        </button>

                                        <div class="vcal-header__label" data-calendar-label="month">
                                            March 2017
                                        </div>


                                        <button class="vcal-btn" data-calendar-toggle="next">
                                            <svg height="24" version="1.1" viewbox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="vcal-week">
                                        <span>Mon</span>
                                        <span>Tue</span>
                                        <span>Wed</span>
                                        <span>Thu</span>
                                        <span>Fri</span>
                                        <span>Sat</span>
                                        <span>Sun</span>
                                    </div>
                                    <div class="vcal-body" data-calendar-area="month"></div>
                                </div>
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div> <!-- end row -->

                

            </div><!-- container -->

        </div> <!-- Page content Wrapper -->

    </div> <!-- content -->

    <!-- END layout-wrapper -->
    <?php echo view('parsial/footer'); ?>