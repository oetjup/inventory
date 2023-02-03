<?php
defined('BASEPATH') or exit('No direct script access allowed');

$d = $data->row();

function tanggal_indo($tgl)
{
    $bulan  = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    $exp    = explode('-', date('d-m-Y', strtotime($tgl)));

    return $exp[0] . ' ' . $bulan[(int) $exp[1]] . ' ' . $exp[2];
}

?>

<div class="row">
    <div class="col-sm-12 col-md-10">
        <h4 class="mb-0"><i class="fa fa-share"></i> Detail Pabean PEB</h4>
    </div>
</div>
<hr class="mt-0" />
<h6 class="mb-1 mt-2">Jenis Dokumen</h6>
<p class="text-muted display-5 mt-1 mb-2"><?= $d->kode_dok; ?></p>
<h6 class="mb-1 mt-2">Nomor Aju</h6>
<p class="text-muted display-5 mt-1 mb-2"><?= $d->nomor_aju; ?></p>
<h6 class="mb-1 mt-2">Nomor Daftar</h6>
<p class="text-muted display-5 mt-1 mb-2"><?= $d->nomor_daftar; ?></p>
<h6 class="mb-2">Tanggal Daftar</h6>
<p class="text-muted display-5 mt-1 mb-2"><?= tanggal_indo($d->tanggal_daftar); ?></p>

<div class="float-right">
    <button type="button" class="btn btn-light" onclick="window.history.back()">Kembali</button>
</div>