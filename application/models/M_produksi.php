<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_produksi extends CI_Model
{

    var $select = array('p.id_produksi AS id_produksi', 'no_produksi', 'tgl_produksi', 'count(id_barang) AS jumlah', 'p.id_user AS id_user', 'fullname'); //data yang akan diambil

    var $table           = 'tbl_produksi p
                            JOIN tbl_detail_produksi dp ON(p.id_produksi = dp.id_produksi)
                            JOIN tbl_user u ON(p.id_user = u.id_user)';

    var $column_order    =  array(null, 'p.id_produksi', 'no_produksi', 'tgl_produksi', 'jumlah', 'fullname', null); //set column field database untuk datatable order
    var $column_search   =  array('p.id_produksi', 'no_produksi', 'tgl_produksi', 'fullname'); //set column field database untuk datatable search
    var $order = array('p.id_produksi' => 'asc'); // default order

    var $selectpib = 'id_pabean, kode_dok, nomor_aju, nomor_daftar, tanggal_daftar';
    var $tablepib = 'tbl_pabean';
    var $column_order_pib    =  array(null, 'id_pabean', 'kode_dok', 'nomor_aju', 'nomor_daftar', 'tanggal_daftar', null); //set column field database untuk datatable order
    var $column_search_pib   =  array('id_pabean', 'kode_dok', 'nomor_aju', 'nomor_daftar'); //set column field database untuk datatable search
    var $order_pib = array('id_pabean' => 'asc'); // default order

    function __construct()
    {
        parent::__construct();
    }

    function getAllData($table = null)
    {
        return $this->db->get($table);
    }

    function getData($table = null, $where = null)
    {
        $this->db->from($table);
        $this->db->where($where);

        return $this->db->get();
    }

    function getDataProduksiProses($id)
    {
        $select = 'p.id_produksi AS id_produksi, p.no_produksi AS no_produksi, tgl_produksi, dp.qty AS qty, kode_barang, nama_barang, brand, fullname, u.id_user AS id_user';

        $table = 'tbl_produksi p
                    LEFT JOIN tbl_detail_produksi dp ON(p.id_produksi = dp.id_produksi)
                    LEFT JOIN tbl_barang b ON(dp.id_barang = b.kode_barang)
                    LEFT JOIN tbl_user u ON(p.id_user = u.id_user)';

        $where = array('p.id_produksi' => $id);

        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);

        return $this->db->get();
    }

    function save($table = null, $data = null)
    {
        return $this->db->insert($table, $data);
    }

    function multiSave($table = null, $data = array())
    {
        $jumlah = count($data);

        if ($jumlah > 0) {
            $this->db->insert_batch($table, $data);
        }
    }

    function update($table = null, $data = null, $where = null)
    {
        return $this->db->update($table, $data, $where);
    }

    function delete($table = null, $where = null)
    {
        $this->db->where($where);
        $this->db->delete($table);

        return $this->db->affected_rows();
    }

    private function _get_datatables_query()
    {

        $this->db->select($this->select);
        $this->db->from($this->table);
        $this->db->group_by(array('p.id_produksi', 'tgl_produksi', 'p.id_user', 'fullname'));

        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if ($_POST['search']['value']) // Jika datatable mengirim POST untuk search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket.

                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) { //last loop
                    $this->db->group_end(); //close bracket
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) // Proses order
        {

            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {

            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();

            return $query->result();
        }
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    function count_all()
    {
        $this->db->select($this->select);
        $this->db->from($this->table);
        $this->db->group_by(array('p.id_produksi', 'tgl_produksi', 'p.id_user'));

        return $this->db->count_all_results();
    }

    private function _get_datatables_query_pib()
    {
        $this->db->select($this->selectpib);
        $this->db->from($this->tablepib);
        $this->db->where('jenis_dok', '1');

        $i = 0;

        foreach ($this->column_search_pib as $item) // loop column
        {
            if ($_POST['search']['value']) // Jika datatable mengirim POST untuk search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket.

                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search_pib) - 1 == $i) { //last loop
                    $this->db->group_end(); //close bracket
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) // Proses order
        {

            $this->db->order_by($this->column_order_pib[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_pib)) {

            $order = $this->order_pib;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_pib()
    {
        $this->_get_datatables_query_pib();

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
            $query = $this->db->get();

            return $query->result();
        }
    }

    function count_all_pib()
    {
        $this->db->select($this->selectpib);
        $this->db->from($this->tablepib);

        return $this->db->count_all_results();
    }

    function getDataPib($id)
    {
        $where = array('id_pabean' => $id, 'jenis_dok' => '1');

        $this->db->select($this->selectpib);
        $this->db->from($this->tablepib);
        $this->db->where($where);

        return $this->db->get();
    }

    function count_filtered_pib()
    {
        $this->_get_datatables_query_pib();
        $query = $this->db->get();

        return $query->num_rows();
    }
}
