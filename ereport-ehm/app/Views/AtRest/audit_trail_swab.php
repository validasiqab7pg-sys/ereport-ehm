<?= view('parsial/navbar'); ?>
<?= view('parsial/sidebar'); ?>

<div class="page-content-wrapper ">
    
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-2">
                    <div class="col-lg-3 col-5">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home "></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Audit Trail </a></li>
                            </ol>
                        </nav>
                    </div>

                </div>
            <div>
            <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card">    
                            <div class="card-body table-responsive">
                                <h4 class="card-title mb-4">Audit Trail Swab Personnel/Machine Hygiene</h4>
                                <form method="get" class="d-flex justify-content-center mb-3">
                                    <div class="col-auto">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" value="<?= esc($_GET['start_date'] ?? '') ?>" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" value="<?= esc($_GET['end_date'] ?? '') ?>" class="form-control">
                                    </div>
                                    <div class="col-auto align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                             
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>Timestamp</th>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Table Name</th>
                                        <th>Record ID</th>
                                        <th>Old Value</th>
                                        <th>New Value</th>
                                        <th>IP Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($logs as $log): ?>
                                    <tr>
                                        <td><?= esc($log['timestamp']) ?></td>
                                        <td><?= esc($log['username']) ?></td>
                                        <td><?= esc($log['action']) ?></td>
                                        <td><?= esc($log['table_name']) ?></td>
                                        <td><?= esc($log['record_id']) ?></td>
                                        <td><?= esc($log['old_value']) ?></td>
                                        <td><?= esc($log['new_value']) ?></td>
                                        <td><?= esc($log['ip_address']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
             </div>  
</div>





<?= view('parsial/footer'); ?>
