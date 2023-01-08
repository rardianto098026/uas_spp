<table border="1">
    <thead>
      <tr>
        <th>No</th>
        <th>NISN</th>
        <th>NIS</th>
        <th>Nama Lengkap</th>
        <th>Kelas</th>
        <th>Alamat</th>
        <th>No. Telp</th>
        <th>Tarif SPP</th>
      </tr>
    </thead>
    <tbody>
      <?php $num=1 ?>
      <?php foreach ($list as $row) : ?>
        <tr>
          <td><?= $num++; ?></td>
          <td><?= $row['nisn']; ?></td>
          <td><?= $row['nis']; ?></td>
          <td><?= $row['nama']; ?></td>
          <td><?= $row['nama_kelas']; ?></td>
          <td><?= $row['alamat']; ?></td>
          <td><?= $row['no_telp']; ?></td>
          <td><?= $row['nominal']; ?></td>
      <?php endforeach ?>
    </tbody>
</table>