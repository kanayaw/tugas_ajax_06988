<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Live Search Mahasiswa</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    #loading { display: none; font-weight: bold; }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Live Search Mahasiswa (AJAX + Export)</h2>
    <div class="d-flex mb-3">
      <input type="text" id="search" class="form-control me-2" placeholder="Ketik nama atau NIM...">
      <button type="button" class="btn btn-success me-2" id="exportBtn">Export Excel</button>
      <button type="button" class="btn btn-danger" id="exportPdfBtn">Export PDF</button>
    </div>
    <div id="loading">Mencari...</div>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Jurusan</th>
        </tr>
      </thead>
      <tbody id="result"></tbody>
    </table>
  </div>

  <script>
    const searchBox = document.getElementById("search");
    const result = document.getElementById("result");
    const loading = document.getElementById("loading");

    searchBox.addEventListener("keyup", function () {
      const keyword = searchBox.value.trim();
      if (keyword.length === 0) {
        result.innerHTML = "";
        return;
      }

      loading.style.display = "block";
      fetch("search.php?keyword=" + encodeURIComponent(keyword))
        .then(res => res.json())
        .then(data => {
          loading.style.display = "none";
          result.innerHTML = "";

          if (data.length === 0) {
            result.innerHTML = "<tr><td colspan='3' class='text-center'>Data tidak ditemukan</td></tr>";
          } else {
            data.forEach(row => {
              result.innerHTML += `<tr>
                <td>${row.nim}</td>
                <td>${row.nama}</td>
                <td>${row.jurusan}</td>
              </tr>`;
            });
          }
        });
    });

    // Tampilkan semua data saat halaman pertama kali dibuka
    window.addEventListener("DOMContentLoaded", function () {
      fetch("search.php")
        .then(res => res.json())
        .then(data => {
          result.innerHTML = "";

          if (data.length === 0) {
            result.innerHTML = "<tr><td colspan='3' class='text-center'>Tidak ada data</td></tr>";
          } else {
            data.forEach(row => {
              result.innerHTML += `<tr>
                <td>${row.nim}</td>
                <td>${row.nama}</td>
                <td>${row.jurusan}</td>
              </tr>`;
            });
          }
        });
    });

    document.getElementById("exportBtn").addEventListener("click", function () {
      const keyword = searchBox.value.trim();
      const url = "export_excel.php?keyword=" + encodeURIComponent(keyword);
      window.open(url, "_blank");
    });

    document.getElementById("exportPdfBtn").addEventListener("click", function () {
      const keyword = searchBox.value.trim();
      const url = "export_pdf.php?keyword=" + encodeURIComponent(keyword);
      window.open(url, "_blank");
    });
  </script>
</body>
</html>
