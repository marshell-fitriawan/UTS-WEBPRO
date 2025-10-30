<?php
include __DIR__ . '/../connect.php';

$result = $conn->query("SELECT p.id, p.name, p.description, p.price, p.stock, p.created, u.full_name AS creator
                        FROM products p
                        LEFT JOIN users u ON p.created_by = u.id
                        ORDER BY p.id DESC");
?>
<table>
  <thead>
    <tr>
      <th>No</th><th>Nama</th><th>Deskripsi</th><th>Harga</th><th>Stock</th><th>Dibuat Oleh</th><th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result && $result->num_rows): ?>
      <?php 
      $no = 1; // inisialisasi nomor urut
      while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
          <td><?= number_format($row['price'],2,',','.') ?></td>
          <td><?= (int)$row['stock'] ?></td>
          <td><?= $row['creator'] ? htmlspecialchars($row['creator']) : htmlspecialchars($row['created']) ?></td>
          <td>
            <a class="btn btn-secondary" href="product_form.php?id=<?= $row['id'] ?>">Edit</a>
            <a class="btn btn-danger" href="../aksi/product_delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus produk ini?')">Hapus</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="7">Belum ada produk.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
