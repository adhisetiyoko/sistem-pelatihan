<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Peserta Pelatihan</title>
    <style>
        /* Reset dan gaya dasar */
        body {
            font-family: "Helvetica", Arial, sans-serif;
            font-size: 10pt;
            margin: 1cm;
            color: #333;
            line-height: 1.5;
        }
        
        /* Header */
        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3a7bd5;
        }
        
        .header h1 {
            color: #3a7bd5;
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
        }
        
        /* Informasi dokumen */
        .doc-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 9pt;
            color: #666;
        }
        
        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }
        
        th {
            background-color: #3a7bd5;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 6px 8px;
            border: 1px solid #ddd;
            font-size: 9pt;
            text-align: center;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Footer */
        .footer {
            margin-top: 15px;
            text-align: right;
            font-style: italic;
            font-size: 8pt;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>DATA PESERTA PELATIHAN</h1>
    </div>
    
    <!-- Informasi Dokumen -->
    <div class="doc-info">
        <div>Tanggal Cetak: <?= date('d F Y H:i') ?></div>
        <div>Total Peserta: <?= count($peserta) ?></div>
    </div>
    
    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">NIK</th>
                <th style="width: 15%;">No Induk</th>
                <th style="width: 35%;">Nama Peserta</th>
                <th style="width: 20%;">Modul</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach($peserta as $p): ?>
            <tr>
                <td style="width: 5%;"><?= $no++ ?></td>
                <td style="width: 25%;"><?= chunk_split($p->nik_peserta, 4, ' ') ?></td>
                <td style="width: 15%;"><?= $p->no_induk_peserta ?></td>
                <td style="width: 35%;"><?= ucwords(strtolower($p->nama_peserta)) ?></td>
                <td style="width: 20%;">
                    <?php 
                    ?>
                    <span class="<?= $modul_class ?>"><?= $p->modul_pelatihan ?></span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <!-- Footer -->
    <div class="footer">
        Dicetak oleh: <?= $this->session->userdata('username') ?> | Halaman {PAGENO}/{nbpg}
    </div>
</body>
</html>