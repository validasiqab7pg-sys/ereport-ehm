<?php
// app/Database/Migrations/2026-07-17-000001_CreateScanHasilAir.php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScanHasilAir extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_sampling' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama_asli'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'nama_file'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'uploaded_by' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'uploaded_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('id_sampling');
        $this->forge->addForeignKey('id_sampling', 'data_sampling_air', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('scan_hasil_air');
    }

    public function down()
    {
        $this->forge->dropTable('scan_hasil_air');
    }
}