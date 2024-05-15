<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tablespk extends Migration
{
    public function up()
    {
        // Tabel Pemilihan Jurusan Metode AHP 
        // Table kriteria
        $data                       =  [
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'nama'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'kode'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 12,
            ], 'created_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ];
        $this->forge->addField($data);
        $this->forge->addKey('id', true);
        $this->forge->createTable('spk_kriteria', true);

        $data                       =  [
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'id_kriteria'                  => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => false,
            ],
            'label'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'keterangan'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ], 'created_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ];
        $this->forge->addField($data);
        $this->forge->addKey('id', true);
        $this->forge->createTable('spk_sub_kriteria', true);


        // Table alternatif
        $data                       =  [
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'id_user'                  => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'id_jurusan'                  => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'nilai'                  => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'created_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ];
        $this->forge->addField($data);
        $this->forge->addKey('id', true);
        $this->forge->createTable('spk_alternatif', true);

        // Jurusan
        $data                       =  [
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'nama'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'kode'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 12,
            ], 'created_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at'            => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ];
        $this->forge->addField($data);
        $this->forge->addKey('id', true);
        $this->forge->createTable('spk_jurusan', true);




        // Akumulasi
        $data = [
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['main', 'sub'],
                'default'    => 'main',
            ],
            'id_pair' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'id_main' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0,
            ],
            'nilai' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null'              => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null'              => true,
            ],
        ];
        $this->forge->addField($data);
        $this->forge->addKey('id', true);
        $this->forge->createTable('spk_akumulasi', true);
    }

    public function down()
    {
        //
        $this->forge->dropTable('spk_kriteria');
        $this->forge->dropTable('spk_sub_kriteria');
        $this->forge->dropTable('spk_alternatif');
        $this->forge->dropTable('spk_jurusan');
        $this->forge->dropTable('spk_akumulasi');
    }
}