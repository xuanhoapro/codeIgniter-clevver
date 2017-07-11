<?php

/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 7/10/17
 * Time: 20:14
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{

    public function index()
    {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE) {
            show_error($this->migration->error_string());
        }
    }

}