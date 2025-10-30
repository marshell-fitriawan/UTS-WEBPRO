<?php
// CREATE - tambah produk
function create_product($name, $description, $price = 0.00, $stock = 0, $created_by = null) {
    global $conn;

    $created_by_sql = ($created_by === null) ? "NULL" : "'$created_by'";

    $query = "INSERT INTO products (name, description, price, stock, created_by)
              VALUES ('$name', '$description', '$price', '$stock', $created_by_sql)";

    return $conn->query($query);
}

// READ - semua produk
function get_products($limit = null) {
    global $conn;

    $sql_limit = ($limit === null) ? "" : " LIMIT " . intval($limit);
    $query = "SELECT * FROM products ORDER BY id DESC" . $sql_limit;
    return $conn->query($query);
}

// READ - produk by id
function get_product_by_id($id) {
    global $conn;

    $query = "SELECT * FROM products WHERE id = '$id' LIMIT 1";
    return $conn->query($query);
}

// UPDATE - update produk
function update_product($id, $name, $description, $price, $stock) {
    global $conn;

    $query = "UPDATE products SET
                name = '$name',
                description = '$description',
                price = '$price',
                stock = '$stock',
                modified = CURRENT_TIMESTAMP
              WHERE id = '$id'";

    return $conn->query($query);
}

// DELETE - hapus produk
function delete_product($id) {
    global $conn;

    $query = "DELETE FROM products WHERE id = '$id'";
    return $conn->query($query);
}

// READ - produk by created_by 
function get_products_by_user($user_id, $limit = null) {
    global $conn;

    $sql_limit = ($limit === null) ? "" : " LIMIT " . intval($limit);
    $query = "SELECT * FROM products WHERE created_by = '$user_id' ORDER BY id DESC" . $sql_limit;
    return $conn->query($query);
}
?>
