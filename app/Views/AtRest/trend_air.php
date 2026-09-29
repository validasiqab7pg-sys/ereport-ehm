<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">
    <?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="header-body">

                <!-- Breadcrumb -->
                <div class="row align-items-center py-2">
                    <div class="col-lg-12">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>"><i class="fa fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight:bold; color:black;">Trend Data Air</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <!-- Card Filter -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title mb-3">Trend Hasil Pemeriksaan Air</h4>

                                <div class="row g-2 align-items-end">
                                    <div class="col-md-2">
                                        <label class="form-label">Site</label>
                                        <select id="filterSite" class="form-control">
                                            <option value="">-- Pilih Site --</option>
                                            <?php foreach ($siteList as $site): ?>
                                                <option value="<?= esc($site) ?>"><?= esc($site) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Jenis Sampling / Kategori</label>
                                        <select id="filterKategori" class="form-control" disabled>
                                            <option value="">-- Pilih Site dulu --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Tanggal Mulai</label>
                                        <input type="date" id="filterTanggalMulai" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Tanggal Akhir</label>
                                        <input type="date" id="filterTanggalAkhir" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="btnTampilkan" class="btn btn-primary w-100">
                                            <span class="ti-bar-chart"></span> Tampilkan
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="btnExportExcel" class="btn btn-success w-100">
                                            <span class="ti-download"></span> Export Excel
                                        </button>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Kosongkan tanggal untuk menampilkan seluruh riwayat yang ada.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info / status -->
                <div id="infoStatus" class="alert alert-info" style="display:none;"></div>

                <!-- Grid grafik, diisi via JS -->
                <div id="gridTrend" class="row"></div>

            </div>
        </div>
    </div>
</div>

<?php echo view('parsial/footer'); ?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
<script>
// Data kategori per site, dikirim dari controller (dipakai untuk isi dropdown Kategori
// secara dependen begitu Site dipilih)
var KATEGORI_PER_SITE = <?= json_encode($kategoriPerSite) ?>;

// Palet warna garis, diputar ulang kalau titik sampling lebih banyak dari jumlah warna
var PALET_WARNA = [
    '#5664d2', '#28a745', '#fd7e14', '#dc3545', '#17a2b8',
    '#6f42c1', '#20c997', '#e83e8c', '#ffc107', '#6610f2'
];

var chartInstances = [];

document.addEventListener('DOMContentLoaded', function () {
    var selSite      = document.getElementById('filterSite');
    var selKategori   = document.getElementById('filterKategori');
    var btnTampilkan  = document.getElementById('btnTampilkan');

    // Isi dropdown Kategori begitu Site dipilih
    selSite.addEventListener('change', function () {
        var site = selSite.value;
        selKategori.innerHTML = '';

        if (!site || !KATEGORI_PER_SITE[site]) {
            selKategori.disabled = true;
            selKategori.innerHTML = '<option value="">-- Pilih Site dulu --</option>';
            return;
        }

        selKategori.disabled = false;
        selKategori.innerHTML = '<option value="">-- Pilih Kategori --</option>';
        KATEGORI_PER_SITE[site].forEach(function (item) {
            var opt = document.createElement('option');
            opt.value = item.kategori;
            opt.textContent = item.kode + '. ' + item.kategori;
            selKategori.appendChild(opt);
        });
    });

    btnTampilkan.addEventListener('click', muatTrend);

    document.getElementById('btnExportExcel').addEventListener('click', function () {
        var site          = document.getElementById('filterSite').value;
        var kategori       = document.getElementById('filterKategori').value;
        var tanggalMulai   = document.getElementById('filterTanggalMulai').value;
        var tanggalAkhir   = document.getElementById('filterTanggalAkhir').value;

        if (!site || !kategori) {
            tampilkanInfo('Pilih Site dan Kategori terlebih dahulu sebelum export.', 'warning');
            return;
        }

        var params = new URLSearchParams({
            site: site,
            kategori: kategori,
            tanggal_mulai: tanggalMulai,
            tanggal_akhir: tanggalAkhir
        });

        // Navigasi langsung (bukan fetch) supaya browser memicu download file
        window.location.href = "<?= base_url('TrendAir/exportExcel') ?>?" + params.toString();
    });
});

