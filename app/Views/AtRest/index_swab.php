<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>

<div class="page-content-wrapper ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item active">Dashboard Swab</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Dashboard Swab</h4>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title mt-0 mb-3">Filter Dashboard Swab</h5>
                        <form id="filterForm" method="get" action="<?= current_url() ?>" class="form-inline">
                            <div class="form-group mr-3">
                                <label for="periode">Periode: </label>
                                <select name="periode" id="periode" class="form-control ml-2">
                                    <option <?= $periode == 'Caturwulan 1' ? 'selected' : '' ?>>Caturwulan 1</option>
                                    <option <?= $periode == 'Caturwulan 2' ? 'selected' : '' ?>>Caturwulan 2</option>
                                    <option <?= $periode == 'Caturwulan 3' ? 'selected' : '' ?>>Caturwulan 3</option>
                                 
                                    <option <?= $periode == 'Semester 1' ? 'selected' : '' ?>>Semester 1</option>
                                    <option <?= $periode == 'Semester 2' ? 'selected' : '' ?>>Semester 2</option>
                                </select>
                            </div>
                            <div class="form-group mr-3">
                                <label for="tahun">Tahun: </label>
                                <input type="number" name="tahun" id="tahun" class="form-control ml-2" value="<?= $tahun ?>">
                            </div>
                            <div class="form-group mr-3">
                                <label for="kategori">Kategori: </label>
                                <select name="kategori" id="kategori" class="form-control ml-2">
                                    <option <?= $kategori == 'Mesin (Bagian Dalam)' ? 'selected' : '' ?>>Mesin (Bagian Dalam)</option>
                                    <option <?= $kategori == 'Mesin (Bagian Luar)' ? 'selected' : '' ?>>Mesin (Bagian Luar)</option>
                                    <option <?= $kategori == 'Alat Bagian Dalam' ? 'selected' : '' ?>>Alat Bagian Dalam</option>
                                    <option <?= $kategori == 'Alat Bagian Luar' ? 'selected' : '' ?>>Alat Bagian Luar</option>
                                    <option <?= $kategori == 'Personil' ? 'selected' : '' ?>>Personil</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Filter</button>
                           <button type="button" id="exportBtn" class="btn btn-success ml-2">Export CSV</button>
                            
                        </form>
                        
                    </div>
                </div>
            </div>
           
            <div class="col-xl-12">
                <div class="card shadow-lg border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="header-title mb-4">Persentase Capaian Swab</h5>
                            
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="text-center">
                                <h6 class="text-muted">Total Target</h6>
                                <p class="fs-1 mb-0" style="font-size: 2rem; font-weight: bold;"><?= number_format($total_target) ?></p>
                            </div>
                            <div class="text-center">
                                <h6 class="text-muted">Total Aktual</h6>
                                <p class="fs-1 mb-0" style="font-size: 2rem; font-weight: bold;"><?= number_format($total_aktual) ?></p>
                            </div>
                            <div class="text-center">
                                <h6 class="text-muted">Persentase Capaian</h6>
                                <p class="fs-1 mb-0" style="font-size: 2rem; font-weight: bold;"><?= $persentase ?>%</p>
                            </div>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" style="width: <?= $persentase ?>%;" aria-valuenow="<?= $persentase ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
            <div class="row">
                <div class="col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="header-title">Trend TMS Mesin (Bagian Dalam) Hygiene</h5>
                            <canvas id="chartMesinDalam" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="header-title">Trend TMS Mesin (Bagian Luar) Hygiene</h5>
                            <canvas id="chartMesinLuar" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="header-title">Trend TMS Alat (Bagian Dalam) Hygiene</h5>
                            <canvas id="chartAlatDalam" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="header-title">Trend Alat (Bagian Luar) Hygiene</h5>
                            <canvas id="chartAlatLuar" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="header-title">Trend Personil Hygiene</h5>
                            <canvas id="chartPersonil" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            </div>
           

        </div>
    </div>
</div>
<script>
    document.getElementById('exportBtn').addEventListener('click', function () {
        const periode = document.getElementById('periode').value;
        const tahun = document.getElementById('tahun').value;
        const kategori = document.getElementById('kategori').value;

        const exportUrl = `<?= base_url('export_swab/excel') ?>?periode=${encodeURIComponent(periode)}&tahun=${encodeURIComponent(tahun)}&kategori=${encodeURIComponent(kategori)}`;

        window.location.href = exportUrl;
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const defaultLabels = ['Caturwulan 1', 'Caturwulan 2', 'Caturwulan 3'];

    function renderChart(ctxId, label, data) {
        // Buat dictionary untuk akses cepat
        const dataMap = {};
        data.forEach(d => {
            dataMap[d.periode] = d.jumlah;
        });

        // Susun data sesuai urutan label tetap
        const chartData = defaultLabels.map(label => dataMap[label] || 0);

        const ctx = document.getElementById(ctxId).getContext('2d');

        // Buat gradient untuk area fill
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(209, 83, 66, 0.4)');
        gradient.addColorStop(1, 'rgba(209, 83, 66, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: defaultLabels,
                datasets: [{
                    label: label,
                    data: chartData,
                    borderColor: 'rgba(209, 83, 66, 0.9)',
                    backgroundColor: gradient,
                    tension: 0.4, // smooth curves
                    fill: true,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: 'rgba(209, 83, 66, 1)',
                    pointHoverBackgroundColor: 'rgba(209, 83, 66, 0.9)',
                    borderWidth: 3,
                    // Glow shadow effect for points
                    segment: {
                        borderColor: 'rgba(209, 83, 66, 0.9)',
                        borderWidth: 3
                    }
                }]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'nearest',
                    intersect: false
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#555',
                            font: {
                                weight: 'bold',
                                size: 14
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(209, 83, 66, 0.8)',
                        titleFont: { weight: 'bold', size: 14 },
                        bodyFont: { size: 13 }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(200,200,200,0.2)',
                            borderColor: 'rgba(200,200,200,0.4)',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#666',
                            font: { size: 13, weight: 'bold' }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(200,200,200,0.1)',
                            borderColor: 'rgba(200,200,200,0.3)',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#666',
                            font: { size: 13 }
                        },
                        beginAtZero: true
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    renderChart('chartMesinDalam', 'Trend Mesin (Bagian Dalam)', <?= json_encode($trendMesinDalam) ?>);
    renderChart('chartMesinLuar', 'Trend Mesin (Bagian Luar)', <?= json_encode($trendMesinLuar) ?>);
    renderChart('chartAlatDalam', 'Trend Alat Bagian Dalam', <?= json_encode($trendAlatDalam) ?>);
    renderChart('chartAlatLuar', 'Trend Alat Bagian Luar', <?= json_encode($trendAlatLuar) ?>);
    renderChart('chartPersonil', 'Trend Personil', <?= json_encode($trendPersonil) ?>);
</script>



<?php echo view('parsial/footer'); ?>
