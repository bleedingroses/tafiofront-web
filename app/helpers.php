<?php

function gambar($nama_file) {
    return "<img src='http://" . env('BACKEND') . "/storage/content/" . substr($nama_file, 0, 2) . "/" . substr($nama_file, 2, 2) . "/" . $nama_file . "' >";
}

function gambarConfig($nama_file) {
    return "<img src='http://" . env('BACKEND') . "/storage/web/" . substr($nama_file, 0, 2) . "/" . substr($nama_file, 2, 2) . "/" . $nama_file . "' >";
}
