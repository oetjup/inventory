<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //load library
        $this->load->library(['template', 'form_validation', 'cart']);
        //load model
        $this->load->model('m_pembelian');

        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
    }

    public function index()
    {
        //cek login
        $this->is_login();
        //kosongkan cart
        $this->cart->destroy();

        $data = [
            'title' => 'Data Pembelian Barang'
        ];

        $this->template->kasir('pembelian/index', $data);
    }

    public function tambah_data()
    {
        $this->is_login();

        //ketika button simpan di klik maka lakukan proses validasi dan penyimpanan data
        if ($this->input->post('submit', TRUE) == 'Submit') {
            //cek apakah user sudah memilih barang atau belum, jika belum maka munculkan pesan kesalahan
            if (!$this->cart->contents()) {
                $this->session->set_flashdata('alert', 'Anda belum memilih barang...');

                redirect('tambah_pembelian', 'refresh');
            }
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'tanggal',
                'Tanggal Pembelian',
                'required|callback_checkDateFormat',
                array(
                    'required' => '{field} wajib diisi',
                    'checkDateFormat' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'supplier',
                'Supplier',
                'required|min_length[10]',
                array(
                    'required' => '{field} wajib dipilih',
                    'min_length' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'pabean',
                'Pabean',
                'required',
                array(
                    'required' => '{field} wajib dipilih'
                )
            );

            if ($this->form_validation->run() == TRUE) {

                $id = 'ID' . time();
                $tgl = date('Y-m-d', strtotime(str_replace('/', '-', $this->security->xss_clean($this->input->post('tanggal', TRUE)))));
                $sup = $this->security->xss_clean($this->input->post('supplier', TRUE));
                $user = $this->session->userdata('UserID');
                $pabean = $this->security->xss_clean($this->input->post('pabean', TRUE));

                $data_pembelian = [
                    'id_pembelian' => $id,
                    'tgl_pembelian' => $tgl,
                    'id_supplier' => $sup,
                    'id_user' => $user,
                    'id_pabean' => $pabean
                ];
                //baca cart dan memasukkannya dalam array untuk disimpan
                $cart = array();

                foreach ($this->cart->contents() as $c) {
                    $item = [
                        'id_pembelian' => $id,
                        'id_barang' => $c['id'],
                        'qty' => $c['qty'],
                        'harga' => $c['price'],
                        'hpp' => $c['hpp'],
                        'bm' => $c['bm'],
                        'bmt' => $c['bmt'],
                        'pph' => $c['pph'],
                        'ppn' => $c['ppn']
                    ];

                    //push ke array cart
                    array_push($cart, $item);
                }
                //simpan data pembelian
                $simpan = $this->m_pembelian->save('tbl_pembelian', $data_pembelian);

                if ($simpan) {
                    //simpan data detail pembelian
                    $this->m_pembelian->multiSave('tbl_detail_pembelian', $cart);
                    //kosongkan cart
                    $this->cart->destroy();
                    //buat notifikasi penyimpanan berhasil
                    $this->session->set_flashdata('success', 'Data pembelian berhasil ditambahkan...');

                    redirect('data_pembelian');
                }
            }
        }

        $data = [
            'title' => 'Tambah Data Pembelian',
            'data' => $this->m_pembelian->getData('tbl_barang', ['active' => 'Y']),
            'supplier' => $this->m_pembelian->getAllData('tbl_supplier'),
            'pabean' => $this->m_pembelian->getData('tbl_pabean', ['jenis_dok' => '1']),
            'table' => $this->read_cart()
        ];

        $this->template->kasir('pembelian/form_input', $data);
    }

    public function hapus_data()
    {
        //cek login
        $this->is_login();
        //validasi request ajax
        if ($this->input->is_ajax_request()) {
            //validasi
            $this->form_validation->set_rules(
                'id',
                'ID Pembelian',
                "required|min_length[10]",
                array(
                    'required' => '{field} tidak valid',
                    'min_length' => 'Isi {field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                //tangkap rowid
                $id = $this->security->xss_clean($this->input->post('id', TRUE));

                $hapus = $this->m_pembelian->delete(['tbl_pembelian', 'tbl_detail_pembelian'], ['id_pembelian' => $id]);

                if ($hapus) {
                    echo json_encode(['message' => 'success']);
                } else {
                    echo json_encode(['message' => 'failed']);
                }
            } else {
                echo json_encode(['message' => 'failed']);
            }
        } else {
            redirect('dashboard');
        }
    }

    public function detail_pembelian($id = null)
    {
        if ($id == null) {
            redirect('data_pembelian');
        }

        //cek login
        $this->is_login();
        //ambil data
        $getData = $this->m_pembelian->getDataPembelian($this->security->xss_clean($id));

        if ($getData->num_rows() < 1) {
            redirect('dashboard');
        }

        $data = [
            'title' => 'Detail Pembelian ' . $id,
            'data' => $getData
        ];

        $this->template->kasir('pembelian/detail', $data);
    }

    public function edit_pembelian($id = null)
    {
        if ($id == null) {
            redirect('data_pembelian');
        }
        //ambil data pembelian
        $getData = $this->m_pembelian->getDataPembelian($this->security->xss_clean($id));
        //hitung data
        if ($getData->num_rows() < 1) {
            redirect('data_pembelian');
        }
        //ketika button diklik
        if ($this->input->post('submit', TRUE) == 'Update') {
            //cek apakah user sudah memilih barang atau belum, jika belum maka munculkan pesan kesalahan
            if (!$this->cart->contents()) {
                $this->session->set_flashdata('alert', 'Anda belum memilih barang...');

                redirect('edit_pembelian/' . $id, 'refresh');
            }
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'tanggal',
                'Tanggal Pembelian',
                'required|callback_checkDateFormat',
                array(
                    'required' => '{field} wajib diisi',
                    'checkDateFormat' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'supplier',
                'Supplier',
                'required|min_length[10]',
                array(
                    'required' => '{field} wajib dipilih',
                    'min_length' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'idP',
                'ID Pembelian',
                'required|min_length[10]',
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'pabean',
                'Pabean',
                'required',
                array(
                    'required' => '{field} wajib dipilih'
                )
            );

            if ($this->form_validation->run() == TRUE) {

                $idP = $this->security->xss_clean($this->input->post('idP', TRUE));
                $tgl = date('Y-m-d', strtotime(str_replace('/', '-', $this->security->xss_clean($this->input->post('tanggal', TRUE)))));
                $sup = $this->security->xss_clean($this->input->post('supplier', TRUE));
                $pab = $this->security->xss_clean($this->input->post('pabean', TRUE));

                $data_pembelian = [
                    'tgl_pembelian' => $tgl,
                    'id_supplier' => $sup,
                    'id_pabean' => $pab
                ];

                //baca cart dan memasukkannya dalam array untuk disimpan
                $cart = array();

                foreach ($this->cart->contents() as $c) {
                    $item = [
                        'id_pembelian' => $idP,
                        'id_barang' => $c['id'],
                        'qty' => $c['qty'],
                        'harga' => $c['price'],
                        'hpp' => $c['hpp'],
                        'bm' => $c['bm'],
                        'bmt' => $c['bmt'],
                        'pph' => $c['pph'],
                        'ppn' => $c['ppn']
                    ];

                    //push ke array cart
                    array_push($cart, $item);
                }
                //simpan data pembelian
                $update = $this->m_pembelian->update('tbl_pembelian', $data_pembelian, ['id_pembelian' => $idP]);

                if ($update) {
                    //hapus detail pembelian
                    $this->m_pembelian->delete('tbl_detail_pembelian', ['id_pembelian' => $idP]);
                    //simpan data detail pembelian
                    $this->m_pembelian->multiSave('tbl_detail_pembelian', $cart);
                    //kosongkan cart
                    $this->cart->destroy();
                    //buat notifikasi penyimpanan berhasil
                    $this->session->set_flashdata('success', 'Data pembelian berhasil diperbarui...');

                    redirect('data_pembelian');
                }
            }
        }
        //cek apakah yang akses adalah admin / user yang menginputkan, jika bukan keduanya maka redirect ke halaman data pembelian
        $fData = $getData->row();

        if ($this->session->userdata('level') != 'admin' && $this->session->userdata('UserID') != $fData->id_user) {
            redirect('data_pembelian');
        }
        //masukkan detail pembelian ke cart
        if (!$this->cart->contents()) {
            $dataCart = [];

            foreach ($getData->result() as $c) {
                $keranjang = array(
                    'id'      => $c->kode_barang,
                    'qty'     => $c->qty,
                    'price'   => $c->harga,
                    'name'    => $c->nama_barang,
                    'satuan'  => $c->satuan_barang,
                    'hpp'  => $c->hpp,
                    'bm'  => $c->bm,
                    'bmt'  => $c->bmt,
                    'pph'  => $c->pph,
                    'ppn'  => $c->ppn
                );

                array_push($dataCart, $keranjang);
            }

            $this->cart->insert($dataCart);
        }

        $data = [
            'title' => 'Edit Data Penerimaan',
            'fdata' => $fData,
            'data' => $this->m_pembelian->getData('tbl_barang', ['active' => 'Y']),
            'supplier' => $this->m_pembelian->getAllData('tbl_supplier'),
            'pabean' => $this->m_pembelian->getData('tbl_pabean', ['jenis_dok' => '1']),
            'table' => $this->read_cart()
        ];

        $this->template->kasir('pembelian/form_edit', $data);
    }

    public function tambah_cart()
    {
        //cek login
        $this->is_login();
        //validasi request ajax
        if ($this->input->is_ajax_request()) {
            //validasi data
            $this->form_validation->set_rules(
                'barangx',
                'Barang',
                'required|min_length[3]|max_length[6]',
                array(
                    'required' => '{field} wajib dipilih',
                    'min_length' => 'Isi {field} tidak valid',
                    'max_length' => 'Isi {field} tidak valid',
                )
            );

            $this->form_validation->set_rules(
                'jumlah',
                'Jumlah',
                "required|min_length[1]|regex_match[/^[0-9.]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            $this->form_validation->set_rules(
                'hpp',
                'HPP',
                "required|min_length[1]|regex_match[/^[0-9]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            $this->form_validation->set_rules(
                'bm',
                'BM',
                "required|min_length[1]|regex_match[/^[0-9]+$/]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka'
                )
            );

            $this->form_validation->set_rules(
                'bmt',
                'BMT',
                "required|min_length[1]|regex_match[/^[0-9]+$/]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                )
            );

            $this->form_validation->set_rules(
                'pph',
                'PPh',
                "required|min_length[1]|regex_match[/^[0-9]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            $this->form_validation->set_rules(
                'ppn',
                'PPN',
                "required|min_length[1]|regex_match[/^[0-9]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            /**
            $this->form_validation->set_rules(
                'harga',
                'Harga Satuan',
                "required|min_length[2]|regex_match[/^[0-9.]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );
             */

            if ($this->form_validation->run() == TRUE) {
                //ambil barang sesuai kode
                $get_barang = $this->m_pembelian->getData('tbl_barang', ['kode_barang' => $this->security->xss_clean($this->input->post('barangx', TRUE)), 'active' => 'Y']);

                if ($get_barang->num_rows() == 1) {
                    //fetch data barang dan masukkan kedalam cart
                    $b = $get_barang->row();

                    $keranjang = array(
                        'id'      => $b->kode_barang,
                        'qty'     => $this->security->xss_clean($this->input->post('jumlah', TRUE)),
                        // 'price'   => $this->security->xss_clean(str_replace('.', '', $this->input->post('harga', TRUE))),
                        'price'   => 0,
                        'name'    => $b->nama_barang,
                        'satuan'  => $b->satuan_barang,
                        'hpp'  => $this->security->xss_clean($this->input->post('hpp', TRUE)),
                        'bm'  => $this->security->xss_clean($this->input->post('bm', TRUE)),
                        'bmt'  => $this->security->xss_clean($this->input->post('bmt', TRUE)),
                        'pph'  => $this->security->xss_clean($this->input->post('pph', TRUE)),
                        'ppn'  => $this->security->xss_clean($this->input->post('ppn', TRUE))
                    );

                    $this->cart->insert($keranjang);

                    $table = $this->read_cart();

                    $alert = '<div class="alert alert-success" role="alert">Data berhasil ditambahkan ke daftar</div>';

                    $arr = array('table' => $table, 'alert' => $alert, 'status' => 'success');

                    echo json_encode($arr);
                } else {
                    $table = $this->read_cart();

                    $alert = '<div class="alert alert-danger" role="alert">Data barang tidak valid</div>';

                    $arr = array('table' => $table, 'alert' => $alert, 'status' => 'gagal');

                    echo json_encode($arr);
                }
            } else {
                $table = $this->read_cart();

                $alert = '<div class="alert alert-danger" role="alert">' . validation_errors('<p class="mb-0 mt-0"><i class="fa fa-caret-right"></i> ', '</p>') . '</div>';

                $arr = array('table' => $table, 'alert' => $alert, 'status' => 'gagal');

                echo json_encode($arr);
            }
        } else {
            redirect('dashboard');
        }
    }

    public function get_item()
    {
        //cek login
        $this->is_login();
        //validasi request ajax
        if ($this->input->is_ajax_request()) {
            //tangkap rowid
            $rowid = $this->security->xss_clean($this->input->post('rowid', TRUE));

            $get_item = $this->cart->get_item($rowid);

            if ($get_item) {
                $arr = [
                    'barang' => $get_item['id'],
                    'qty' => number_format($get_item['qty'], 2),
                    'harga' => number_format($get_item['price'], 0, ',', '.'),
                    'rowid' => '<input type="hidden" id="rowid" value="' . $get_item['rowid'] . '" />',
                    'table' => $this->read_cart(),
                    'status' => 'true',
                    'satuan' => $get_item['satuan'],
                    'hpp' => $get_item['hpp'],
                    'bm' => $get_item['bm'],
                    'bmt' => $get_item['bmt'],
                    'pph' => $get_item['pph'],
                    'ppn' => $get_item['ppn']
                ];
            } else {
                $arr = [
                    'barang' => '',
                    'qty' => '',
                    'harga' => '',
                    'rowid' => '',
                    'table' => $this->read_cart(),
                    'status' => 'false'
                ];
            }

            echo json_encode($arr);
        } else {
            redirect('dashboard');
        }
    }

    public function update_cart()
    {
        //cek login
        $this->is_login();
        //validasi request ajax
        if ($this->input->is_ajax_request()) {
            //validasi data
            $this->form_validation->set_rules(
                'jumlah',
                'Jumlah',
                "required|min_length[1]|regex_match[/^[0-9.]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            $this->form_validation->set_rules(
                'hpp',
                'HPP',
                "required|min_length[1]|regex_match[/^[0-9]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            $this->form_validation->set_rules(
                'bm',
                'BM',
                "required|min_length[1]|regex_match[/^[0-9]+$/]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka'
                )
            );

            $this->form_validation->set_rules(
                'bmt',
                'BMT',
                "required|min_length[1]|regex_match[/^[0-9]+$/]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka'
                )
            );

            $this->form_validation->set_rules(
                'pph',
                'PPh',
                "required|min_length[1]|regex_match[/^[0-9]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            $this->form_validation->set_rules(
                'ppn',
                'PPN',
                "required|min_length[1]|regex_match[/^[0-9]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );

            /**
			$this->form_validation->set_rules(
                'harga',
                'Harga Satuan',
                "required|min_length[2]|regex_match[/^[0-9.]+$/]|greater_than[0]",
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => 'Isi {field} tidak valid',
                    'regex_match' => '{field} hanya boleh angka',
                    'greater_than' => '{field} harus lebih dari nol'
                )
            );
             */

            $this->form_validation->set_rules(
                'rowid',
                'Row ID',
                "required|min_length[10]",
                array(
                    'required' => '{field} tidak valid',
                    'min_length' => 'Isi {field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {

                $keranjang = array(
                    'rowid' => $this->security->xss_clean($this->input->post('rowid', TRUE)),
                    'qty' => $this->security->xss_clean($this->input->post('jumlah', TRUE)),
                    'price' => $this->security->xss_clean(str_replace('.', '', $this->input->post('harga', TRUE))),
                    'hpp' => $this->security->xss_clean($this->input->post('hpp', TRUE)),
                    'bm' => $this->security->xss_clean($this->input->post('bm', TRUE)),
                    'bmt' => $this->security->xss_clean($this->input->post('bmt', TRUE)),
                    'pph' => $this->security->xss_clean($this->input->post('pph', TRUE)),
                    'ppn' => $this->security->xss_clean($this->input->post('ppn', TRUE))
                );

                $this->cart->update($keranjang);

                $table = $this->read_cart();

                $alert = '<div class="alert alert-success" role="alert">Data barang berhasil diubah</div>';

                $arr = array('table' => $table, 'alert' => $alert, 'status' => 'success');

                echo json_encode($arr);
            } else {
                $table = $this->read_cart();

                $alert = '<div class="alert alert-danger" role="alert">' . validation_errors('<p class="mb-0 mt-0"><i class="fa fa-caret-right"></i> ', '</p>') . '</div>';

                $arr = array('table' => $table, 'alert' => $alert, 'status' => 'gagal');

                echo json_encode($arr);
            }
        } else {
            redirect('dashboard');
        }
    }

    public function remove_item()
    {
        //cek login
        $this->is_login();
        //validasi request ajax
        if ($this->input->is_ajax_request()) {
            //validasi
            $this->form_validation->set_rules(
                'rowid',
                'Row ID',
                "required|min_length[10]",
                array(
                    'required' => '{field} tidak valid',
                    'min_length' => 'Isi {field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                //tangkap rowid
                $rowid = $this->security->xss_clean($this->input->post('rowid', TRUE));

                $this->cart->remove($rowid);

                $alert = '<div class="alert alert-success" role="alert">Data barang berhasil dihapus</div>';

                $message = 'success';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">' . validation_errors('<p class="mb-0 mt-0"><i class="fa fa-caret-right"></i> ', '</p>') . '</div>';

                $message = 'failed';
            }

            $table = $this->read_cart();

            $arr = array('table' => $table, 'alert' => $alert, 'message' => $message);

            echo json_encode($arr);
        } else {
            redirect('dashboard');
        }
    }

    function checkDateFormat($date)
    {
        if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/[0-9]{4}$/", $date)) {
            if (checkdate(substr($date, 3, 2), substr($date, 0, 2), substr($date, 6, 4))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function ajax_pembelian()
    {
        $this->is_login();
        //cek apakah request berupa ajax atau bukan, jika bukan maka redirect ke home
        if ($this->input->is_ajax_request()) {
            //ambil list data
            $list = $this->m_pembelian->get_datatables();
            //siapkan variabel array
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $i) {

                $button = '';
                if ($this->session->userdata('level') == 'admin' || $this->session->userdata('UserID') == $i->id_user) :

                    $button .= '<a href="' . site_url('edit_pembelian/' . $i->id_pembelian) . '" class="badge btn-warning btn-sm text-white">Edit</a>
                        <button type="button" class="badge btn-danger btn-sm"onclick="hapus_pembelian(\'' . $i->id_pembelian . '\')">Hapus</button>';

                endif;

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $i->id_pembelian;
                $row[] = $this->tanggal_indo($i->tgl_pembelian);
                $row[] = $i->nomor_aju;
                $row[] = $i->nama_supplier;
                $row[] = $i->jumlah;
                // $row[] = '<span class="pr-3">' . number_format($i->total, 0, ',', '.') . ',-</span>';
                // $row[] = $i->fullname;
                $row[] = '<a href="' . site_url('data_pembelian/' . $i->id_pembelian) . '" class="badge btn-success">Detail</a>
                ' . $button;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_pembelian->count_all(),
                "recordsFiltered" => $this->m_pembelian->count_filtered(),
                "data" => $data
            );
            //output to json format
            echo json_encode($output);
        } else {
            redirect('dashboard');
        }
    }

    private function read_cart()
    {
        if ($this->cart->contents()) {

            $table = '';
            $i = 1;
            foreach ($this->cart->contents() as $c) {
                $table .= '<tr><td>' . $i++ . '</td>';
                $table .= '<td>' . $c['id'] . '</td>';
                $table .= '<td>' . $c['name'] . '</td>';
                $table .= '<td class="text-center">' . number_format($c['qty'], 2) . '</td>';
                $table .= '<td class="text-center">' . $c['satuan'] . '</td>';
                $table .= '<td class="text-center">' . number_format($c['hpp'], 0, ',', '.') . '</td>';
                $table .= '<td class="text-center">' . number_format($c['bm'], 0, ',', '.') . '</td>';
                $table .= '<td class="text-center">' . number_format($c['bmt'], 0, ',', '.') . '</td>';
                $table .= '<td class="text-center">' . number_format($c['pph'], 0, ',', '.') . '</td>';
                $table .= '<td class="text-center">' . number_format($c['ppn'], 0, ',', '.') . '</td>';
                //$table .= '<td class="text-right">' . number_format($c['price'], 0, ',', '.') . '</td>';
                //$table .= '<td class="text-right">' . number_format($c['subtotal'], 0, ',', '.') . '</td>';
                $table .= '<td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm text-white" onclick="get_item(\'' . $c['rowid'] . '\')">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm text-white" onclick="remove_item(\'' . $c['rowid'] . '\')">Hapus</button>
                            </td></tr>';
            }
        } else {
            $table = '<tr>
                        <td scope="col" colspan="6" class="text-center"><i>Belum ada data</i></td>
                    </tr>';
        }

        return $table;
    }

    public function pib()
    {
        //cek login
        $this->is_login();

        $data = [
            'title' => 'Data Pabean PIB'
        ];

        $this->template->kasir('pembelian/pib', $data);
    }

    public function ajax_pib()
    {
        $this->is_login();
        //cek apakah request berupa ajax atau bukan, jika bukan maka redirect ke home
        if ($this->input->is_ajax_request()) {
            //ambil list data
            $list = $this->m_pembelian->get_datatables_pib();
            //siapkan variabel array
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $i) {

                $button = '';
                if ($this->session->userdata('level') == 'admin' || $this->session->userdata('UserID') == $i->id_user) :

                    $button .= '<a href="' . site_url('edit_pib/' . $i->id_pabean) . '" class="btn btn-warning btn-sm text-white">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm"onclick="hapus_pib(\'' . $i->id_pabean . '\')">Hapus</button>';

                endif;

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $i->kode_dok;
                $row[] = $i->nomor_aju;
                $row[] = $i->nomor_daftar;
                $row[] = $this->tanggal_indo($i->tanggal_daftar);
                // $row[] = '<span class="pr-3">' . number_format($i->total, 0, ',', '.') . ',-</span>';
                $row[] = '<a href="' . site_url('data_pib/' . $i->id_pabean) . '" class="btn btn-sm btn-success">Detail</a>
                ' . $button;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_pembelian->count_all_pib(),
                "recordsFiltered" => $this->m_pembelian->count_filtered_pib(),
                "data" => $data
            );
            //output to json format
            echo json_encode($output);
        } else {
            redirect('dashboard');
        }
    }

    public function detail_pib($id = null)
    {
        if ($id == null) {
            redirect('data_pib');
        }

        //cek login
        $this->is_login();
        //ambil data
        $getData = $this->m_pembelian->getDataPib($this->security->xss_clean($id));

        if ($getData->num_rows() < 1) {
            redirect('dashboard');
        }

        $data = [
            'title' => 'Detail Pabean PIB ' . $id,
            'data' => $getData
        ];

        $this->template->kasir('pembelian/detailpib', $data);
    }

    public function tambah_pib()
    {
        $this->is_login();

        //ketika button simpan di klik maka lakukan proses validasi dan penyimpanan data
        if ($this->input->post('submit', TRUE) == 'Submit') {

            //validasi pilih kode dok
            $this->form_validation->set_rules(
                'kodeDok',
                'Kode Dokumen',
                'required',
                array(
                    'required' => '{field} wajib dipilih'
                )
            );

            $this->form_validation->set_rules(
                'noAju',
                'Nomor Aju',
                'required|min_length[26]|max_length[26]|is_unique[tbl_pabean.nomor_aju]',
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} minimal 26 karakter',
                    'max_length' => '{field} maksimal 26 karakter',
                    'is_unique' => 'Nomor aju sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'noDaftar',
                'Nomor Daftar',
                'required|min_length[6]|max_length[6]',
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} minimal 6 karakter',
                    'max_length' => '{field} maksimal 6 karakter'
                )
            );

            /*
            $this->form_validation->set_rules(
                'noAju',
                'Nomor Aju',
                'required|callback_checkDateFormat',
                array(
                    'required' => '{field} wajib diisi',
                    'checkDateFormat' => '{field} tidak valid'
                )
            );
            */

            //jika data sudah valid maka lakukan proses penyimpanan
            if ($this->form_validation->run() == TRUE) {
                //masukkan data ke variable array

                $tgl = date('Y-m-d', strtotime(str_replace('/', '-', $this->security->xss_clean($this->input->post('tanggal', TRUE)))));

                $simpan = array(
                    'kode_dok' => $this->security->xss_clean($this->input->post('kodeDok', TRUE)),
                    'nomor_aju' => $this->security->xss_clean($this->input->post('noAju', TRUE)),
                    'nomor_daftar' => $this->security->xss_clean($this->input->post('noDaftar', TRUE)),
                    'tanggal_daftar' => $tgl,
                    'jenis_dok' => '1'
                );

                //simpan ke database
                $save = $this->m_pembelian->save('tbl_pabean', $simpan);

                if ($save) {
                    $this->session->set_flashdata('success', 'Data Pabean PIB berhasil ditambah...');

                    redirect('data_pib');
                }
            }
        }

        $data = [
            'title' => 'Tambah Data Pabean PIB',
            'data' => $this->m_pembelian->getData('tbl_barang', ['active' => 'Y']),
            'kode_dok' => array('BC20', 'BC40')
        ];

        $this->template->kasir('pembelian/form_input_pib', $data);
    }

    public function update_pib($id = '')
    {
        $this->is_login();

        //cek uri
        if ($id == '') {
            $this->session->set_flashdata('error', 'Data tidak valid...');

            redirect('data_pib');
        }

        //ambil data barang
        $pabean = $this->m_pembelian->getDataPib($id);

        //validasi jumlah data
        if ($pabean->num_rows() !== 1) {
            $this->session->set_flashdata('error', 'Data tidak ada...');

            redirect('data_pib');
        }

        //ketika button diklik
        if ($this->input->post('update', TRUE) == 'Update') {
            //cek apakah user merubah kode barang atau tidak
            $b = $pabean->row();
            if ($b->nomor_aju == $this->security->xss_clean($this->input->post('noAju', TRUE))) {
                $rules_no_aju = 'required|min_length[26]|max_length[26]';
            } else {
                $rules_no_aju = 'required|min_length[26]|max_length[26]|is_unique[tbl_pabean.nomor_aju]';
            }
            //set rules form validasi
            $this->form_validation->set_rules(
                'kodeDok',
                'Kode Dokumen',
                'required',
                array(
                    'required' => '{field} wajib dipilih'
                )
            );

            $this->form_validation->set_rules(
                'noAju',
                'Nomor Aju',
                $rules_no_aju,
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} minimal 26 karakter',
                    'max_length' => '{field} maksimal 26 karakter',
                    'is_unique' => 'Nomor aju sudah terdaftar'
                )
            );

            $this->form_validation->set_rules(
                'noDaftar',
                'Nomor Daftar',
                'required|min_length[6]|max_length[6]',
                array(
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} minimal 6 karakter',
                    'max_length' => '{field} maksimal 6 karakter'
                )
            );

            //jika validasi berhasil
            if ($this->form_validation->run() == TRUE) {
                $tgl = date('Y-m-d', strtotime(str_replace('/', '-', $this->security->xss_clean($this->input->post('tanggal', TRUE)))));

                //masukkan data ke variable array
                $update = array(
                    'kode_dok' => $this->security->xss_clean($this->input->post('kodeDok', TRUE)),
                    'nomor_aju' => $this->security->xss_clean($this->input->post('noAju', TRUE)),
                    'nomor_daftar' => $this->security->xss_clean($this->input->post('noDaftar', TRUE)),
                    'tanggal_daftar' => $tgl
                );

                //simpan ke database
                $up = $this->m_pembelian->update('tbl_pabean', $update, ['id_pabean' => $this->security->xss_clean($this->input->post('id', TRUE))]);

                if ($up) {
                    $this->session->set_flashdata('success', 'Data Pabean PIB berhasil diperbarui...');

                    redirect('data_pib');
                }
            }
        }

        $data = [
            'title' => 'Edit Data Pabean PIB',
            'pabean' => $pabean->row(),
            'kode_dok' => array('BC20', 'BC40')
        ];

        $this->template->kasir('pembelian/form_edit_pib', $data);
    }

    public function hapus_data_pib()
    {
        //cek login
        $this->is_login();
        //validasi request ajax
        if ($this->input->is_ajax_request()) {
            //validasi
            $this->form_validation->set_rules(
                'id',
                'ID Supplier',
                "required",
                array(
                    'required' => '{field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                //tangkap rowid
                $id = $this->security->xss_clean($this->input->post('id', TRUE));

                $hapus = $this->m_pembelian->delete('tbl_pabean', ['id_pabean' => $id]);

                if ($hapus) {
                    echo json_encode(['message' => 'success']);
                } else {
                    echo json_encode(['message' => 'failed']);
                }
            } else {
                echo json_encode(['message' => 'failed']);
            }
        } else {
            redirect('dashboard');
        }
    }

    private function tanggal_indo($tgl)
    {
        $bulan  = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $exp    = explode('-', date('d-m-Y', strtotime($tgl)));

        return $exp[0] . ' ' . $bulan[(int) $exp[1]] . ' ' . $exp[2];
    }

    private function is_login()
    {
        if (!$this->session->userdata('level')) {
            redirect('login');
        }
    }
}
