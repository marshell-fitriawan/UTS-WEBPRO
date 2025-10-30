<?php
include 'connect.php';

// Buat password hash baru untuk password: "admin123"
$password_plain = 'admin123';
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

// Insert user admin
$sql_user = "INSERT INTO users (username, password, full_name, role, status)
VALUES ('admin1@example.com', '$password_hash', 'Admin Utama', 'admin', 'active')";

if ($conn->query($sql_user) === TRUE) {
    echo "User admin berhasil ditambahkan!<br>";
    echo "<strong>Email:</strong> admin1@example.com<br>";
    echo "<strong>Password:</strong> $password_plain<br><br>";
    $admin_id = $conn->insert_id; // Ambil ID admin yang baru dibuat
} else {
    echo "Error insert user: " . $conn->error . "<br>";
    $admin_id = 1; 
}

// Insert products
$products = [
    ['SSD Samsung 500GB', 'SSD NVMe untuk performa tinggi', 850000, 12],
    ['Harddisk WD 1TB', 'Harddisk internal SATA 1TB', 650000, 8],
    ['RAM Team Elite 8GB DDR4', 'RAM DDR4 gaming standar', 420000, 20],
    ['Monitor LG 24 Inch', 'Monitor IPS 75Hz Full HD', 1750000, 5],
    ['Keyboard Mechanical Redragon', 'Switch Outemu Blue clicky', 450000, 14],
    ['Mouse Logitech G102', 'Mouse gaming RGB', 240000, 25],
    ['Power Supply 550W', 'PSU 80Plus Bronze Bersertifikat', 750000, 7],
    ['Laptop Acer Aspire 3', 'Laptop kuliah/kerja i3 11th Gen', 6250000, 3],
    ['VGA RTX 3060 12GB', 'Kartu grafis gaming mid-high', 5900000, 4],
    ['Casing Gaming RGB', 'Casing mid-tower dengan RGB', 550000, 9]
];

$stmt = $conn->prepare("INSERT INTO products (name, description, price, stock, created_by) VALUES (?, ?, ?, ?, ?)");

foreach ($products as $product) {
    $stmt->bind_param('ssdii', $product[0], $product[1], $product[2], $product[3], $admin_id);
    if ($stmt->execute()) {
        echo "Produk '{$product[0]}' berhasil ditambahkan!<br>";
    } else {
        echo "Error insert produk '{$product[0]}': " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();

echo "<br><strong>Selesai! Simpan kredensial di atas dan hapus file ini untuk keamanan.</strong>";
?>
