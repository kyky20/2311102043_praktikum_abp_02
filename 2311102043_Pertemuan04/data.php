<?php
header('Content-Type: application/json');

$data = [
    ['nama' => 'Budi Santoso', 'pekerjaan' => 'Front-End Developer', 'lokasi' => 'Jakarta'],
    ['nama' => 'Siti Aminah', 'pekerjaan' => 'UI/UX Designer', 'lokasi' => 'Bandung'],
    ['nama' => 'Andi Wijaya', 'pekerjaan' => 'Back-End Engineer', 'lokasi' => 'Surabaya'],
    ['nama' => 'Rina Melati', 'pekerjaan' => 'Data Analyst', 'lokasi' => 'Yogyakarta'],
    ['nama' => 'Tommy Setiawan', 'pekerjaan' => 'DevOps Engineer', 'lokasi' => 'Semarang'],
    ['nama' => 'Dewi Lestari', 'pekerjaan' => 'Product Manager', 'lokasi' => 'Bali'],
    ['nama' => 'Fajar Nugroho', 'pekerjaan' => 'SEO Specialist', 'lokasi' => 'Malang'],
    ['nama' => 'Nina Kartika', 'pekerjaan' => 'Graphic Designer', 'lokasi' => 'Medan'],
    ['nama' => 'Rizky Pratama', 'pekerjaan' => 'Mobile Developer', 'lokasi' => 'Makassar'],
    ['nama' => 'Anita Wulandari', 'pekerjaan' => 'QA Engineer', 'lokasi' => 'Palembang'],
];

echo json_encode($data);
?>