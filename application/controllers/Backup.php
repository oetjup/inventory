<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {
	public function index() {
		$this->load->dbutil();
		$this->load->helper('file');
		
		$config = array(
			'format'	=> 'zip',
			'filename'	=> 'database.sql'
		);
		
		$backup =& $this->dbutil->backup($config);
		
		// $save = FCPATH.'data/backup-'.date("ymdHis").'-db.zip';
		
		// write_file($save, $backup);

        $this->load->helper('download');
        $db_name = 'backup-'.date("ymdHis").'-db.zip';
        force_download($db_name, $backup);
	}
}