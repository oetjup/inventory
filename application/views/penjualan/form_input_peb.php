<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-sm-12 col-md-10">
        <h4 class="mb-0"><i class="fa fa-share"></i> Tambah Data Pabean PEB</h4>
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
        <label for="kodeDok" class="col-sm-2 col-form-label">Kode Dokumen</label>
        <div class="col-sm-4">
            <select class="custom-select custom-select-sm supplier <?= (form_error('kodeDok')) ? 'is-invalid' : ''; ?>" id="kodeDok" name="kodeDok">
                <option value="" disabled selected>Pilih Kode Dokumen</option>
                <?php foreach ($kode_dok as $kd) : ?>
                    <option value="<?= $kd; ?>" <?= set_select('kodeDok',  $kd); ?>>
                        <?= $kd; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">
                <?= form_error('kodeDok', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="noAju" class="col-sm-2 col-form-label">Nomor Aju</label>
        <div class="col-sm-9 col-md-4">
            <input type="text" class="form-control form-control-sm <?= (form_error('noAju')) ? 'is-invalid' : ''; ?>" id="noAju" name="noAju" placeholder="Nomor Aju" value="<?= set_value('noAju'); ?>">
            <div class="invalid-feedback">
                <?= form_error('noAju', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="noDaftar" class="col-sm-2 col-form-label">Nomor Daftar</label>
        <div class="col-sm-9 col-md-4">
            <input type="text" class="form-control form-control-sm <?= (form_error('noDaftar')) ? 'is-invalid' : ''; ?>" id="noDaftar" name="noDaftar" placeholder="Nomor Daftar" value="<?= set_value('noDaftar'); ?>">
            <div class="invalid-feedback">
                <?= form_error('noDaftar', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Daftar</label>
        <div class="col-sm-2">
            <input type="text" class="form-control form-control-sm <?= (form_error('tanggal')) ? 'is-invalid' : ''; ?>" name="tanggal" id="date-picker" value="<?= (set_value('tanggal')) ? set_value('tanggal') : date('d/m/Y'); ?>">
            <div class="invalid-feedback">
                <?= form_error('tanggal', '<p class="error-message">', '</p>'); ?>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-3 offset-sm-2">
            <div id="rowid-field"></div>
            <div id="btn-act">
                <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm">Tambah Data</button>
                <button type="button" class="btn btn-light btn-sm" onclick="window.history.back()">Kembali</button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>