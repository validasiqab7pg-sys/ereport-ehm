<?= view('parsial/navbar'); ?>
<?= view('parsial/sidebar'); ?>
<?php
function renderFieldSyarat(string $param, array $def, ?array $existing = null): string
{
    $label = $def['label'] ?? $param;
    $tipe  = $def['tipe'] ?? 'teks';

    if ($tipe === 'teks') {
        $opsi = \App\Libraries\ParameterAirDefinition::opsiTeksDefault($param);
        if (!in_array('N/A', $opsi, true)) {
            $opsi[] = 'N/A';
        }
        $selectedVal = (isset($existing['nilai_teks']) && $existing['nilai_teks'] !== null)
            ? $existing['nilai_teks']
            : ($opsi[0] ?? '');

        $html = '<div class="col-md-3"><div class="form-group">';
        $html .= "<label>{$label}</label>";
        $html .= "<select name=\"{$param}_nilai_teks\" class=\"form-control\" required>";
        foreach ($opsi as $opt) {
            $sel = ($selectedVal === $opt) ? 'selected' : '';
            $html .= "<option value=\"" . esc($opt) . "\" {$sel}>" . esc($opt) . "</option>";
        }
        $html .= '</select></div></div>';
        return $html;
    }

    $operator = $existing['operator']  ?? 'antara';
    $min      = $existing['nilai_min'] ?? '';
    $max      = $existing['nilai_max'] ?? '';
    $uid      = $param . '_' . uniqid();

    $html  = '<div class="col-md-4"><div class="form-group">';
    $html .= "<label>{$label}</label>";
    $html .= "<select name=\"{$param}_operator\" class=\"form-control mb-1 select-operator\" data-uid=\"{$uid}\" onchange=\"toggleOperatorNilai(this,'{$uid}')\">";
    foreach ([
        'antara' => 'Antara (rentang)',
        '<' => '< (kurang dari)',
        '<=' => '<= (kurang dari sama dengan)',
        '>' => '> (lebih dari)',
        '>=' => '>= (lebih dari sama dengan)',
        '=' => '= (sama dengan)',
        'N/A' => 'N/A (tidak diperiksa)',
        'Pendataan' => 'Pendataan (dicatat, tanpa syarat MS/TMS)',
    ] as $op => $opLabel) {
        $sel = ($operator === $op) ? 'selected' : '';
        $html .= "<option value=\"{$op}\" {$sel}>{$opLabel}</option>";
    }
    $html .= '</select>';
    $html .= "<div class=\"row\" id=\"{$uid}_wrapper\">";
    $html .= "<div class=\"col-6\"><input type=\"number\" step=\"any\" name=\"{$param}_nilai_min\" class=\"form-control input-nilai-min\" placeholder=\"Min\" value=\"" . esc((string)$min) . "\"></div>";
    $html .= "<div class=\"col-6\"><input type=\"number\" step=\"any\" name=\"{$param}_nilai_max\" class=\"form-control input-nilai-max\" placeholder=\"Max\" value=\"" . esc((string)$max) . "\"></div>";
    $html .= '</div></div></div>';
    return $html;
}
?>
<div class="page-content-wrapper ">

    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-2">
                <div class="col-lg-3 col-5">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Master Data Air</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive">

                        <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                            <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp"
                                style="float:right;" data-toggle="modal" data-target="#addModal">Add Data</button>
                        <?php } ?>

                        <h4 class="card-title mb-4">Master Data Air</h4>

                        <table id="datatable2" class="table">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="align-middle">No</th>
                                    <th rowspan="2" class="align-middle">Lokasi</th>
                                    <th rowspan="2" class="align-middle">Site</th>
                                    <th rowspan="2" class="align-middle">Jenis Sampling</th>
                                    <th rowspan="2" class="align-middle">No Outlet Sampling</th>
                                    <th rowspan="2" class="align-middle">Nama Outlet Sampling</th>
                                    <th rowspan="2" class="align-middle">Jadwal Minggu Ke</th>
                                    <th colspan="8" class="text-center">Syarat Fisika &amp; Kimia</th>
                                    <th colspan="10" class="text-center">Syarat Mikrobiologi</th>
                                    <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                        <th rowspan="2" class="align-middle">Aksi</th>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <th>Warna</th>
                                    <th>Bau</th>
                                    <th>pH</th>
                                    <th>Suhu</th>
                                    <th>Conductivity</th>
                                    <th>Kesadahan</th>
                                    <th>Zat Padat Total</th>
                                    <th>TOC</th>
                                    <th>TAMC</th>
                                    <th>TYMC</th>
                                    <th>Coliform</th>
                                    <th>E. coli</th>
                                    <th>Salmonella sp</th>
                                    <th>Staphylococcus aureus</th>
                                    <th>Pseudomonas aeruginosa</th>
                                    <th>Shigella sp</th>
                                    <th>Enterobacteriaceae</th>
                                    <th>Clostridia sporogens</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data as $no => $row): ?>
                                    <tr>
                                        <td><?= $no + 1 ?></td>
                                        <td><?= esc($row['lokasi']) ?></td>
                                        <td><?= esc($row['site']) ?></td>
                                        <td><?= esc($row['jenis_sampling']) ?></td>
                                        <td><?= esc($row['no_outlet_sampling']) ?></td>
                                        <td><?= esc($row['nama_outlet_sampling']) ?></td>
                                        <td><?= esc($row['jadwal_minggu_ke']) ?></td>
                                        <td><?= esc($row['syarat_warna']) ?></td>
                                        <td><?= esc($row['syarat_bau']) ?></td>
                                        <td><?= esc($row['syarat_ph']) ?></td>
                                        <td><?= esc($row['syarat_suhu']) ?></td>
                                        <td><?= esc($row['syarat_conductivity']) ?></td>
                                        <td><?= esc($row['syarat_kesadahan']) ?></td>
                                        <td><?= esc($row['syarat_zat_padat_total']) ?></td>
                                        <td><?= esc($row['syarat_toc']) ?></td>
                                        <td><?= esc($row['syarat_tamc']) ?></td>
                                        <td><?= esc($row['syarat_tymc']) ?></td>
                                        <td><?= esc($row['syarat_coliform']) ?></td>
                                        <td><?= esc($row['syarat_e_coli']) ?></td>
                                        <td><?= esc($row['syarat_salmonella_sp']) ?></td>
                                        <td><?= esc($row['syarat_staphylococcus_aureus']) ?></td>
                                        <td><?= esc($row['syarat_pseudomonas_aeruginosa']) ?></td>
                                        <td><?= esc($row['syarat_shigella_sp']) ?></td>
                                        <td><?= esc($row['syarat_enterobacteriaceae']) ?></td>
                                        <td><?= esc($row['syarat_clostridia'] ?: $row['syarat_sporogens']) ?></td>

                                        <?php if ($session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                    <a href="<?= base_url() ?>MasterDataAir/delete/<?= $row['id'] ?>"
                                                        onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                        class="tabledit-delete-button btn btn-sm btn-danger"
                                                        style="float: none; margin: 5px;">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                    <a href="#"
                                                        class="tabledit-edit-button btn btn-sm btn-primary"
                                                        style="float: none; margin: 5px;"
                                                        data-toggle="modal"
                                                        data-target="#editModal<?= $row['id'] ?>">
                                                        <span class="ti-pencil"></span>
                                                    </a>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>

                                    <!-- ===== Edit Modal ===== -->
                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:90%; width:90%;" role="document">
                                            <form method="POST" action="<?= base_url('MasterDataAir/edit/' . $row['id']) ?>" onsubmit="return validasiFormSyarat(this)">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Master Data Air</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">

                                                            <div class="col-md-12">
                                                                <p class="font-weight-bold mb-2">Identitas Outlet</p>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label>Lokasi</label>
                                                                    <input type="text" name="lokasi" class="form-control" value="<?= esc($row['lokasi']) ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                            <div class="form-group">
                                                                <label>Jenis Sampling</label>
                                                                <?php
                                                                    $presetEdit = [
                                                                        'PW (Satu Minggu Satu Kali)',
                                                                        'PW (Satu Bulan Satu Kali)',
                                                                        'City Water',
                                                                        'Soft Water',
                                                                        'Domestic Water',
                                                                        'Air PAM',
                                                                        'Aquademin Suhu Kamar',
                                                                        'Aquademin Panas / Purified Water / Air RO',
                                                                    ];
                                                                    $isPreset = in_array($row['jenis_sampling'], $presetEdit);
                                                                ?>
                                                                <select name="jenis_sampling" id="jenisSamplingEdit<?= $row['id'] ?>"
                                                                    class="form-control" required
                                                                    onchange="toggleJenisSamplingEdit(this, <?= $row['id'] ?>)">
                                                                <option value="">-- Pilih Jenis Sampling --</option>

                                                                <optgroup label="Site Cikarang">
                                                                    <option value="Air PAM/City Water/Soft Water - Mingguan"
                                                                        <?= $row['jenis_sampling'] == 'Air PAM/City Water/Soft Water - Mingguan' ? 'selected' : '' ?>>
                                                                        Air PAM/City Water/Soft Water - Mingguan
                                                                    </option>
                                                                    <option value="Air PAM/City Water/Soft Water - Bulanan"
                                                                        <?= $row['jenis_sampling'] == 'Air PAM/City Water/Soft Water - Bulanan' ? 'selected' : '' ?>>
                                                                        Air PAM/City Water/Soft Water - Bulanan
                                                                    </option>
                                                                    <option value="Purified Water - Mingguan"
                                                                        <?= $row['jenis_sampling'] == 'Purified Water - Mingguan' ? 'selected' : '' ?>>
                                                                        Purified Water - Mingguan
                                                                    </option>
                                                                    <option value="Purified Water - Bulanan"
                                                                        <?= $row['jenis_sampling'] == 'Purified Water - Bulanan' ? 'selected' : '' ?>>
                                                                        Purified Water - Bulanan
                                                                    </option>
                                                                </optgroup>

                                                                <optgroup label="Site Pulogadung">
                                                                    <option value="Air PAM/City Water/Soft Water - Mingguan"
                                                                        <?= $row['jenis_sampling'] == 'Air PAM/City Water/Soft Water - Mingguan' ? 'selected' : '' ?>>
                                                                        Air PAM/City Water/Soft Water - Mingguan
                                                                    </option>
                                                                    <option value="Air PAM/City Water/Soft Water - Bulanan"
                                                                        <?= $row['jenis_sampling'] == 'Air PAM/City Water/Soft Water - Bulanan' ? 'selected' : '' ?>>
                                                                        Air PAM/City Water/Soft Water - Bulanan
                                                                    </option>
                                                                    <option value="Aquademin Suhu Kamar/Aquademin Suhu Panas - Mingguan"
                                                                        <?= $row['jenis_sampling'] == 'Aquademin Suhu Kamar/Aquademin Suhu Panas - Mingguan' ? 'selected' : '' ?>>
                                                                        Aquademin Suhu Kamar/Aquademin Suhu Panas - Mingguan
                                                                    </option>
                                                                    <option value="Aquademin Suhu Kamar/Aquademin Suhu Panas - Bulanan"
                                                                        <?= $row['jenis_sampling'] == 'Aquademin Suhu Kamar/Aquademin Suhu Panas - Bulanan' ? 'selected' : '' ?>>
                                                                        Aquademin Suhu Kamar/Aquademin Suhu Panas - Bulanan
                                                                    </option>
                                                                    <option value="Purified Water - Mingguan"
                                                                        <?= $row['jenis_sampling'] == 'Purified Water - Mingguan' ? 'selected' : '' ?>>
                                                                        Purified Water - Mingguan
                                                                    </option>
                                                                    <option value="Purified Water - Bulanan"
                                                                        <?= $row['jenis_sampling'] == 'Purified Water - Bulanan' ? 'selected' : '' ?>>
                                                                        Purified Water - Bulanan
                                                                    </option>
                                                                </optgroup>

                                                                <option value="__lainnya__" <?= !$isPreset && $row['jenis_sampling'] ? 'selected' : '' ?>>Lainnya...</option>
                                                            </select>
                                                                <input type="text" id="jenisSamplingEditManual<?= $row['id'] ?>"
                                                                    name="jenis_sampling_manual" class="form-control mt-1"
                                                                    placeholder="Ketik jenis sampling..."
                                                                    value="<?= !$isPreset ? esc($row['jenis_sampling']) : '' ?>"
                                                                    style="<?= !$isPreset && $row['jenis_sampling'] ? 'display:block;' : 'display:none;' ?>">
                                                            </div>
                                                        </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Site</label>
                                                                    <select name="site" class="form-control" required>
                                                                        <option value="Cikarang"   <?= $row['site'] == 'Cikarang'   ? 'selected' : '' ?>>Cikarang</option>
                                                                        <option value="Pulogadung" <?= $row['site'] == 'Pulogadung' ? 'selected' : '' ?>>Pulogadung</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>No Outlet Sampling</label>
                                                                    <input type="text" name="no_outlet_sampling" class="form-control" value="<?= esc($row['no_outlet_sampling']) ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Nama Outlet Sampling</label>
                                                                    <input type="text" name="nama_outlet_sampling" class="form-control" value="<?= esc($row['nama_outlet_sampling']) ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label>Jadwal Minggu Ke</label>
                                                                    <input type="text" name="jadwal_minggu_ke" class="form-control" value="<?= esc($row['jadwal_minggu_ke']) ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 mt-2">
                                                                <p class="font-weight-bold mb-2">Syarat Fisika &amp; Kimia</p>
                                                            </div>
                                                            <?php foreach (\App\Libraries\ParameterAirDefinition::fisikaKimia() as $param => $def): ?>
                                                                <?= renderFieldSyarat($param, $def, $syaratIndex[$row['id']][$param] ?? null) ?>
                                                            <?php endforeach; ?>

                                                            <div class="col-md-12 mt-2">
                                                                <p class="font-weight-bold mb-2">Syarat Mikrobiologi</p>
                                                            </div>
                                                            <?php foreach (\App\Libraries\ParameterAirDefinition::mikrobiologi() as $param => $def): ?>
                                                                <?= renderFieldSyarat($param, $def, $syaratIndex[$row['id']][$param] ?? null) ?>
                                                            <?php endforeach; ?>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- ===== End Edit Modal ===== -->

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- ===== Add Modal ===== -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:90%; width:90%;" role="document">
        <form method="POST" action="<?= base_url('MasterDataAir/create') ?>" onsubmit="return validasiFormSyarat(this)">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Master Data Air</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-12">
                            <p class="font-weight-bold mb-2">Identitas Outlet</p>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lokasi</label>
                                <input type="text" name="lokasi" class="form-control"
                                    placeholder="Contoh: Ruang Produksi Tablet" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Jenis Sampling</label>
                               <select name="jenis_sampling" id="jenisSamplingAdd"
                                    class="form-control" required
                                    onchange="toggleJenisSamplingAdd(this)">
                                <option value="">-- Pilih Jenis Sampling --</option>

                                <optgroup label="Site Cikarang">
                                    <option value="Air PAM/City Water/Soft Water - Mingguan">Air PAM/City Water/Soft Water - Mingguan</option>
                                    <option value="Air PAM/City Water/Soft Water - Bulanan">Air PAM/City Water/Soft Water - Bulanan</option>
                                    <option value="Purified Water - Mingguan">Purified Water - Mingguan</option>
                                    <option value="Purified Water - Bulanan">Purified Water - Bulanan</option>
                                </optgroup>

                                <optgroup label="Site Pulogadung">
                                    <option value="Air PAM/City Water/Soft Water - Mingguan">Air PAM/City Water/Soft Water - Mingguan</option>
                                    <option value="Air PAM/City Water/Soft Water - Bulanan">Air PAM/City Water/Soft Water - Bulanan</option>
                                    <option value="Aquademin Suhu Kamar/Aquademin Suhu Panas - Mingguan">Aquademin Suhu Kamar/Aquademin Suhu Panas - Mingguan</option>
                                    <option value="Aquademin Suhu Kamar/Aquademin Suhu Panas - Bulanan">Aquademin Suhu Kamar/Aquademin Suhu Panas - Bulanan</option>
                                    <option value="Purified Water - Mingguan">Purified Water - Mingguan</option>
                                    <option value="Purified Water - Bulanan">Purified Water - Bulanan</option>
                                </optgroup>

                                <option value="__lainnya__">Lainnya...</option>
                            </select>
                                <input type="text" id="jenisSamplingAddManual" name="jenis_sampling_manual"
                                    class="form-control mt-1" placeholder="Ketik jenis sampling..."
                                    style="display:none;">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Site</label>
                                <select name="site" class="form-control" required>
                                    <option value="">-- Pilih Site --</option>
                                    <option value="Cikarang">Cikarang</option>
                                    <option value="Pulogadung">Pulogadung</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>No Outlet Sampling</label>
                                <input type="text" name="no_outlet_sampling" class="form-control"
                                    placeholder="Contoh: OT-01" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nama Outlet Sampling</label>
                                <input type="text" name="nama_outlet_sampling" class="form-control"
                                    placeholder="Contoh: Outlet Produksi Tablet Lt.1" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Jadwal Minggu Ke</label>
                                <input type="text" name="jadwal_minggu_ke" class="form-control"
                                    placeholder="Contoh: 1, 2, 1 dan 3" required>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <p class="font-weight-bold mb-2">Syarat Fisika &amp; Kimia</p>
                        </div>
                        <?php foreach (\App\Libraries\ParameterAirDefinition::fisikaKimia() as $param => $def): ?>
                            <?= renderFieldSyarat($param, $def) ?>
                        <?php endforeach; ?>

                        <div class="col-md-12 mt-2">
                            <p class="font-weight-bold mb-2">Syarat Mikrobiologi</p>
                        </div>
                        <?php foreach (\App\Libraries\ParameterAirDefinition::mikrobiologi() as $param => $def): ?>
                            <?= renderFieldSyarat($param, $def) ?>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- ===== End Add Modal ===== -->

<script>
function toggleJenisSamplingAdd(select) {
    const manual = document.getElementById('jenisSamplingAddManual');
    if (select.value === '__lainnya__') {
        manual.style.display = 'block';
        manual.required = true;
    } else {
        manual.style.display = 'none';
        manual.required = false;
        manual.value = '';
    }
}

function toggleJenisSamplingEdit(select, id) {
    const manual = document.getElementById('jenisSamplingEditManual' + id);
    if (select.value === '__lainnya__') {
        manual.style.display = 'block';
        manual.required = true;
    } else {
        manual.style.display = 'none';
        manual.required = false;
        manual.value = '';
    }
}

function toggleOperatorNilai(select, uid) {
    const wrapper  = document.getElementById(uid + '_wrapper');
    const minInput = wrapper.querySelector('.input-nilai-min');
    const maxInput = wrapper.querySelector('.input-nilai-max');

    if (select.value === 'antara') {
        minInput.style.display = 'block';
        maxInput.style.display = 'block';
    } else if (select.value === '<' || select.value === '<=') {
        minInput.style.display = 'none'; minInput.value = '';
        maxInput.style.display = 'block';
    } else if (select.value === '>' || select.value === '>=') {
        minInput.style.display = 'block';
        maxInput.style.display = 'none'; maxInput.value = '';
    } else if (select.value === 'N/A' || select.value === 'Pendataan') {
        minInput.style.display = 'none'; minInput.value = '';
        maxInput.style.display = 'none'; maxInput.value = '';
    } else {
        minInput.style.display = 'block';
        maxInput.style.display = 'none'; maxInput.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.select-operator').forEach(function (select) {
        toggleOperatorNilai(select, select.dataset.uid);
    });
});

function validasiFormSyarat(form) {
    const selects = form.querySelectorAll('.select-operator');
    for (const select of selects) {
        if (select.value === 'N/A' || select.value === 'Pendataan') continue;

        const uid = select.dataset.uid;
        const wrapper = document.getElementById(uid + '_wrapper');
        const minInput = wrapper.querySelector('.input-nilai-min');
        const maxInput = wrapper.querySelector('.input-nilai-max');

        const minVisible = minInput.style.display !== 'none';
        const maxVisible = maxInput.style.display !== 'none';

        if (minVisible && minInput.value.trim() === '') {
            alert('Nilai Min belum diisi untuk salah satu parameter.');
            minInput.focus();
            return false;
        }
        if (maxVisible && maxInput.value.trim() === '') {
            alert('Nilai Max belum diisi untuk salah satu parameter.');
            maxInput.focus();
            return false;
        }
    }
    return true;
}
</script>


<?= view('parsial/footer'); ?>