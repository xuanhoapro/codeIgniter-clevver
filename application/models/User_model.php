<?php

/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 7/10/17
 * Time: 20:20
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends MY_Model
{
    public $rules = array(
        'insert' => array(
            'name' => array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required'
            ),
            'email' => array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|required',
                'errors' => array(
                    'required' => 'Error Message rule "required" for field email',
                    'trim' => 'Error message for rule "trim" for field email',
                    'valid_email' => 'Error message for rule "valid_email" for field email'
                )
            )
        ),
        'update' => array(
            'name' => array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required'
            ),
            'email' => array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|required',
                'errors' => array(
                    'required' => 'Error Message rule "required" for field email',
                    'trim' => 'Error message for rule "trim" for field email',
                    'valid_email' => 'Error message for rule "valid_email" for field email'
                )
            ),
            'id' => array(
                'field' => 'id',
                'label' => 'ID',
                'rules' => 'trim|is_natural_no_zero|required'
            )
        ),
    );

    public function __construct()
    {
        $this->table = 'users';
        $this->primary_key = 'id';
        $this->soft_deletes = true;

        parent::__construct();
    }
}