function tampilkanInfo(pesan, jenis) {
    var el = document.getElementById('infoStatus');
    el.style.display = 'block';
    el.className = 'alert alert-' + (jenis || 'info');
    el.textContent = pesan;
}

function sembunyikanInfo() {
    document.getElementById('infoStatus').style.display = 'none';
}

function muatTrend() {
    var site          = document.getElementById('filterSite').value;
    var kategori       = document.getElementById('filterKategori').value;
    var tanggalMulai   = document.getElementById('filterTanggalMulai').value;
    var tanggalAkhir   = document.getElementById('filterTanggalAkhir').value;

    if (!site || !kategori) {
        tampilkanInfo('Pilih Site dan Kategori terlebih dahulu.', 'warning');
        return;
    }
    sembunyikanInfo();

    var grid = document.getElementById('gridTrend');
    grid.innerHTML = '<div class="col-12 text-center py-5"><span class="spinner-border"></span> Memuat data...</div>';

    // Bersihkan instance Chart.js lama supaya tidak bocor memori
    chartInstances.forEach(function (c) { c.destroy(); });
    chartInstances = [];

    var params = new URLSearchParams({
        site: site,
        kategori: kategori,
        tanggal_mulai: tanggalMulai,
        tanggal_akhir: tanggalAkhir
    });

    fetch("<?= base_url('TrendAir/data') ?>?" + params.toString())
        .then(function (res) { return res.json(); })
        .then(function (res) {
            if (res.status !== 'success') {
                grid.innerHTML = '';
                tampilkanInfo(res.message || 'Gagal memuat data.', 'danger');
                return;
            }
            if (!res.charts || res.charts.length === 0) {
                grid.innerHTML = '';
                tampilkanInfo(res.message || 'Belum ada data untuk filter ini.', 'warning');
                return;
            }
            renderGrid(res.charts);
        })
        .catch(function () {
            grid.innerHTML = '';
            tampilkanInfo('Terjadi kesalahan saat mengambil data.', 'danger');
        });
}

function renderGrid(charts) {
    var grid = document.getElementById('gridTrend');
    grid.innerHTML = '';

    charts.forEach(function (chart, idx) {
        var canvasId = 'chart_' + chart.key;

        var col = document.createElement('div');
        col.className = 'col-lg-12 col-12 mb-3';

        var judul = chart.label + (chart.satuan ? ' (' + chart.satuan + ')' : '');
        col.innerHTML =
            '<div class="card h-100">' +
                '<div class="card-body">' +
                    '<h5 class="card-title mb-3">' + judul + '</h5>' +
                    '<canvas id="' + canvasId + '" height="90"></canvas>' +
                '</div>' +
            '</div>';

        grid.appendChild(col);

        var ctx = document.getElementById(canvasId).getContext('2d');
        var datasets = chart.datasets.map(function (ds, i) {
            var warna = PALET_WARNA[i % PALET_WARNA.length];
            return {
                label: ds.label,
                data: ds.data,
                borderColor: warna,
                backgroundColor: warna,
                tension: 0.25,
                spanGaps: false
            };
        });

        var instance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chart.labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } }
                },
                scales: {
                    y: {
                        beginAtZero: chart.tipe !== 'numerik',
                        ticks: chart.tipe !== 'numerik'
                            ? { stepSize: 1, callback: function (v) { return v === 0 ? 'Negatif/MS' : (v === 1 ? 'Positif/TMS' : ''); } }
                            : {}
                    }
                }
            }
        });

        chartInstances.push(instance);
    });
}
</script>