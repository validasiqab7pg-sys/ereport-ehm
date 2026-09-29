

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resume</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        .no_border {

            border: none !important;
            width: 100%;
            text-align: center;


        }

        .noborder {

            border: none !important;
            font-weight: bold;

            padding-bottom: 10px;


        }
    </style>


</head>

<body>

    <div>

        <table border="1" style="width: 100%; text-align: center;">
            <tr>
                <th style="width: 25%;">
                    <img src="<?= $imageSrc ?>" style="width:200px;" alt="" height="75" class="auth-logo logo-dark mx-auto">

                </th>
                <th style="width: 75%; font-size: 20px;">Pemantauan Ruangan (EHM)</th>
            </tr>

        </table>
        <br>
        <table class="no_border">
            <tr>
                <td class="noborder" style="text-align: left;">Unit Ahu </td>
                <td class="noborder" style="width: 5%;">: </td>
                <td class="noborder" style="text-align: left;"><?= $Detail_PPOJ['ahu'] ?></td>
                <td class="noborder" style="width: 25%; text-align: left;">Nama Ruangan </td>
                <td class="noborder" style="width: 5%;">: </td>
                <td class="noborder" style="text-align: left;"><?= $Detail_PPOJ['nama_ruangan'] ?></td>
            </tr>

            <tr>
                <td class="noborder" style="text-align: left;">Tanggal </td>
                <td class="noborder" style="width: 5%;">: </td>
                <td class="noborder" style="text-align: left;"><?= $Detail_PPOJ['tanggaldilakukan'] ?></td>
                <td class="noborder" style="width: 25%; text-align: left;">Site </td>
                <td class="noborder" style="width: 5%;">: </td>
                <td class="noborder" style="text-align: left;"><?= $Detail_PPOJ['site'] ?></td>
            </tr>
        </table>

        <table border="1" style='text-align:center; padding:10px;'>

            <tr>
                <th rowspan="8">Titik Sampling</th>
                <th rowspan="3" style="width: 70px;">Kelas</th>
                <th colspan="2" rowspan="2">Suhu</th>
                <th colspan="2" rowspan="2">RH</th>
                <th rowspan="3">Perbedaan Tekanan Ruangan (Pa)</th>
                <th rowspan="8">Flow CFM</th>
                <th rowspan="3">Jumlah Pertukaran Udara</th>
                <th rowspan="1" colspan="4">Jumlah Partikel Maks. (counts/m3)</th>
                <th colspan="2" rowspan="2">Mikroba Volumetrik</th>
                <th colspan="2" rowspan="2">Mikroba Cawan Papar</th>
                <th rowspan="8">Kesimpulan</th>

            </tr>

            <tr>
                <td colspan="2">At Rest</td>
                <td colspan="2">In Operation</td>
            </tr>

            <tr>
                <td>Min</td>
                <td>Max</td>
                <td>Min</td>
                <td>Max</td>
                <td>0.5um</td>
                <td>5.0um</td>
                <td>0.5um</td>
                <td>5.0um</td>
                <td>TPC</td>
                <td>KK</td>
                <td>TPC</td>
                <td>KK</td>
            </tr>

            <tr>
                <td>A</td>
                <td>16</td>
                <td>25</td>
                <td>45</td>
                <td>55</td>
                <td rowspan="5">Ruangan Berbeda Kelas : Min 10 <br><br>
                    Kelas Kebersihan sama : 5 - 20</td>
                <td>Min. 500</td>
                <td>3.520</td>
                <td>20</td>
                <td>3.520</td>
                <td>20</td>
                <td>
                    &lt; 1</td>
                <td>
                    &lt; 1</td>
                <td>
                    &lt; 1</td>
                <td>
                    &lt; 1</td>
            </tr>

            <tr>
                <td>C</td>
                <td>16</td>
                <td>25</td>
                <td>45</td>
                <td>55</td>
                <td>Min. 20</td>
                <td>352.000</td>
                <td>2.900</td>
                <td>352.000</td>
                <td>29.000</td>
                <td>100</td>
                <td>50</td>
                <td>50</td>
                <td>25</td>

            </tr>
            <tr>
                <td>D</td>
                <td>20</td>
                <td>27</td>
                <td>40</td>
                <td>60</td>
                 <td>5-20 atau ≥ 20</td>
                <td>3.520.000</td>
                <td>29.000</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>200</td>
                <td>100</td>
                <td>100</td>
                <td>50</td>
            </tr>
            <tr>
                <td>E</td>
                <td>20</td>
                <td>27</td>
                <td colspan="2">&lt;= 70</td>

                <td>5-20 atau &gt;= 20</td>
                <td rowspan="2">3.520.000</td>
                <td rowspan="2">29.000</td>
                <td rowspan="2">N/A</td>
                <td rowspan="2">N/A</td>
                <td rowspan="2">300</td>
                <td rowspan="2">100</td>
                <td rowspan="2">N/A</td>
                <td rowspan="2">N/A</td>
            </tr>
            <tr>
                <td>E Khusus</td>
                <td>16</td>
                <td>25</td>
                <td colspan="2">&lt;= 30</td>

                <td>5-20 atau &gt;= 20</td>

            </tr>
            <?php foreach ($DataSuhuRH as $no => $row) :  ?>
                <tr>
                    <td>X<?= $no + 1 ?></td>
                    <td> <?= ($row['KELAS']) ? $row['KELAS'] : 'N/A' ?></td>
                    <td> <?= ($row['SUHU_MIN']) ? $row['SUHU_MIN'] : 'N/A' ?></td>
                    <td> <?= ($row['SUHU_MAX']) ? $row['SUHU_MAX'] : 'N/A' ?></td>
                    <td> <?= ($row['RH_MIN']) ? $row['RH_MIN'] : 'N/A' ?></td>
                    <td> <?= ($row['RH_MAX']) ? $row['RH_MAX'] : 'N/A' ?></td>
                    <?php if (0 >= $no) { ?>
                        <td rowspan="<?= $JumlahData  ?>">


                            <?php foreach ($Perbedaan_ruangan as $nomor => $row2) : ?>
                                <?= $nomor + 1 . ' ' . $row2['terhadap_ruangan'] . ' : ' . $row2['hasil_dp'] . '<br>'; ?>


                            <?php endforeach; ?>


                        </td>
                    <?php } ?>

                    <?php if (0 >= $no) { ?>
                        <td rowspan="<?= $JumlahData ?>" align="center">
                            <?php foreach ($Detail_Flow as $flow) : ?>
                                <?= $flow['hasil_flow'] . '<br>'; ?>
                            <?php endforeach; ?>
                        </td>
                    <?php } ?>

                    <?php if (0 >= $no) { ?>
                        <td rowspan="<?= $JumlahData  ?>"><?= $Detail_PPOJ['jumlah_pertukaran_udara'] ?></td>
                    <?php } ?>

                    <?php if ($kondisi == "In Operation") { ?>
                        <td>N/A</td>
                        <td>N/A </td>
                        <?php if ($cekpartikel > 0) { ?>
                            <?php if (0 >= $no) {  ?>

                                <td colspan="2" rowspan="<?= $JumlahData ?>"> Terlampir </td>
                            <?php }
                        } else { ?>
                            <td>N/A</td>
                            <td>N/A</td>
                        <?php } ?>

                    <?php }
                    if ($kondisi == "At Rest") { ?>

                        <?php if ($cekpartikel > 0) { ?>
                            <?php if (0 >= $no) {  ?>
                                <td colspan="2" rowspan="<?= $JumlahData ?>"> Terlampir </td>
                            <?php } ?>
                        <?php
                        } else { ?>
                            <td>N/A</td>
                            <td>N/A</td>
                        <?php } ?>

                        <td>N/A</td>
                        <td>N/A</td>
                    <?php } ?>
                    <td> <?= $row['MIKRO_TPC'] != null ? $row['MIKRO_TPC'] : 'N/A' ?></td>
                    <td> <?= $row['MIKRO_KK'] != null ? $row['MIKRO_KK'] : 'N/A' ?></td>
                    <td> <?= $row['CAPAR_TPC'] != null ? $row['CAPAR_TPC'] : 'N/A' ?></td>
                    <td> <?= $row['CAPAR_KK'] != null ? $row['CAPAR_KK'] : 'N/A' ?></td>
                    <?php if (0 >= $no) { ?>
                        <td rowspan="<?= $JumlahData ?>">
                            <?php if ($keterangan[0]['cekKondisi'] >= 1) { ?>
                                MS
                            <?php  } else { ?>

                                TMS
                            <?php } ?>
                        </td>
                    <?php } ?>
                </tr>
            <?php endforeach; ?>


            <!-- <tr>
                <td></td>
                <td>12B</td>
                <td>13B</td>
                <td>14B</td>
                <td>12B</td>
                <td>13B</td>
                <td>14B</td>
                <td>12B</td>
                <td>13B</td>
                <td>14B</td>
                <td>12B</td>
                <td>13B</td>
                <td>14B</td>
                <td>12B</td>
                <td>13B</td>
                <td>14B</td>
                <td>14B</td>
                <td>14B</td>

            </tr> -->
        </table>
        <br>
        <br>
        <table border="1" style="width: 100%; text-align: center;">
            <tr>
                <td style="width: 25%;">Disampling oleh <br><br><?= $Detail_AHU['approve_1']; ?> - <?= $Detail_AHU['approve_1_date']; ?> <br>(QA Analyst)</td>
                <td style="width: 25%;">Dianalisa oleh <br><br><?= $Detail_AHU['approve_2']; ?>- <?= $Detail_AHU['approve_2_date']; ?> <br> (QA Analyst / QC Analyst)</td>
                <td style="width: 25%;">Diperiksa oleh <br><br><?= $Detail_AHU['approve_3']; ?>- <?= $Detail_AHU['approve_3_date']; ?> <br> (QC Spv/Spi/Mgr)</td>
                <td style="width: 25%;">Disetujui oleh <br><br><?= $Detail_AHU['approve_4']; ?>- <?= $Detail_AHU['approve_4_date']; ?> <br> (QA Spv/Spi/Mgr)</td>


            </tr>
        </table>
    </div>
    <div style="text-align: center; padding: 10px 0;">
        <p style="margin: 0;">Dokumen ini telah ditandatangani secara elektronik menggunakan aplikasi FUPD Online dengan
            melampirkan lembar</p>
        <p style="margin: 0;">persetujuan elektronik milik PT. Bintang Toedjoe (A Kalbe Company)</p>
        <p style="margin: 0;"><img src="<?= $imageSrcApproved ?>" style="width:150px;" alt="" height="50" class="auth-logo logo-dark mx-auto"></p>
    </div>

</body>


</html>