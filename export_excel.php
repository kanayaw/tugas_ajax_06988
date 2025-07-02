<?php
require 'vendor/autoload.php';
require 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$keyword = isset($_GET['keyword']) ? $koneksi->real_escape_string($_GET['keyword']) : '';
$sql = "SELECT nim, nama, jurusan FROM mahasiswa WHERE nim LIKE '%$keyword%' OR nama LIKE '%$keyword%'";
$result = $koneksi->query($sql);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'NIM');
$sheet->setCellValue('B1', 'Nama');
$sheet->setCellValue('C1', 'Jurusan');

$row = 2;
while ($data = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $row, $data['nim']);
    $sheet->setCellValue('B' . $row, $data['nama']);
    $sheet->setCellValue('C' . $row, $data['jurusan']);
    $row++;
}

$filename = "data_mahasiswa.xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
