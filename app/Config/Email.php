<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $fromEmail = '';
    public string $fromName  = '';

    public string $protocol = 'smtp';

    public string $SMTPHost = '';
    public string $SMTPUser = '';
    public string $SMTPPass = '';
    public int    $SMTPPort = 587;
    public string $SMTPCrypto = 'tls';
    public int    $SMTPTimeout = 30;
    public bool   $SMTPKeepAlive = false;

    public bool $wordWrap = true;
    public int    $wrapChars = 76;
    public string $mailType = 'html';
    public string $charset  = 'UTF-8';
    public bool   $validate = false;
    public int    $priority = 3;
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
    public bool   $BCCBatchMode = false;
    public int    $BCCBatchSize = 200;
    public bool   $DSN = false;

    public function __construct()
    {
        parent::__construct();

        // Ambil dari .env supaya credential tidak hardcode di kode
        $this->fromEmail  = env('email.fromEmail', 'no-reply@bintangtoedjoe.com');
        $this->fromName   = env('email.fromName', 'Sistem EHM PT Bintang Toedjoe');
        $this->SMTPHost   = env('email.SMTPHost', '');
        $this->SMTPUser   = env('email.SMTPUser', '');
        $this->SMTPPass   = env('email.SMTPPass', '');
        $this->SMTPPort   = (int) env('email.SMTPPort', 587);
        $this->SMTPCrypto = env('email.SMTPCrypto', 'tls');
    }
}