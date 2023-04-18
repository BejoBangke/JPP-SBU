<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page_photo_produk extends CI_Controller 
{
	function __construct() 
	{
        parent::__construct();
        $this->load->model('admin/Model_common');
        $this->load->model('admin/Model_page_photo_produk');
    }

    public function index()
	{
		$error = '';
		$success = '';

		$data['setting'] = $this->Model_common->get_setting_data();
		$data['page_photo_produk'] = $this->Model_page_photo_produk->show();

		$this->load->view('admin/view_header',$data);
		$this->load->view('admin/view_page_photo_produk',$data);
		$this->load->view('admin/view_footer');
		
	}

	public function edit($id)
	{
		
    	$tot = $this->Model_page_photo_produk->page_photo_produk_check($id);
    	if(!$tot) {
    		redirect(base_url().'admin/page-photo-produk');
        	exit;
    	}
       	
       	$data['setting'] = $this->Model_common->get_setting_data();
		$error = '';
		$success = '';


		if(isset($_POST['form1'])) 
		{

			if(PROJECT_MODE == 0) {
				$this->session->set_flashdata('error',PROJECT_NOTIFICATION);
				redirect($_SERVER['HTTP_REFERER']);
			}

			$valid = 1;

			$photo_produk_heading = $this->input->post('photo_produk_heading', true);
			$mt_photo_produk = $this->input->post('mt_photo_produk', true);
			$mk_photo_produk = $this->input->post('mk_photo_produk', true);
			$md_photo_produk = $this->input->post('md_photo_produk', true);

			$this->form_validation->set_rules('photo_produk_heading', 'Heading', 'trim|required');

			if($this->form_validation->run() == FALSE) {
				$valid = 0;
                $error .= validation_errors();
            }

		    if($valid == 1) 
		    {
	    		$form_data = array(
					'photo_produk_heading' => $photo_produk_heading,
					'mt_photo_produk' => $mt_photo_produk,
					'mk_photo_produk' => $mk_photo_produk,
					'md_photo_produk' => $md_photo_produk
	            );
	            $this->Model_page_photo_produk->update($id,$form_data);				
				
				$success = 'Photo produk Page information is updated successfully';
				$this->session->set_flashdata('success',$success);
				redirect(base_url().'admin/page-photo-produk');
		    }
		    else
		    {
		    	$this->session->set_flashdata('error',$error);
				redirect(base_url().'admin/page-photo-produk/edit'.$id);
		    }
           
		} else {
			$data['page_photo_produk'] = $this->Model_page_photo_produk->get_page_photo_produk($id);
	       	$this->load->view('admin/view_header',$data);
			$this->load->view('admin/view_page_photo_produk_edit',$data);
			$this->load->view('admin/view_footer');
		}

	}
	
}
