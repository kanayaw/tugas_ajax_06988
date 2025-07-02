<?php
require 'vendor/autoload.php';
require 'db.php';

use Dompdf\Dompdf;

$keyword = isset($_GET['keyword']) ? $koneksi->real_escape_string($_GET['keyword']) : '';
$sql = "SELECT nim, nama, jurusan FROM mahasiswa WHERE nim LIKE '%$keyword%' OR nama LIKE '%$keyword%'";
$result = $koneksi->query($sql);

$html = '<h3 style="text-align:center;">Data Mahasiswa</h3>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">
<thead>
<tr>
<th>NIM</th>
<th>Nama</th>
<th>Jurusan</th>
</tr>
</thead>
<tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
    <td>' . $row['nim'] . '</td>
    <td>' . $row['nama'] . '</td>
    <td>' . $row['jurusan'] . '</td>
    </tr>';
}

$html .= '</tbody></table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("data_mahasiswa.pdf", ["Attachment" => true]);
exit;
?>
