<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-md-10">
        <h4 class="mb-0"><i class="fa fa-file-text"></i> Laporan Mutasi Barang</h4>
    </div>
</div>
<hr class="mt-0" />
<?php
if ($this->session->flashdata('alert')) {
    echo '<div class="alert alert-danger" role="alert">
    ' . $this->session->flashdata('alert') . '
  </div>';
}
?>
<!-- <?// form_open('', ['class' => ""]); ?> -->
<!-- <form> -->
<!-- <div class="row"> -->
    <div class="row">
    <div class="col-md-10">
        <div class="form-group row">
            <label for="tanggal" class="col-sm-2 col-form-label">Periode</label>
            <div class="col-sm-2">
                <input type="text" name="tanggal" class="form-control form-control-sm" id="date-picker" placeholder="dd/mm/yyyy" value="<?= $tanggal; ?>">
            </div>
            <label for="tanggal" class="col-form-label">s/d</label>
            <div class="col-sm-2">
                <input type="text" name="tanggal2" class="form-control form-control-sm" id="date-picker-2" placeholder="dd/mm/yyyy" value="<?= $tanggal2; ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Kode Barang</label>
            <div class="col-sm-4">
                <select class="barang-select custom-select custom-select-sm pilih-barang" id="barang-penjualan" name="kode_barang">
                    <option value="" selected>Semua Barang</option>
                    <?php
                    foreach ($barang->result() as $b) :
                        // $kb = (set_value('kode_barang')) ? set_value('kode_barang') : $kode_barang;

                        $pilih = ($kode_barang == $b->kode_barang) ? 'selected' : '';

                        echo '<option value="' . $b->kode_barang . '" ' . $pilih . '>
                            '.$b->kode_barang.' ('. $b->nama_barang . ')
                        </option>';
                    endforeach; ?>
                    
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10 offset-sm-2">
                <button type="submit" class="btn btn-primary mb-2 btn-sm" name="cari" value="Search" id="proses">
                    Proses
                </button>
            </div>
        </div>
    

        <!-- <div class="form-row">
            <div class="col-auto">
            <label for="tanggal" class="col-sm-2 col-form-label">Periode</label>
            
            <input type="text" name="tanggal" class="form-control form-control-sm mr-sm-2" id="date-picker" placeholder="dd/mm/yyyy" value="<?// $tanggal; ?>">
            <span>s/d</span>
            </div>
            <div class="col-auto">
            <input type="text" name="tanggal2" class="form-control form-control-sm ml-sm-2" id="date-picker-2" placeholder="dd/mm/yyyy" value="<?// $tanggal2; ?>">
            </div>
        </div>
        <div class="form-group mx-sm-3 mb-2 row">
            <label for="date-picker">Tanggal &nbsp;</label>
            <input type="text" name="tanggal" class="form-control form-control-sm mr-sm-2" id="date-picker" placeholder="dd/mm/yyyy" value="<?// $tanggal; ?>">
            <span>s/d</span>
            <input type="text" name="tanggal2" class="form-control form-control-sm ml-sm-2" id="date-picker-2" placeholder="dd/mm/yyyy" value="<?// $tanggal2; ?>">
        </div>
        <button type="submit" class="btn btn-primary mb-2 btn-sm" name="cari" value="Search">
            Cari Data
        </button> -->
        <!-- <?// form_close(); ?> -->
    </div>
    <div class="col-md-2 col-sm-12">
        <?php
            // $filter = $kode_barang != '' ? ['kode_barang' => $kode_barang] : '';
            if ($kode_barang) {
                $filter = ['kode_barang' => $kode_barang];
            }else{
                $filter = '';
            }
        ?>
        <!-- <a href="<?// site_url('stok_harian/' . date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)))  .'/'.  date('Y-m-d', strtotime(str_replace('/', '-', $tanggal2))) .'/'. $kode_barang); ?>" class="btn btn-success btn-block btn-sm" target="_blank">
            <i class="fa fa-print"></i> Cetak
        </a> -->
        <a href="<?= site_url('laporan/cetak_excel/' . date('Y-m-d', strtotime(str_replace('/', '-', $tanggal)))  .'/'.  date('Y-m-d', strtotime(str_replace('/', '-', $tanggal2))) .'/'. $kode_barang); ?>" class="btn btn-success btn-block btn-sm">
            <i class="fa fa-print"></i> Cetak
        </a>
    </div>
        </div>
<!-- </div> -->

<table class="table table-sm table-bordered table-striped mt-3" id="table-report">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Kode Barang</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Jenis Barang</th>
            <th scope="col" class="text-center">Stok Awal</th>
            <th scope="col" class="text-center">Pemasukan</th>
            <th scope="col" class="text-center">Pengeluaran</th>
            <th scope="col" class="text-center">Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $dt) {
                $penjualanbef = ($dt->qty_penjualan_bef != '') ? $dt->qty_penjualan_bef : 0;
                $pembelianbef = ($dt->qty_pembelian_bef != '') ? $dt->qty_pembelian_bef : 0;

                $penjualanbcur = ($dt->qty_penjualan != '') ? $dt->qty_penjualan : 0;
                $pembelianbcur = ($dt->qty_pembelian != '') ? $dt->qty_pembelian : 0;
                $prosesbcur = ($dt->qty_proses != '') ? $dt->qty_proses : 0;

                $penjualanaf = ($dt->qty_penjualan_new != '') ? $dt->qty_penjualan_new : 0;
                $pembelianaf = ($dt->qty_pembelian_new != '') ? $dt->qty_pembelian_new : 0;

                echo '<tr>';
                echo '<td>' . $i++ . '</td>';
                echo '<td>' . $dt->kode_barang . '</td>';
                echo '<td>' . $dt->nama_barang . '</td>';
                echo '<td>' . $dt->nama_kat_barang . '</td>';
                // echo '<td class="text-center">' . ((($dt->stok + $penjualanbef) - $pembelianbef)+$pembelianbef-$pembelianbcur-$pembelianaf-$penjualanbef+$penjualanaf) . '</td>';
                echo '<td class="text-center">' . ((($dt->stok + $penjualanbef) - $pembelianbef)+$pembelianbef-$pembelianbcur-$pembelianaf-$penjualanbef+$penjualanaf+$penjualanbcur) . '</td>';
                // echo '<td class="text-center">' . (($pembelianbcur != '') ? $pembelianbcur : 0) . '</td>';
                // echo '<td class="text-center">' . (($penjualanbcur != '') ? $penjualanbcur : 0) . '</td>';
                echo '<td class="text-center">' . $pembelianbcur . '</td>';
                echo '<td class="text-center">' . ($penjualanbcur+$prosesbcur) . '</td>';
                echo '<td class="text-center">' . (($dt->stok + $penjualanaf) - $pembelianaf) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr>';
            echo '<td colspan="8" class="text-center">Data tidak ditemukan</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<div class="row">
    <div class="col-sm-12 col-md-10">
        <div id='pagination'>
            <?php echo $pager; ?>
        </div>
    </div>
</div>