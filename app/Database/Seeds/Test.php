<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Myth\Auth\Password;

class Test extends Seeder
{
    public function run()
    {
        // Group
        $data = [
            [
                'name' => 'Admin',
                'description' => 'Admin',
            ],
            [
                'name' => 'User',
                'description' => 'Perator',
            ],
        ];

        // Using Query Builder
        $this->db->table('auth_groups')->insertBatch($data);

        // USERS
        $data = [
            [
                'email'         => 'admin@gmail.com',
                'username'      => 'Admin',
                'password_hash' => Password::hash('admin'),
                'active'        => 1,
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],

            [
                'email'         => 'user@gmail.com',
                'username'      => 'user',
                'password_hash' => Password::hash('12345'),
                'active'        => 1,
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],

        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);

        $data = [
            [
                'group_id'   => 1,
                'user_id'    => 1
            ],
            [
                'group_id'   => 2,
                'user_id'    => 2
            ],
        ];

        // Using Query Builder
        $this->db->table('auth_groups_users')->insertBatch($data);

        $data = [
            [
                'nama' => 'Informatika',
                'kode' => 'TI',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Sistem Informasi',
                'kode' => 'SI',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Teknik Elektro',
                'kode' => 'TE',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Agribisnis',
                'kode' => 'AG',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Farmasi',
                'kode' => 'FRM',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Pendidikan Guru Sekolah Dasar',
                'kode' => 'PGSD',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Pendidikan Bahasa Indonesia',
                'kode' => 'PBIN',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Pendidikan Bahasa Inggris',
                'kode' => 'PBI',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Pendidikan Matematika',
                'kode' => 'PMAT',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Manajemen',
                'kode' => 'MNJ',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Akuntansi',
                'kode' => 'AKT',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Ilmu Komunikasi',
                'kode' => 'ILKOM',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Hubungan Internasional',
                'kode' => 'HI',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
        ];
        $this->db->table('spk_jurusan')->insertBatch($data);

        $data = [
            [
                'nama' => 'Biaya',
                'kode' => 'K1',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Prospek',
                'kode' => 'K2',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Minat',
                'kode' => 'K3',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'nama' => 'Bakat',
                'kode' => 'K4',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
        ];
        $this->db->table('spk_kriteria')->insertBatch($data);

        $data = [
            [
                'id_kriteria' => 1,
                'label' => 'Sangat Murah',
                'keterangan' => '< Rp. 2.000.000',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 1,
                'label' => 'Murah',
                'keterangan' => 'Rp. 2.000.000 - Rp. 3.000.000',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 1,
                'label' => 'Cukup',
                'keterangan' => 'Rp. 3.000.000 - Rp. 5.000.000',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 1,
                'label' => 'Mahal',
                'keterangan' => '> Rp. 5.000.000',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 2,
                'label' => 'Sangat Baik',
                'keterangan' => '90 - 100',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 2,
                'label' => 'Baik',
                'keterangan' => '80 - 90',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 2,
                'label' => 'Cukup',
                'keterangan' => '65 - 80',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 2,
                'label' => 'Kurang',
                'keterangan' => '< 65',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 3,
                'label' => 'Sangat Berminat',
                'keterangan' => '90 - 100',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 3,
                'label' => 'Berminat',
                'keterangan' => '80 - 90',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 3,
                'label' => 'Cukup',
                'keterangan' => '65 - 80',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 3,
                'label' => 'Kurang',
                'keterangan' => '< 65',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 4,
                'label' => 'Sangat Berbakat',
                'keterangan' => '90 - 100',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 4,
                'label' => 'Berbakat',
                'keterangan' => '80 - 90',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 4,
                'label' => 'Cukup',
                'keterangan' => '65 - 80',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
            [
                'id_kriteria' => 4,
                'label' => 'Kurang',
                'keterangan' => '< 65',
                'created_at'    => Time::now('Asia/Jakarta', 'id_ID'),
                'updated_at'    => Time::now('Asia/Jakarta', 'id_ID')
            ],
        ];
        $this->db->table('spk_sub_kriteria')->insertBatch($data);
    }
}