<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-md-10">
        <h4 class="mb-0"><i class="fa fa-reply"></i> Tambah Data Produksi Proses</h4>
    </div>
</div>
<hr class="mt-0" />
<div id="message">
    <?php if ($this->session->flashdata('alert')) : ?>
        <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('alert'); ?></div>
    <?php endif; ?>
</div>
<?= form_open(); ?>
<div class="col-md-12">
    <div class="form-group row">
        <label for="no-produksi" class="col-sm-2 col-form-label">No Produksi</label>
        <div class="col-sm-3">
            <input type="text" name="no-produksi" id="no-produksi" class="form-control form-control-sm <?= (form_error('no-produksi')) ? 'is-invalid' : ''; ?>" placeholder="Nomor Produksi" value="<?= (set_value('no-produksi')) ? set_value('no-produksi') : 'PIN'.time() ; ?>">
            <div class="invalid-feedback">
                <?= form_error('no-produksi', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Produksi</label>
        <div class="col-sm-3">
            <input type="text" class="form-control form-control-sm <?= (form_error('tanggal')) ? 'is-invalid' : ''; ?>" name="tanggal" id="date-picker" value="<?= (set_value('tanggal')) ? set_value('tanggal') : date('d/m/Y'); ?>">
            <div class="invalid-feedback">
                <?= form_error('tanggal', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="barang-produksi-proses" class="col-sm-2 col-form-label">Barang</label>
        <div class="col-sm-6">
            <select class="barang-select custom-select custom-select-sm pilih-barang" id="barang-produksi-proses">
                <option value="" disabled selected>Pilih Barang</option>
                <?php foreach ($data->result() as $d) : ?>
                    <option value="<?= $d->kode_barang; ?>">
                        <?= $d->nama_barang . ' ( ' . $d->brand . ' )'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="harga" class="col-sm-2 col-form-label">Stok</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm qty" id="sisa" placeholder="Stok Barang" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="jumlahx" class="col-sm-2 col-form-label">Jumlah</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm qty" id="jumlahx" placeholder="Jumlah">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3 offset-sm-2">
            <div id="rowid-field"></div>
            <div id="btn-act">
                <button type="button" class="btn btn-success btn-sm tambah-produksi-proses" onclick="tambah_cart_produksi_proses()">
                    Tambah Barang
                </button>
            </div>
        </div>
    </div>

    <table class="table table-striped table-hover table-sm">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
				<th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Jumlah</th>
                <!--
				<th scope="col">Harga</th>
                <th scope="col">Harga Total</th>
				-->
                <th scope="col">Opsi</th>
            </tr>
        </thead>
        <tbody id="daftar-produksi-proses">
            <?= $table; ?>
        </tbody>
    </table>
    <div class="col-sm-6 offset-sm-8">
        <button type="submit" name="submit" class="btn btn-primary btn-sm" value="Submit">
            <i class="fa fa-save"></i> Simpan Data Produksi
        </button>
        <button type="button" onclick="window.history.back()" class="btn btn-light btn-sm">
            Kembali
        </button>
    </div>
</div>
<?= form_close(); ?>