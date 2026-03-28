<?php

// 1. Array Asosiatif untuk menyimpan data mahasiswa (minimal 3)
$mahasiswa = [
    [
        'nama' => 'Budi Santoso',
        'nim' => '10101',
        'nilai_tugas' => 85,
        'nilai_uts' => 80,
        'nilai_uas' => 90
    ],
    [
        'nama' => 'Siti Aminah',
        'nim' => '10102',
        'nilai_tugas' => 60,
        'nilai_uts' => 65,
        'nilai_uas' => 55
    ],
    [
        'nama' => 'Agus Pratama',
        'nim' => '10103',
        'nilai_tugas' => 95,
        'nilai_uts' => 85,
        'nilai_uas' => 88
    ],
    [
        'nama' => 'Dewi Lestari',
        'nim' => '10104',
        'nilai_tugas' => 45,
        'nilai_uts' => 50,
        'nilai_uas' => 60
    ]
];

// 2. Function untuk menghitung nilai akhir dengan operator aritmatika
function hitungNilaiAkhir($tugas, $uts, $uas)
{
    // Menggunakan operator aritmatika (* dan +) untuk menghitung bobot
    // Misal: Tugas 30%, UTS 30%, UAS 40%
    return ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);
}

// 3. Menentukan grade dengan menggunakan if/else
function tentukanGrade($nilai_akhir)
{
    if ($nilai_akhir >= 85) {
        return 'A';
    } elseif ($nilai_akhir >= 70) {
        return 'B';
    } elseif ($nilai_akhir >= 60) {
        return 'C';
    } elseif ($nilai_akhir >= 50) {
        return 'D';
    } else {
        return 'E';
    }
}

// 4. Menentukan status kelulusan dengan operator perbandingan
function statusKelulusan($nilai_akhir)
{
    // Menggunakan operator perbandingan (>=)
    // Dinyatakan lulus jika nilai akhir >= 60
    if ($nilai_akhir >= 60) {
        return 'Lulus';
    } else {
        return 'Tidak Lulus';
    }
}

// Variabel untuk perhitungan summary (rata-rata dan tertinggi)
$total_nilai_kelas = 0;
$nilai_tertinggi = 0;

// Melakukan pemrosesan nilai dan menambahkan hasil ke dalam array
foreach ($mahasiswa as $key => $mhs) {
    $nilai_akhir = hitungNilaiAkhir($mhs['nilai_tugas'], $mhs['nilai_uts'], $mhs['nilai_uas']);

    // Menyimpan hasil perhitungan ke dalam array mahasiswa
    $mahasiswa[$key]['nilai_akhir'] = $nilai_akhir;
    $mahasiswa[$key]['grade'] = tentukanGrade($nilai_akhir);
    $mahasiswa[$key]['status'] = statusKelulusan($nilai_akhir);

    // Menambahkan nilai ke total untuk perhitungan rata-rata
    $total_nilai_kelas += $nilai_akhir;

    // Mencari nilai tertinggi menggunakan operator perbandingan
    if ($nilai_akhir > $nilai_tertinggi) {
        $nilai_tertinggi = $nilai_akhir;
    }
}

