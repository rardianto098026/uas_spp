<table border="1">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Petugas</th>
        <th>Username</th>
        <th>Level User</th>
      </tr>
    </thead>
    <tbody>
      <?php $num=1 ?>
      <?php foreach ($list as $row) : ?>
        <tr>
          <td><?= $num++; ?></td>
          <td><?= $row['nama_petugas']; ?></td>
          <td><?= $row['username']; ?></td>
          <td><?= $row['level']; ?></td>
      <?php endforeach ?>
    </tbody>
</table>