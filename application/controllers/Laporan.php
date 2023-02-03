<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        //load library
        $this->load->library(['template', 'form_validation', 'pagination']);
        //load model
        $this->load->model('m_laporan');

        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
    }

    public function index()
    {
        redirect('dashboard');
    }

    public function data_stok_harian($page = 0)
    {
        //cek login
        $this->is_login();

        if ($this->input->post('cari', TRUE) == 'Search') {
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'tanggal',
                'Tanggal',
                'required|callback_checkDateFormat',
                array(
                    'required' => '{field} wajib diisi',
                    'checkDateFormat' => '{field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $tanggal = $this->security->xss_clean($this->input->post('tanggal', TRUE));
                $tanggal2 = $this->security->xss_clean($this->input->post('tanggal2', TRUE));
                $kode_barang = $this->security->xss_clean($this->input->post('kode_barang', TRUE));
                if ($kode_barang) {
                    $filter = ['kode_barang' => $kode_barang];
                }else{
                    $filter = '';
                }
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('stok_harian');
            }
        } else {
            $tanggal = date('d/m/Y');
            $tanggal2 = date('d/m/Y');
            $kode_barang = '';
            $filter = '';
        }

        $config['base_url'] = 'http://localhost:8888/inventory/stok_harian/';
        $config['total_rows'] = 16;
        $config['per_page'] = 4;

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']   = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close']  = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']   = '</span></li>';

        $this->pagination->initialize($config);

        $getData = $this->m_laporan->getDataStokHarian(date('Y-m-d', strtotime(str_replace('/', '-', $tanggal))), date('Y-m-d', strtotime(str_replace('/', '-', $tanggal2))), $filter, $page, $config['per_page']);

        $data = [
            'title' => 'Laporan Mutasi Barang',
            'tanggal' => $tanggal,
            'tanggal2' => $tanggal2,
            'kode_barang' => $kode_barang,
            'barang' => $this->m_laporan->getData('tbl_barang', ['active' => 'Y']),
            'data' => $getData,
            'pager' => $this->pagination->create_links()
        ];

        $this->template->kasir('laporan/stok_harian', $data);
    }

    public function ajax_data_stok_harian()
    {
        //cek login
        $this->is_login();

        $config['base_url'] = 'http://localhost:8888/inventory/stok_harian/';
        $config['total_rows'] = 16;
        $config['per_page'] = 4;
        $config['use_page_numbers'] = TRUE;

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']   = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']   = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close']  = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']   = '</span></li>';

        $this->pagination->initialize($config);

        if ($this->input->post('cari', TRUE) == 'Search') {
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'tanggal',
                'Tanggal',
                'required|callback_checkDateFormat',
                array(
                    'required' => '{field} wajib diisi',
                    'checkDateFormat' => '{field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $tanggal = $this->security->xss_clean($this->input->post('tanggal', TRUE));
                $tanggal2 = $this->security->xss_clean($this->input->post('tanggal2', TRUE));
                $kode_barang = $this->security->xss_clean($this->input->post('kode_barang', TRUE));
                $page = 0;
                if ($kode_barang) {
                    $filter = ['kode_barang' => $kode_barang];
                    $pager = '<span></span>';
                }else{
                    $filter = '';
                    $pager = $this->pagination->create_links();
                }
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('stok_harian');
            }
        } else {
            $tanggal = $this->security->xss_clean($this->input->post('tanggal', TRUE));
            $tanggal2 = $this->security->xss_clean($this->input->post('tanggal2', TRUE));
            $kode_barang = '';
            $filter = '';
            $page = $this->security->xss_clean($this->input->post('pageno', TRUE));
            $pager = $this->pagination->create_links();
        }

        $getData = $this->m_laporan->getDataStokHarian(date('Y-m-d', strtotime(str_replace('/', '-', $tanggal))), date('Y-m-d', strtotime(str_replace('/', '-', $tanggal2))), $filter, $page, 4);

        $table = '';
        $i = $page + 1;
        foreach ($getData->result() as $dt) {
            $penjualanbef = ($dt->qty_penjualan_bef != '') ? $dt->qty_penjualan_bef : 0;
            $pembelianbef = ($dt->qty_pembelian_bef != '') ? $dt->qty_pembelian_bef : 0;

            $penjualanbcur = ($dt->qty_penjualan != '') ? $dt->qty_penjualan : 0;
            $pembelianbcur = ($dt->qty_pembelian != '') ? $dt->qty_pembelian : 0;
            $prosesbcur = ($dt->qty_proses != '') ? $dt->qty_proses : 0;

            $penjualanaf = ($dt->qty_penjualan_new != '') ? $dt->qty_penjualan_new : 0;
            $pembelianaf = ($dt->qty_pembelian_new != '') ? $dt->qty_pembelian_new : 0;
            $prosesaf = ($dt->qty_proses_new != '') ? $dt->qty_proses_new : 0;

            $table .= '<tr><td>' . $i++ . '</td>';
            $table .= '<td>' . $dt->kode_barang . '</td>';
            $table .= '<td>' . $dt->nama_barang . '</td>';
            $table .= '<td>' . $dt->nama_kat_barang . '</td>';
            //$table .= '<td class="text-center">' . ((($dt->stok + $penjualanbef) - $pembelianbef)+$pembelianbef-$pembelianbcur-$pembelianaf-$penjualanbef+$penjualanaf+$penjualanbcur+$prosesbcur+$prosesaf) . '</td>';
            $table .= '<td class="text-center">' . ($dt->stok - $pembelianbcur - $pembelianaf + $penjualanaf + $penjualanbcur + $prosesbcur + $prosesaf) . '</td>';
            $table .= '<td class="text-center">' . $pembelianbcur . '</td>';
            $table .= '<td class="text-center">' . ($penjualanbcur + $prosesbcur) . '</td>';
            $table .= '<td class="text-center">' . (($dt->stok + $penjualanaf + $prosesaf) - $pembelianaf) . '</td>';
            $table .= '</tr>';
        }

        $data = [
            'title' => 'Laporan Harian Stok Barang',
            'tanggal' => $tanggal,
            'tanggal2' => $tanggal2,
            'kode_barang' => $kode_barang,
            'table' => $table,
            'pager' => $pager,
            'pageno' => $page
        ];

        //output to json format
        echo json_encode($data);
    }

    public function cetak_stok_harian($date, $date2, $kode_barang)
    {
        $this->is_login();

        if ($this->cekTanggal($date) == false) {
            redirect('stok_harian');
        }

        $filter = $kode_barang != '' ? ['kode_barang' => $kode_barang] : '';

        $getData = $this->m_laporan->getDataStokHarian($date, $date2, $filter);

        $data = [
            'title' => 'Laporan Harian Stok Barang',
            'tanggal' => $date,
            'data' => $getData
        ];

        $this->template->cetak('cetak/stok_harian', $data);
    }

    public function data_stok_bulanan()
    {
        //cek login
        $this->is_login();

        if ($this->input->post('cari', TRUE) == 'Search') {
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'bulan',
                'Bulan',
                'required|callback_checkBulan',
                array(
                    'required' => '{field} wajib diisi',
                    'checkBulan' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'tahun',
                'Tahun',
                'required|numeric|min_length[4]|max_length[4]|greater_than[2019]',
                array(
                    'required' => '{field} wajib diisi',
                    'numeric' => '{field} tidak valid',
                    'min_length' => '{field} minimal 4 karakter',
                    'max_length' => '{field} maximal 4 karakter',
                    'greater_than' => '{field} harus lebih dari 2019'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $bulan = $this->security->xss_clean($this->input->post('bulan', TRUE));
                $tahun = $this->security->xss_clean($this->input->post('tahun', TRUE));
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('stok_bulanan');
            }
        } else {
            $bulan = $this->convert_bulan_indo(date('m'));
            $tahun = date('Y');
        }

        $getData = $this->m_laporan->getDataStokBulanan($this->convert_bulan($bulan), $tahun);

        $data = [
            'title' => 'Laporan Bulanan Stok Barang',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => $getData
        ];

        $this->template->kasir('laporan/stok_bulanan', $data);
    }

    public function cetak_stok_bulanan($date)
    {
        $this->is_login();
        //explode url
        $exp = explode('-', $date);
        //cek jumlah array
        if (count($exp) != 2) {
            redirect('stok_bulanan');
        }
        //cek nama bulan, apakah valid atau tidak
        if ($this->checkBulan($exp[0]) == false) {
            redirect('stok_bulanan');
        }

        $getData = $this->m_laporan->getDataStokBulanan($this->convert_bulan($exp[0]), $exp[1]);

        $data = [
            'title' => 'Laporan Bulanan Stok Barang',
            'bulan' => $exp[0],
            'tahun' => $exp[1],
            'data' => $getData
        ];

        $this->template->cetak('cetak/stok_bulanan', $data);
    }

    public function data_stok_tahunan()
    {
        //cek login
        $this->is_login();

        if ($this->input->post('cari', TRUE) == 'Search') {

            $this->form_validation->set_rules(
                'tahun',
                'Tahun',
                'required|numeric|min_length[4]|max_length[4]|greater_than[2019]',
                array(
                    'required' => '{field} wajib diisi',
                    'numeric' => '{field} tidak valid',
                    'min_length' => '{field} minimal 4 karakter',
                    'max_length' => '{field} maximal 4 karakter',
                    'greater_than' => '{field} harus lebih dari 2019'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $tahun = $this->security->xss_clean($this->input->post('tahun', TRUE));
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('stok_tahunan');
            }
        } else {
            $tahun = date('Y');
        }

        $getData = $this->m_laporan->getDataStokTahunan($tahun);

        $data = [
            'title' => 'Laporan Tahunan Stok Barang',
            'tahun' => $tahun,
            'data' => $getData
        ];

        $this->template->kasir('laporan/stok_tahunan', $data);
    }

    public function cetak_stok_tahunan($tahun)
    {
        $this->is_login();

        if ($tahun < 2020) {
            redirect('stok_tahunan');
        }

        $getData = $this->m_laporan->getDataStokTahunan($tahun);

        $data = [
            'title' => 'Laporan Tahunan Stok Barang',
            'tahun' => $tahun,
            'data' => $getData
        ];

        $this->template->cetak('cetak/stok_tahunan', $data);
    }

    public function data_pembelian_harian()
    {
        //cek login
        $this->is_login();

        if ($this->input->post('cari', TRUE) == 'Search') {
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'tanggal',
                'Tanggal',
                'required|callback_checkDateFormat',
                array(
                    'required' => '{field} wajib diisi',
                    'checkDateFormat' => '{field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $tanggal = $this->security->xss_clean($this->input->post('tanggal', TRUE));
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('pembelian_harian');
            }
        } else {
            $tanggal = date('d/m/Y');
        }

        $getData = $this->m_laporan->getDataPembelianHarian(date('Y-m-d', strtotime(str_replace('/', '-', $tanggal))));

        $data = [
            'title' => 'Laporan Harian Pembelian Barang',
            'tanggal' => $tanggal,
            'data' => $getData
        ];

        $this->template->kasir('laporan/pembelian_harian', $data);
    }

    public function cetak_pembelian_harian($date)
    {
        $this->is_login();

        if ($this->cekTanggal($date) == false) {
            redirect('pembelian_harian');
        }

        $getData = $this->m_laporan->getDataPembelianHarian($date);

        $data = [
            'title' => 'Laporan Harian Pembelian Barang',
            'tanggal' => $date,
            'data' => $getData
        ];

        $this->template->cetak('cetak/pembelian_harian', $data);
    }

    public function data_pembelian_bulanan()
    {
        //cek login
        $this->is_login();

        if ($this->input->post('cari', TRUE) == 'Search') {
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'bulan',
                'Bulan',
                'required|callback_checkBulan',
                array(
                    'required' => '{field} wajib diisi',
                    'checkBulan' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'tahun',
                'Tahun',
                'required|numeric|min_length[4]|max_length[4]|greater_than[2019]',
                array(
                    'required' => '{field} wajib diisi',
                    'numeric' => '{field} tidak valid',
                    'min_length' => '{field} minimal 4 karakter',
                    'max_length' => '{field} maximal 4 karakter',
                    'greater_than' => '{field} harus lebih dari 2019'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $bulan = $this->security->xss_clean($this->input->post('bulan', TRUE));
                $tahun = $this->security->xss_clean($this->input->post('tahun', TRUE));
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('pembelian_bulanan');
            }
        } else {
            $bulan = $this->convert_bulan_indo(date('m'));
            $tahun = date('Y');
        }

        $getData = $this->m_laporan->getDataPembelianBulanan($this->convert_bulan($bulan), $tahun);

        $data = [
            'title' => 'Laporan Bulanan Pembelian Barang',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => $getData
        ];

        $this->template->kasir('laporan/pembelian_bulanan', $data);
    }

    public function cetak_pembelian_bulanan($date)
    {
        $this->is_login();
        //explode url
        $exp = explode('-', $date);
        //cek jumlah array
        if (count($exp) != 2) {
            redirect('stok_bulanan');
        }
        //cek nama bulan, apakah valid atau tidak
        if ($this->checkBulan($exp[0]) == false) {
            redirect('stok_bulanan');
        }

        $getData = $this->m_laporan->getDataPembelianBulanan($this->convert_bulan($exp[0]), $exp[1]);

        $data = [
            'title' => 'Laporan Bulanan Pembelian Barang',
            'bulan' => $exp[0],
            'tahun' => $exp[1],
            'data' => $getData
        ];

        $this->template->cetak('cetak/pembelian_bulanan', $data);
    }

    public function data_penjualan_harian()
    {
        //cek login
        $this->is_login();

        if ($this->input->post('cari', TRUE) == 'Search') {
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'tanggal',
                'Tanggal',
                'required|callback_checkDateFormat',
                array(
                    'required' => '{field} wajib diisi',
                    'checkDateFormat' => '{field} tidak valid'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $tanggal = $this->security->xss_clean($this->input->post('tanggal', TRUE));
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('penjualan_harian');
            }
        } else {
            $tanggal = date('d/m/Y');
        }

        $getData = $this->m_laporan->getDataPenjualanHarian(date('Y-m-d', strtotime(str_replace('/', '-', $tanggal))));

        $data = [
            'title' => 'Laporan Harian Penjualan Barang',
            'tanggal' => $tanggal,
            'data' => $getData
        ];

        $this->template->kasir('laporan/penjualan_harian', $data);
    }

    public function cetak_penjualan_harian($date)
    {
        $this->is_login();

        if ($this->cekTanggal($date) == false) {
            redirect('pembelian_harian');
        }

        $getData = $this->m_laporan->getDataPenjualanHarian($date);

        $data = [
            'title' => 'Laporan Harian Penjualan Barang',
            'tanggal' => $date,
            'data' => $getData
        ];

        $this->template->cetak('cetak/penjualan_harian', $data);
    }

    public function data_penjualan_bulanan()
    {
        //cek login
        $this->is_login();

        if ($this->input->post('cari', TRUE) == 'Search') {
            //validasi input data tanggal
            $this->form_validation->set_rules(
                'bulan',
                'Bulan',
                'required|callback_checkBulan',
                array(
                    'required' => '{field} wajib diisi',
                    'checkBulan' => '{field} tidak valid'
                )
            );

            $this->form_validation->set_rules(
                'tahun',
                'Tahun',
                'required|numeric|min_length[4]|max_length[4]|greater_than[2019]',
                array(
                    'required' => '{field} wajib diisi',
                    'numeric' => '{field} tidak valid',
                    'min_length' => '{field} minimal 4 karakter',
                    'max_length' => '{field} maximal 4 karakter',
                    'greater_than' => '{field} harus lebih dari 2019'
                )
            );

            if ($this->form_validation->run() == TRUE) {
                $bulan = $this->security->xss_clean($this->input->post('bulan', TRUE));
                $tahun = $this->security->xss_clean($this->input->post('tahun', TRUE));
            } else {
                $this->session->set_flashdata('alert', validation_errors('<p class="my-0">', '</p>'));

                redirect('penjualan_bulanan');
            }
        } else {
            $bulan = $this->convert_bulan_indo(date('m'));
            $tahun = date('Y');
        }

        $getData = $this->m_laporan->getDataPenjualanBulanan($this->convert_bulan($bulan), $tahun);

        $data = [
            'title' => 'Laporan Bulanan Penjualan Barang',
            'bulan' => $bulan,
            'tahun' => $tahun,
            'data' => $getData
        ];

        $this->template->kasir('laporan/penjualan_bulanan', $data);
    }

    public function cetak_penjualan_bulanan($date)
    {
        $this->is_login();
        //explode url
        $exp = explode('-', $date);
        //cek jumlah array
        if (count($exp) != 2) {
            redirect('stok_bulanan');
        }
        //cek nama bulan, apakah valid atau tidak
        if ($this->checkBulan($exp[0]) == false) {
            redirect('stok_bulanan');
        }

        $getData = $this->m_laporan->getDataPenjualanBulanan($this->convert_bulan($exp[0]), $exp[1]);

        $data = [
            'title' => 'Laporan Bulanan Penjualan Barang',
            'bulan' => $exp[0],
            'tahun' => $exp[1],
            'data' => $getData
        ];

        $this->template->cetak('cetak/penjualan_bulanan', $data);
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

    function checkBulan($bulan)
    {
        $array_bulan = array('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember');

        if (in_array(strtolower($bulan), $array_bulan)) {
            return true;
        } else {
            return false;
        }
    }

    private function convert_bulan($bulan)
    {
        $bulan_array = [
            'januari' => '01',
            'februari' => '02',
            'maret' => '03',
            'april' => '04',
            'mei' => '05',
            'juni' => '06',
            'juli' => '07',
            'agustus' => '08',
            'september' => '09',
            'oktober' => '10',
            'november' => '11',
            'desember' => '12'
        ];

        return $bulan_array[strtolower($bulan)];
    }

    private function convert_bulan_indo($bulan)
    {
        $arr = [1 => 'januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'];

        return $arr[(int)$bulan];
    }

    private function cekTanggal($date)
    {
        if (preg_match("/^[0-9]{4}\-(0[1-9]|1[0-2])\-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            if (checkdate(substr($date, 5, 2), substr($date, 8, 2), substr($date, 0, 4))) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function is_login()
    {
        if (!$this->session->userdata('UserID')) {
            redirect('dashboard');
        }
    }
    
    public function cetak_excel($tanggal, $tanggal2, $kode_barang = null)
    {
        if ($kode_barang) {
            $filter = ['kode_barang' => $kode_barang];
        }else{
            $filter = '';
        }

        include APPPATH.'third_party/PHPExcel/PHPExcel.php';

        // $getData = $this->m_laporan->getDataStokHarian(date('Y-m-d', strtotime(str_replace('/', '-', $tanggal))), date('Y-m-d', strtotime(str_replace('/', '-', $tanggal2))), $filter);
        $getData = $this->m_laporan->getDataStokHarian(date('Y-m-d', strtotime(str_replace('/', '-', $tanggal))), date('Y-m-d', strtotime(str_replace('/', '-', $tanggal2))), $filter);

        $excel = new PHPExcel();

        $excel->getProperties()->setCreator('My Notes Code')
                 ->setLastModifiedBy('My Notes Code')
                 ->setTitle("Laporan Mutasi Barang")
                 ->setSubject("Mutasi Barang")
                 ->setDescription("Laporan Mutasi Barang")
                 ->setKeywords("Data Mutasi Barang");

        $style_col = array(
                    'font' => array('bold' => true), // Set font nya jadi bold
                    'alignment' => array(
                                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                                ),
                    'borders' => array(
                                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                                )
                    );
        $style_row = array(
                    'alignment' => array(
                                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                                ),
                    'borders' => array(
                                'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
                                'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
                                'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
                                'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
                                )
                    );
        
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "LAPORAN MUTASI BARANG"); // Set kolom A1 dengan tulisan "LAPORAN MUTASI BARANG"
        $excel->getActiveSheet()->mergeCells('A1:G1'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        $excel->setActiveSheetIndex(0)->setCellValue('A2', "PERIODE ".$this->tanggal_indo($tanggal)." s/d ".$this->tanggal_indo($tanggal2)); // Set kolom A1 dengan tulisan "PERIODE"
        $excel->getActiveSheet()->mergeCells('A2:G2'); // Set Merge Cell pada kolom A1 sampai E1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(TRUE); // Set bold kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
        $excel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1

        // Buat header tabel nya pada baris ke 4
        $excel->setActiveSheetIndex(0)->setCellValue('A4', "NO"); // Set kolom A4 dengan tulisan "NO"
        $excel->setActiveSheetIndex(0)->setCellValue('B4', "KODE BARANG"); // Set kolom B4 dengan tulisan "KODE BARANG"
        $excel->setActiveSheetIndex(0)->setCellValue('C4', "NAMA BARANG"); // Set kolom B4 dengan tulisan "NAMA BARANG"
        $excel->setActiveSheetIndex(0)->setCellValue('D4', "JENIS BARANG"); // Set kolom C4 dengan tulisan "JENIS BARANG"
        $excel->setActiveSheetIndex(0)->setCellValue('E4', "STOK AWAL"); // Set kolom D4 dengan tulisan "STOK AWAL"
        $excel->setActiveSheetIndex(0)->setCellValue('F4', "PEMASUKAN"); // Set kolom E4 dengan tulisan "PEMASUKAN"
        $excel->setActiveSheetIndex(0)->setCellValue('G4', "PENGELUARAN"); // Set kolom F4 dengan tulisan "PENGELUARAN"
        $excel->setActiveSheetIndex(0)->setCellValue('H4', "STOK AKHIR"); // Set kolom G4 dengan tulisan "STOK AKHIR"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G4')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('H4')->applyFromArray($style_col);
        
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($getData->result() as $data){ // Lakukan looping pada variabel siswa

            $penjualanbef = ($data->qty_penjualan_bef != '') ? $data->qty_penjualan_bef : 0;
            $pembelianbef = ($data->qty_pembelian_bef != '') ? $data->qty_pembelian_bef : 0;

            $penjualanbcur = ($data->qty_penjualan != '') ? $data->qty_penjualan : 0;
            $pembelianbcur = ($data->qty_pembelian != '') ? $data->qty_pembelian : 0;

            $penjualanaf = ($data->qty_penjualan_new != '') ? $data->qty_penjualan_new : 0;
            $pembelianaf = ($data->qty_pembelian_new != '') ? $data->qty_pembelian_new : 0;

            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->kode_barang);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->nama_barang);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->nama_kat_barang);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, ((($data->stok + $penjualanbef) - $pembelianbef)+$pembelianbef-$pembelianbcur-$pembelianaf-$penjualanbef+$penjualanaf+$penjualanbcur));
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $pembelianbcur);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $penjualanbcur);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, (($data->stok + $penjualanaf) - $pembelianaf));
            
            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
            $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
            
            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }

        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15); // Set width kolom D
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(13); // Set width kolom E
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(13); // Set width kolom F
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(13); // Set width kolom G
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(13); // Set width kolom H
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Laporan Mutasi Barang");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Laporan Mutasi Barang.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    private function tanggal_indo($tgl)
    {
        $bulan  = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $exp    = explode('-', date('d-m-Y', strtotime($tgl)));

        return $exp[0] . ' ' . $bulan[(int) $exp[1]] . ' ' . $exp[2];
    }
}
