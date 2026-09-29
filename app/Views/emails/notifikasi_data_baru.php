<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi EHM</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; -webkit-font-smoothing: antialiased;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f6f9; padding: 30px 10px;">
        <tr>
            <td align="center">
                
                <!-- Main Container Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); padding: 24px 30px; text-align: left;">
                            <span style="background-color: rgba(255, 255, 255, 0.2); color: #ffffff; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 8px;">
                                Approval Required
                            </span>
                            <h1 style="color: #ffffff; font-size: 20px; margin: 0; font-weight: 600;">Sistem E-Report EHM</h1>
                            <p style="color: #dbeafe; font-size: 13px; margin: 4px 0 0 0;">PT Bintang Toedjoe</p>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 30px;">
                            <p style="font-size: 15px; color: #1e293b; margin-top: 0; margin-bottom: 16px; font-weight: 500;">Halo Bapak/Ibu,</p>
                            <p style="font-size: 14px; color: #475569; margin-top: 0; margin-bottom: 24px; line-height: 1.5;">
                                Terdapat pengajuan data baru yang memerlukan peninjauan dan verifikasi dari Anda sebagai <strong>QA Analis</strong>.
                            </p>

                            <!-- Data Table Card -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0; overflow: hidden; margin-bottom: 24px;">
                                
                                <!-- Document No (Primary) -->
                                <tr style="border-bottom: 1px solid #e2e8f0; background-color: #f1f5f9;">
                                    <td style="padding: 12px 16px; font-size: 13px; font-weight: 600; color: #475569; width: 35%;">No. Dokumen</td>
                                    <td style="padding: 12px 16px; font-size: 14px; font-weight: 700; color: #1e3a8a;"><?= esc($item['no_dokumen'] ?? '-') ?></td>
                                </tr>

                                <!-- Jenis EHM -->
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 10px 16px; font-size: 13px; font-weight: 600; color: #64748b;">Jenis EHM</td>
                                    <td style="padding: 10px 16px; font-size: 13px; color: #1e293b;"><?= esc($item['jenis_ehm'] ?? '-') ?></td>
                                </tr>

                                <!-- Tanggal -->
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 10px 16px; font-size: 13px; font-weight: 600; color: #64748b;">Tanggal</td>
                                    <td style="padding: 10px 16px; font-size: 13px; color: #1e293b;">
                                        <?= esc(!empty($item['tanggal']) ? date('d/m/Y', strtotime($item['tanggal'])) : '-') ?>
                                    </td>
                                </tr>

                                <!-- Dynamic Additional Rows (Otomatis tampil jika ada data lain di array $item) -->
                                <?php 
                                $ignoredKeys = ['no_dokumen', 'jenis_ehm', 'tanggal', 'url_detail'];
                                foreach ($item as $key => $val) : 
                                    if (in_array($key, $ignoredKeys) || is_array($val)) continue;
                                    $label = ucwords(str_replace('_', ' ', $key));
                                ?>
                                    <tr style="border-bottom: 1px solid #e2e8f0;">
                                        <td style="padding: 10px 16px; font-size: 13px; font-weight: 600; color: #64748b;"><?= esc($label) ?></td>
                                        <td style="padding: 10px 16px; font-size: 13px; color: #1e293b;"><?= esc($val ?? '-') ?></td>
                                    </tr>
                                <?php endforeach; ?>

                            </table>

                            <!-- Call to Action Button -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 10px 0 20px 0;">
                                        <a href="<?= esc($item['url_detail'] ?? '#') ?>" target="_blank" style="background-color: #2563eb; color: #ffffff; font-size: 14px; font-weight: 600; padding: 12px 28px; text-decoration: none; border-radius: 6px; display: inline-block; box-shadow: 0 2px 4px rgba(37, 99, 235, 0.25);">
                                            Lihat &amp; Proses Approval
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="font-size: 12px; color: #94a3b8; margin: 0; line-height: 1.4;">
                                Email ini dikirimkan secara otomatis oleh <strong>Sistem E-Report EHM PT Bintang Toedjoe</strong>.<br>
                                Harap tidak membalas email ini secara langsung.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>