// Menghitung rata-rata kelas menggunakan operator aritmatika (/)
$rata_rata_kelas = $total_nilai_kelas / count($mahasiswa);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Mahasiswa</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            /* Clean & Formal Slate/Gray Theme */
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);

            --text-main: #1f2937;
            /* Dark Slate Gray */
            --text-muted: #64748b;
            /* Slate Gray */
            --text-light: #94a3b8;

            --success: #15803d;
            /* Clean Green */
            --success-bg: #dcfce7;
            --danger: #b91c1c;
            /* Clean Red */
            --danger-bg: #fee2e2;

            --bg-page-start: #f8fafc;
            --bg-page-end: #e2e8f0;
        }

        * {
            box-sizing: border-box;
        }

        /* Fix overflow dengan overflow-x: hidden di body */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 40px 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background: linear-gradient(135deg, var(--bg-page-start) 0%, var(--bg-page-end) 100%);
            color: var(--text-main);
            overflow-x: hidden;
        }

        /* Ambient geometric shapes - sangat soft dan tebatas untuk estetika formal */
        .shape {
            position: absolute;
            z-index: -1;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            filter: blur(40px);
        }

        .shape-1 {
            width: 500px;
            height: 500px;
            top: -150px;
            left: -150px;
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            bottom: 0px;
            right: -100px;
            background: rgba(203, 213, 225, 0.4);
            /* soft slate */
        }

        .container {
            width: 100%;
            max-width: 1000px;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 16px;
            box-shadow: var(--glass-shadow);
            border: 1px solid var(--glass-border);
            animation: fadeIn 0.5s ease-out;
            position: relative;
            z-index: 1;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .header {
            text-align: center;
            margin-bottom: 35px;
        }

        .header h2 {
            margin: 0;
            font-size: 2rem;
            color: var(--text-main);
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .header p {
            color: var(--text-muted);
            margin-top: 6px;
            font-size: 0.95rem;
        }

        /* Wrapper tabel agar tidak overflow ke kanan */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.6);
            margin-bottom: 30px;
            padding-bottom: 1px;
            /* mencegah clipping box-shadow jika ada */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th,
        td {
            padding: 16px 20px;
            white-space: nowrap;
        }

        th {
            background-color: rgba(241, 245, 249, 0.7);
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        td {
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            color: var(--text-main);
            font-size: 0.95rem;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: background-color 0.2s ease;
        }

        tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }

        .fw-bold {
            font-weight: 500;
            color: #0f172a;
            /* darker slate for emphasis */
        }

        /* Desain formal berbentuk kotak lekuk ujung (bukan bundar) */
        .grade-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-lulus {
            color: var(--success);
            background-color: var(--success-bg);
            border: 1px solid #bbf7d0;
        }

        .status-gagal {
            color: var(--danger);
            background-color: var(--danger-bg);
            border: 1px solid #fecaca;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .summary-card {
            background: rgba(255, 255, 255, 0.4);
            padding: 24px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .summary-card:hover {
            background: rgba(255, 255, 255, 0.7);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .summary-info {
            display: flex;
            flex-direction: column;
        }

        .summary-title {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-main);
            line-height: 1;
        }

        .icon-square {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .summary-card {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

    <!-- Very subtle grayscale background shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>

    <div class="container">
        <div class="header">
            <h2>Sistem Penilaian</h2>
            <p>Rekapitulasi Nilai Akhir & Status Mahasiswa</p>
        </div>

        <!-- Tabel HTML -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center; width: 50px;">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th style="text-align: center;">Tugas</th>
                        <th style="text-align: center;">UTS</th>
                        <th style="text-align: center;">UAS</th>
                        <th style="text-align: center;">Akhir</th>
                        <th style="text-align: center;">Grade</th>
                        <th style="text-align: center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($mahasiswa as $mhs):
                        ?>
                        <tr>
                            <td style="text-align: center; color: var(--text-light);"><?= $no++ ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($mhs['nama']) ?></td>
                            <td style="color: var(--text-muted); font-variant-numeric: tabular-nums;">
                                <?= htmlspecialchars($mhs['nim']) ?></td>
                            <td style="text-align: center;"><?= $mhs['nilai_tugas'] ?></td>
                            <td style="text-align: center;"><?= $mhs['nilai_uts'] ?></td>
                            <td style="text-align: center;"><?= $mhs['nilai_uas'] ?></td>
                            <td style="text-align: center;" class="fw-bold">
                                <?= number_format($mhs['nilai_akhir'], 2) ?>
                            </td>
                            <td style="text-align: center;">
                                <span class="grade-badge"><?= $mhs['grade'] ?></span>
                            </td>
                            <td style="text-align: center;">
                                <span
                                    class="status-badge <?= ($mhs['status'] == 'Lulus') ? 'status-lulus' : 'status-gagal' ?>">
                                    <?= $mhs['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Tampilkan rata-rata kelas dan nilai tertinggi -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-info">
                    <span class="summary-title">Rata-rata Kelas</span>
                    <span class="summary-value"><?= number_format($rata_rata_kelas, 2) ?></span>
                </div>
                <div class="icon-square">
                    📊
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-info">
                    <span class="summary-title">Nilai Tertinggi</span>
                    <span class="summary-value"><?= number_format($nilai_tertinggi, 2) ?></span>
                </div>
                <div class="icon-square">
                    🥇
                </div>
            </div>
        </div>
    </div>

</body>

</html>