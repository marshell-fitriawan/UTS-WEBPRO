<?php
function create_user($username, $password_hash, $full_name, $role = 'admin_gudang', $status = 'inactive', $activation_token = null, $reset_token = null) {
    global $conn;

    $activation_token_sql = ($activation_token === null) ? "NULL" : "'$activation_token'";
    $reset_token_sql = ($reset_token === null) ? "NULL" : "'$reset_token'";

    $query = "INSERT INTO users (username, password, full_name, role, status, activation_token, reset_token)
              VALUES ('$username', '$password_hash', '$full_name', '$role', '$status', $activation_token_sql, $reset_token_sql)";

    return $conn->query($query);
}

// READ - semua user
function get_users($limit = null) {
    global $conn;

    $sql_limit = ($limit === null) ? "" : " LIMIT " . intval($limit);
    $query = "SELECT * FROM users ORDER BY id DESC" . $sql_limit;
    return $conn->query($query);
}


// READ - user by id

function get_user_by_id($id) {
    global $conn;

    $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
    return $conn->query($query);
}


// READ - user by username (email)

function get_user_by_username($username) {
    global $conn;

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    return $conn->query($query);
}


// UPDATE - update user fields (kecuali password)

function update_user($id, $username, $full_name, $role, $status) {
    global $conn;

    $query = "UPDATE users SET
                username = '$username',
                full_name = '$full_name',
                role = '$role',
                status = '$status',
                modified = CURRENT_TIMESTAMP
              WHERE id = '$id'";

    return $conn->query($query);
}

// UPDATE - ubah password
function update_user_password($id, $password_hash) {
    global $conn;

    $query = "UPDATE users SET password = '$password_hash', modified = CURRENT_TIMESTAMP WHERE id = '$id'";
    return $conn->query($query);
}

// DELETE - hapus user
function delete_user($id) {
    global $conn;

    $query = "DELETE FROM users WHERE id = '$id'";
    return $conn->query($query);
}

// Activation token related
function set_activation_token($user_id, $token) {
    global $conn;

    $query = "UPDATE users SET activation_token = '$token' WHERE id = '$user_id'";
    return $conn->query($query);
}

function activate_user_by_token($token) {
    global $conn;

    // set status active and clear token
    $query = "UPDATE users SET status = 'active', activation_token = NULL, modified = CURRENT_TIMESTAMP WHERE activation_token = '$token' AND status = 'inactive'";
    return $conn->query($query);
}

function get_user_by_activation_token($token) {
    global $conn;

    $query = "SELECT * FROM users WHERE activation_token = '$token' LIMIT 1";
    return $conn->query($query);
}

// Reset password token related
function set_reset_token($user_id, $token) {
    global $conn;

    $query = "UPDATE users SET reset_token = '$token' WHERE id = '$user_id'";
    return $conn->query($query);
}

function get_user_by_reset_token($token) {
    global $conn;

    $query = "SELECT * FROM users WHERE reset_token = '$token' LIMIT 1";
    return $conn->query($query);
}

function reset_password_by_token($token, $new_password_hash) {
    global $conn;

    $query = "UPDATE users SET password = '$new_password_hash', reset_token = NULL, modified = CURRENT_TIMESTAMP WHERE reset_token = '$token'";
    return $conn->query($query);
}
?>
