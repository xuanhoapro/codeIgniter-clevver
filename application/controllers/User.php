<?php

/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 7/10/17
 * Time: 23:02
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller
{
    public function index()
    {
        $itemPerPage = 5;
        $this->load->model('user_model');
        $request = $this->input->get();
        $page = isset($request['page']) ? $request['page'] : 1;
        $total_user = $this->user_model->count_rows();
        $data['data'] = $this->user_model->as_array()->paginate($itemPerPage, $total_user, $page);
        $data['itemPerPage'] = $itemPerPage;

        if ($this->input->is_ajax_request()) { // check ajax request
            $dataResponse = [
                'draw' => $request['draw'],
                'recordsTotal' => $total_user,
                'recordsFiltered' => $total_user,
                'data' => $data['data']
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($dataResponse));

        } else {
            $this->pageTitle = 'List user';
            $this->render('user/index', $data);
        }
    }

    public function store()
    {
        $this->pageTitle = 'Create user';
        $dataResponse['hasError'] = 0;
        $request = $this->input->post();

        if ($this->input->is_ajax_request()) {

            $this->load->model('user_model');
            $userModel = $this->user_model->from_form();
            $errorsForm = $this->form_validation->error_array();
            if ($errorsForm) {
                $dataResponse['hasError'] = 1;
                $dataResponse['errors'] = $errorsForm;
            } else {
                $dataResponse['user_id'] = $userModel->insert();
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($dataResponse));

        } else {
            $this->render('user/create');
        }
    }

    public function update($id)
    {
        $dataResponse['hasError'] = 0;
        $this->load->model('user_model');
        $userObj = $this->user_model->get($id);
        if(!$userObj){
            show_404();
        }

        $this->pageTitle = 'Update user - ' . $userObj->name;
        $data = array(
            'userObj' => $userObj
        );

        if ($this->input->is_ajax_request()) {
            $userModel = $this->user_model->from_form();
            $errorsForm = $this->form_validation->error_array();
            if ($errorsForm) {
                $dataResponse['hasError'] = 1;
                $dataResponse['errors'] = $errorsForm;
            } else {
                $dataResponse['user_id'] = $userModel->update(null, $userObj->id);
                $dataResponse['msg'] = 'User updated successfull.';
            }
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($dataResponse));
        } else {
            $this->render('user/update', $data);
        }
    }

    public function destroy()
    {
        $request = $this->input->post();

        if ($this->input->is_ajax_request()) {
            $this->load->model('user_model');
            $this->user_model->delete($request['id']);
            $dataResponse['hasError'] = 0;
            $dataResponse['msg'] = 'User deleted successfull.';
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($dataResponse));
        }
    }

}