<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class NotifikasiEmailService
{
    /**
     * Dipanggil sekali setiap ada data baru dibuat (EHM Air / EHM Ruangan / Kualifikasi Ruangan / EHM Swab).
     */
    public function kirimNotifikasiDataBaru(array $emailTujuan, array $item): bool
    {
        // Filter email tujuan agar tidak ada nilai kosong
        $emailTujuan = array_values(array_filter($emailTujuan, function ($e) {
            return !empty(trim((string) $e));
        }));

        if (empty($emailTujuan)) {
            log_message('warning', 'Notifikasi data baru (' . ($item['no_dokumen'] ?? '-') . ') tidak dikirim: tidak ada email tujuan.');
            return false;
        }

        $mail = new PHPMailer(true);

        try {
            // ==========================================
            // 1. KONTROL SMTP SERVER (GMAIL)
            // ==========================================
            $mail->isSMTP();
            $mail->Host       = env('email.SMTPHost', 'smtp.gmail.com');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('email.SMTPUser', '');
            $mail->Password   = env('email.SMTPPass', '');

            // Konfigurasi Keamanan (SSL port 465 atau TLS port 587)
            $crypto = strtolower(env('email.SMTPCrypto', 'ssl'));
            if ($crypto === 'ssl') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = (int) env('email.SMTPPort', 465);
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = (int) env('email.SMTPPort', 587);
            }

            $mail->Timeout = 30;
            $mail->CharSet = 'UTF-8';

            // ==========================================
            // 2. BYPASS VERIFIKASI SSL DI LOKAL (WINDOWS)
            // ==========================================
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                ]
            ];

            // ==========================================
            // 3. PENGIRIM & PENERIMA
            // ==========================================
            $fromEmail = env('email.fromEmail', 'no-reply@bintangtoedjoe.com');
            $fromName  = env('email.fromName', 'Sistem EHM PT Bintang Toedjoe');
            
            $mail->setFrom($fromEmail, $fromName);

            foreach ($emailTujuan as $address) {
                $mail->addAddress(trim($address));
            }

            // ==========================================
            // 4. KONTEN EMAIL
            // ==========================================
            $mail->isHTML(true);
            $mail->Subject = '[EHM] Data Baru Menunggu Approval Anda - ' . ($item['no_dokumen'] ?? '');
            
            // Panggil view template bawaan CI4
            $mail->Body    = view('emails/notifikasi_data_baru', ['item' => $item]);

            $mail->AltBody = "Halo,\n\nAda data baru yang membutuhkan approval Anda di Sistem EHM:\n" .
                             "No Dokumen: " . ($item['no_dokumen'] ?? '-') . "\n" .
                             "Jenis EHM: " . ($item['jenis_ehm'] ?? '-') . "\n" .
                             "Detail: " . ($item['url_detail'] ?? '-');

            $mail->send();
            return true;

        } catch (Exception $e) {
            log_message('error', 'Gagal kirim email PHPMailer (' . ($item['no_dokumen'] ?? '-') . '): ' . $mail->ErrorInfo);
            return false;
        }
    }
}