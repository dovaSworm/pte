<?php
class Products extends CI_Controller
{
    public function index($offset = 0)
    {
//pagination config
        $this->load->library('pagination');

        $config['base_url'] = base_url() . 'products/index';
        $config['total_rows'] = $this->db->count_all('product');
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        $config['num_links'] = 2;
        $config['first_link'] = "Prva";
        $config['last_link'] = false;
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Sledeća';
        $config['next_tag_open'] = '<li><i class="fa fa-long-arrow-right"></i>';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = 'Predhodna';
        $config['prev_tag_open'] = '<li><i class="fa fa-long-arrow-left"></i>';
        $config['prev_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'pagination-links');
// init pagination
        

        $naslov['title'] = 'Sistemi za PCB montažu,lemilice, antistatik, video mikroskopi, roboti';
        if (isset($_GET['category_id'])) {
            $data['products'] = $this->product_model->get_product_by_category($_GET['category_id']);
            if (empty($data['products'])) {
                show_error('Ne postoje traženi artikli', 404, $heading = 'Greška');
            }
        } elseif (isset($_GET['subcategory'])) {

            $data['products'] = $this->product_model->get_product_by_subcategory($_GET['subcategory']);
            if (empty($data['products'])) {
                show_error('Ne postoje traženi artikli', 404, $heading = 'Greška');
            }
        } else {
            $data['products'] = $this->product_model->get_products(FALSE, $config['per_page'], $offset);
            if (empty($data['products'])) {
                show_error('Ne postoje traženi artikli', 404, $heading = 'Greška');
            }else if($data['products'] > 10){
                $this->pagination->initialize($config);
            }
        }
        $this->load->view('templates/header', $naslov);
        $this->load->view('templates/menu');
        $this->load->view('products/index', $data);
        $this->load->view('templates/partneri');
        $this->load->view('templates/footer');
    }

    public function view($slug = null)
    {
        $naslov['title'] = 'Sistemi za PCB montažu,lemilice, antistatik, video mikroskopi, roboti';
        $data['product'] = $this->product_model->get_products($slug);

        if (empty($data['product'])) {
            show_404();
        }
        $data['title'] = $data['product']['title'];

        $this->load->view('templates/header', $naslov);
        $this->load->view('templates/menu');
        $this->load->view('products/view', $data);
        $this->load->view('templates/partneri');
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $naslov['title'] = 'Sistemi za PCB montažu,lemilice, antistatik, video mikroskopi, roboti';
        $data['title'] = "Unesi novi proizvod";

        $data['categories'] = $this->product_model->get_categories();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('proizvodjac', 'Proizvodjac', 'required');
        $this->form_validation->set_rules('karakteristike', 'Karakteristike', 'required');

        if ($this->form_validation->run() === false) {
            $this->load->view('templates/header', $naslov);
            $this->load->view('products/create', $data);
            $this->load->view('templates/footer');

        } else {
            //upload image
            $config['upload_path'] = './assets/img/productimg';
            $config['allowed_types'] = 'gif|jpg|png|PNG|JPG|GIF';
            $config['max_size'] = '2048';
            $config['max_width'] = '700';
            $config['max_height'] = '700';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $errors = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $product_image = $_FILES['userfile']['name'];
            }
            $this->product_model->create_product($product_image);

            $this->session->set_flashdata('product_created', 'Proizvod uspesno dodan u bazu');
            redirect('products');
        }
    }

    public function delete($id)
    {
        $this->product_model->delete_product($id);
        $this->session->set_flashdata('product_deleted', 'Proizvod uspesno obrisan');
        redirect('products');
    }

    public function edit($slug)
    {
        $naslov['title'] = 'Edit';
        $data['product'] = $this->product_model->get_products($slug);
        $data['categories'] = $this->product_model->get_categories();

        if (empty($data['product'])) {
            show_404();
        }
        $data['title'] = $data['product']['title'];

        $this->load->view('templates/header', $naslov);
        $this->load->view('products/edit', $data);
        $this->load->view('templates/footer');
    }

    public function update()
    {

        $config['upload_path'] = './assets/img/productimg';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
        $config['max_width'] = '700';
        $config['max_height'] = '700';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $errors = array('error' => $this->upload->display_errors());
            $product_image = 'noimage.jpg';
        } else {
            $data = array('upload_data' => $this->upload->data());
            $product_image = $_FILES['userfile']['name'];
        }
        $this->product_model->update_product($product_image);
        $this->session->set_flashdata('product_updated', 'Proizvod uspesno izmenjen');
        redirect('products');
    }
}
