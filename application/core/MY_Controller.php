<?php

/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 7/10/17
 * Time: 23:10
 */
class MY_Controller extends CI_Controller
{
    public $pageTitle = '';
    public $template_header = 'layouts/header';
    public $template_footer = 'layouts/footer';

    public function render($view = '', $data = [])
    {
        $data = array_merge($data, array('pageTitle' => ucfirst($this->pageTitle)));

        $this->load->view($this->template_header, $data);
        $this->load->view($view, $data);
        $this->load->view($this->template_footer, $data);
    }
}