<div style="font-family: Arial, sans-serif; font-size: 14px; color:#333; max-width:600px;">
    <p>Halo,</p>
    <p>Ada data baru yang membutuhkan approval Anda di Sistem EHM:</p>

    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <td style="padding:8px; border:1px solid #ddd; background:#f8f9fa; width:150px;"><strong>No Dokumen</strong></td>
            <td style="padding:8px; border:1px solid #ddd;"><?= esc($item['no_dokumen']) ?></td>
        </tr>
        <tr>
            <td style="padding:8px; border:1px solid #ddd; background:#f8f9fa;"><strong>Jenis EHM</strong></td>
            <td style="padding:8px; border:1px solid #ddd;"><?= esc($item['jenis_ehm']) ?></td>
        </tr>
        <tr>
            <td style="padding:8px; border:1px solid #ddd; background:#f8f9fa;"><strong>Tanggal</strong></td>
            <td style="padding:8px; border:1px solid #ddd;">
                <?= esc($item['tanggal'] ? date('d/m/Y', strtotime($item['tanggal'])) : '-') ?>
            </td>
        </tr>
    </table>

    <p style="margin-top:20px;">
        <a href="<?= esc($item['url_detail']) ?>"
           style="background:#5664d2; color:#fff; padding:10px 20px; text-decoration:none; border-radius:4px; display:inline-block;">
            Lihat &amp; Proses
        </a>
    </p>

    <p style="color:#888; font-size:12px; margin-top:30px; border-top:1px solid #eee; padding-top:10px;">
        Email ini dikirim otomatis oleh Sistem EHM PT Bintang Toedjoe. Mohon tidak membalas email ini.
    </p>
</div>