<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-md-10">
        <h4 class="mb-0"><i class="fa fa-cubes"></i> Tambah Data Barang</h4>
    </div>
</div>
<hr class="mt-0" />
<?= form_open(); ?>
<div class="col-md-8">

    <div class="form-group row">
        <label for="KodeBarang" class="col-sm-3 col-form-label">Kode Barang</label>
        <div class="col-sm-9 col-md-6">
            <input type="text" class="form-control form-control-sm <?= (form_error('kode')) ? 'is-invalid' : ''; ?>" id="KodeBarang" name="kode" placeholder="Kode Barang" value="<?= set_value('kode'); ?>">
            <div class="invalid-feedback">
                <?= form_error('kode', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="KodeHs" class="col-sm-3 col-form-label">Kode HS</label>
        <div class="col-sm-9 col-md-6">
            <input type="text" class="form-control form-control-sm <?= (form_error('kode_hs')) ? 'is-invalid' : ''; ?>" id="KodeHs" name="kode_hs" placeholder="Kode HS" value="<?= set_value('kode_hs'); ?>">
            <div class="invalid-feedback">
                <?= form_error('kode_hs', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>

	<div class="form-group row">
        <label for="katbarangx" class="col-sm-3 col-form-label">Kategori</label>
        <div class="col-sm-9 col-md-6">
            <select class="custom-select custom-select-sm supplier <?= (form_error('kat_barang')) ? 'is-invalid' : ''; ?>" id="katbarangx" name="kat_barang">
                <option value="" disabled selected>Pilih Kategori</option>
                <?php foreach ($kategori->result() as $k) : ?>
                    <option value="<?= $k->id_kat_barang; ?>">
                        <?= $k->nama_kat_barang ; ?>
                    </option>
                <?php endforeach; ?>
            </select>
			<div class="invalid-feedback">
                <?= form_error('kat_barang', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm <?= (form_error('nama_barang')) ? 'is-invalid' : ''; ?>" id="nama_barang" name="nama_barang" placeholder="Nama Barang" value="<?= set_value('nama_barang'); ?>">
            <div class="invalid-feedback">
                <?= form_error('nama_barang', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="brand" class="col-sm-3 col-form-label">Brand</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm <?= (form_error('brand')) ? 'is-invalid' : ''; ?>" id="brand" name="brand" placeholder="Nama Brand" value="<?= set_value('brand'); ?>">
            <div class="invalid-feedback">
                <?= form_error('brand', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
	
	<div class="form-group row">
        <label for="satbarangx" class="col-sm-3 col-form-label">Satuan</label>
        <div class="col-sm-9 col-md-6">
            <select class="custom-select custom-select-sm supplier <?= (form_error('sat_barang')) ? 'is-invalid' : ''; ?>" id="satbarangx" name="sat_barang">
                <option value="" disabled selected>Pilih Satuan</option>
                <?php foreach ($satuan as $key => $val) : ?>
                    <option value="<?= $key; ?>">
                        <?= $val ; ?>
                    </option>
                <?php endforeach; ?>
            </select>
			<div class="invalid-feedback">
                <?= form_error('sat_barang', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
	
	<!--
    <div class="form-group row">
        <label for="harga" class="col-sm-3 col-form-label">Harga Jual</label>
        <div class="col-sm-6">
            <input type="text" class="form-control form-control-sm uang <? //(form_error('harga')) ? 'is-invalid' : ''; ?>" id="harga" name="harga" placeholder="Harga Jual" value="<? //set_value('harga'); ?>">
            <div class="invalid-feedback">
                <? //form_error('harga', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
	-->

    <div class="form-group row">
        <div class="col-sm-9 offset-md-3">
            <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Tambah Data</button>
            <button type="button" class="btn btn-light btn-sm" onclick="window.history.back()">Kembali</button>
        </div>
    </div>
</div>
<?= form_close(); ?>