<?php

require "config.php";

function log_audit($table,$feild,$old,$new,$user_id){
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO audit (table_name,field_name,old_value,new_value,action_by) VALUES(?,?,?,?,?)");
    $stmt->execute([$table,$feild,$old,$new,$user_id]);
}

function get_entries(){
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM entries WHERE is_deleted = 0 ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function get_entry($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM entries WHERE id = ? AND is_deleted = 0");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_user($id){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

