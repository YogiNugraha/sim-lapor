<?php
declare(strict_types=1);

/**
 * Basic, safer upload helpers (still conservative).
 * TODO: enforce file type/size validation at call-site.
 */

function safeMoveUpload(string $formField, string $targetDir, ?string $targetName = null): string {
    if (!isset($_FILES[$formField]) || !is_uploaded_file($_FILES[$formField]['tmp_name'])) {
        throw new RuntimeException('No valid uploaded file.');
    }

    // Ensure directory exists
    if (!is_dir($targetDir)) {
        if (!@mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
            throw new RuntimeException('Failed to create upload directory.');
        }
    }

    $originalName = $_FILES[$formField]['name'] ?? 'upload.bin';
    $base = $targetName ?: basename($originalName);
    // Normalize name
    $base = preg_replace('/[^A-Za-z0-9._-]/', '_', $base) ?: 'upload.bin';

    $dest = rtrim($targetDir, '/').'/'.$base;

    if (!move_uploaded_file($_FILES[$formField]['tmp_name'], $dest)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    return $dest;
}

function UploadFile($fupload_name){
    return safeMoveUpload('fupload', 'file/', $fupload_name);
}

function UploadLapor($fupload_name){
    return safeMoveUpload('fupload', 'file/lapor/', $fupload_name);
}

function UploadSURATMASUK($fupload_name){
    return safeMoveUpload('fupload', 'file/suratmasuk/', $fupload_name);
}

function UploadSURATKELUAR($fupload_name){
    return safeMoveUpload('fupload', 'file/suratkeluar/', $fupload_name);
}

function UploadLampiran($fupload_name){
    return safeMoveUpload('fupload', 'file/lampiran/', $fupload_name);
}

function UploadSURAT($fupload_name){
    return safeMoveUpload('fupload', 'file/surat/', $fupload_name);
}

function UploadPoin($fupload_name){
    return safeMoveUpload('fupload', 'file/poin/', $fupload_name);
}

function UploadREK($fupload_name){
    return safeMoveUpload('fupload', '../asamurat2.upmk.ac.id/file/rek/', $fupload_name);
}

function UploadKegiatan($fupload_name){
    return safeMoveUpload('fupload', 'file/kegiatan/', $fupload_name);
}
