<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

/**
 * Content controller
 */
class Content extends Admin_Controller
{

    private $_client;
    
    protected $permissionCreate = 'Sales.Content.Create';
    protected $permissionDelete = 'Sales.Content.Delete';
    protected $permissionEdit = 'Sales.Content.Edit';
    protected $permissionView = 'Sales.Content.View';

    /**
     * Constructor
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();

        $this->_client = new Client([
            'base_uri' => 'http://localhost/api/',
            'auth' => ['admin', '1234']
        ]);

        $this->load->helper('form');

        $this->load->model(array('sales/sales_model', 'sales/models_model', 'sales/forecast_model', 'sales/partners_model'));

        $this->auth->restrict($this->permissionView);
        $this->lang->load(array('sales', 'models', 'forecast', 'partners'));

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

        Template::set_block('sub_nav', 'content/_sub_nav');

        Assets::add_js(array(
            'easyui/jquery.easyui.min.js'
        ));
        Assets::add_module_js('sales', 'sales.js');
        Assets::add_css(array(
            'easyui/themes/default/easyui.css',
            'easyui/themes/icon.css',
            'easyui/themes/color.css'
        ));
        Assets::add_module_css('sales', 'sales.css');
    }

    /**
     * Display a list of Business Partners data.
     *
     * @return void
     */
    public function partners($offset = 0)
    {
        $client = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234',
            ]
        ]);
        $partners = json_decode($client->getBody()->getContents(), true);

        Template::set("records",$partners["rows"]);

        Template::set_block('sub_nav', 'content/_sub_nav_partner');

        Template::set('toolbar_title', lang('partners_manage'));

        Template::render();
    }

    public function models($offset = 0)
    {
        // Deleting anything?
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                // $result = true;
                // foreach ($checked as $pid) {
                //     $deleted = $this->models_model->delete($pid);
                //     if ($deleted == false) {
                //         $result = false;
                //     }
                // }
                // if ($result) {
                //     Template::set_message(count($checked) . ' ' . lang('models_delete_success'), 'success');
                // } else {
                //     Template::set_message(lang('models_delete_failure') . $this->models_model->error, 'error');
                // }

                
                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->_client->request('DELETE', 'sales/models', [
                        'form_params' => [
                            'X-API-KEY' => '1234',
                            'id' => $pid,
                            'user_id' => $this->session->userdata("user_id")
                        ]
                    ]);
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('models_delete_success'), 'success');
                } else {
                    Template::set_message(lang('models_delete_failure') . $this->models_model->error, 'error');
                }
            }
        }

        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/sales/models') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $total_rows = $this->_client->request('GET', 'sales/modelsCountAll', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);
        $pager['total_rows'] = json_decode($total_rows->getBody()->getContents(), true);
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);

        $response = $this->_client->request('GET', 'sales/models', [
            'query' => [
                'X-API-KEY' => '1234',
                'offset' => $offset,
                'limit' => $limit
            ]
        ]);

        $records = json_decode($response->getBody()->getContents(), true);

        Template::set('records', $records["rows"]);

        Template::set_block('sub_nav', 'content/_sub_nav_model');

        Template::set('toolbar_title', lang('models_manage'));

        Template::render();
    }

    public function create_model()
    {
        $this->auth->restrict($this->permissionCreate);
        if (isset($_POST['save'])) {
            $response = $this->_client->request('POST', 'sales/models', [
                'form_params' => [
                    "X-API-KEY" => "1234",
                    "name" => $this->input->post("desc"),
                    "created_by" => $this->session->userdata("user_id"),
                ]
            ]);
            log_activity($this->auth->user_id(), lang('models_act_create_record') . $this->input->ip_address(), 'models');

            Template::set_message(lang('models_create_success'), 'success');
            redirect(SITE_AREA . '/content/sales/models');
        }

        Template::set('toolbar_title', lang('models_action_create'));

        Template::set_block('sub_nav', 'content/_sub_nav_model');

        Template::render();
    }

    public function edit_model()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('models_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/sales/models');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);
            $response = $this->_client->request('PUT', 'sales/models', [
                'form_params' => [
                    "X-API-KEY" => "1234",
                    "id" => $id,
                    "name" => $this->input->post("desc"),
                    "modified_by" => $this->session->userdata("user_id"),
                ]
            ]);
            log_activity($this->auth->user_id(), lang('models_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'models');
            Template::set_message('models updated', 'success');
            redirect(SITE_AREA . '/content/sales/models');
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->models_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('models_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'models');
                Template::set_message(lang('models_delete_success'), 'success');

                redirect(SITE_AREA . '/content/sales/models');
            }

            Template::set_message(lang('models_delete_failure') . $this->models_model->error, 'error');
        }

        $response = $this->_client->request('GET', 'sales/models', [
            'query' => [
                'X-API-KEY' => '1234',
                'id' => $id
            ]
        ]);

        $record = json_decode($response->getBody()->getContents(), true);

        Template::set('models', $record);

        Template::set_block('sub_nav', 'content/_sub_nav_model');

        Template::set('toolbar_title', lang('models_edit_heading'));
        Template::render();
    }

    private function save_models($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->models_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->models_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method


        $return = false;
        if ($type == 'insert') {
            $id = $this->models_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->models_model->update($id, $data);
        }

        return $return;
    }

    public function forecast($offset = 0)
    {

        // Deleting anything?
        if (isset($_POST['delete'])) 
        {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) 
            {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                $user_id = $this->session->userdata("user_id");
                foreach ($checked as $pid) {

                    //ini skrip aslinya $deleted = $this->forecast_model->delete($pid);
                    // ini skrip buatan arif
                    $deleted = $this->_client->request('DELETE', 'sales/forecasts', [
                        // 'query' => [
                        // ],
                        'form_params' => [
                            'X-API-KEY' => '1234',
                            'id' => $pid,
                            'user_id' => $user_id
                        ]
                    ]);
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('forecast_delete_success'), 'success');
                } else {
                    Template::set_message(lang('forecast_delete_failure') . $this->forecast_model->error, 'error');
                }
            }
        }

        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/sales/forecast') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $total_rows = $this->_client->request('GET', 'sales/forecastsCountAll', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);
        $pager['total_rows'] = json_decode($total_rows->getBody()->getContents(), true);
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        // $this->forecast_model->limit($limit, $offset);

        // $records = $this->forecast_model->find_all();
        // $records = $this->sales_model->find_all_forecasts($limit, $offset);
        $response = $this->_client->request('GET', 'sales/forecasts', [
            'query' => [
                'X-API-KEY' => '1234',
                'offset' => $offset,
                'limit' => $limit
            ]
        ]);

        $records = json_decode($response->getBody()->getContents(), true);


        $client = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234',
                'id' => "SLIS001",
            ]

        ]);

        $all_record = array();

        foreach ($records as $key => $record)
        {
            $client_id = $record["bp_id"];
            $client = $this->_client->request('GET', 'sales/partners', [
                'query' => [
                    'X-API-KEY' => '1234',
                    'id' => $client_id,
                ]

            ]);
            $client = json_decode($client->getBody()->getContents(), true);
            $client = $client[0];
            $all_record[] = array_merge($record,$client);
        }

        Template::set('records', $all_record);
        // // Template::set('records', $records['rows']);

        Template::set_block('sub_nav', 'content/_sub_nav_forecast');

        Template::set('toolbar_title', lang('forecast_manage'));

        Template::render();

    }

    public function create_forecast()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            $response = $this->_client->request('POST', 'sales/forecasts', [
                'form_params' => [
                    "X-API-KEY" => "1234",
                    "bp_id" => $this->input->post("bp_id"),
                    "model_id" => $this->input->post("model_id"),
                    "item_id" => $this->input->post("item_id"),
                    "cust_part" => $this->input->post("cust_part"),
                    "fy" => $this->input->post("fy"),
                    "period" => $this->input->post("period"),
                    "sales_qty" => $this->input->post("sales_qty"),
                    "user_id" => $this->session->userdata("user_id"),
                ]
            ]);

            Template::set_message(lang('forecast_create_success'), 'success');
            redirect(SITE_AREA . '/content/sales/forecast');
        }

        $client = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234',
            ]

        ]);
        $partners = json_decode($client->getBody()->getContents(), true);

        $client = $this->_client->request('GET', 'sales/models', [
            'query' => [
                'X-API-KEY' => '1234',
            ]

        ]);
        $models = json_decode($client->getBody()->getContents(), true);

        $client = $this->_client->request('GET', 'items/details', [
            'query' => [
                'X-API-KEY' => '1234',
            ]
        ]);
        $items = json_decode($client->getBody()->getContents(), true);


        Template::set('partners', $partners);
        Template::set('models', $models);
        Template::set('items', $items);

        Template::set_block('sub_nav', 'content/_sub_nav_forecast');

        Template::set('toolbar_title', lang('forecast_action_create'));

        Template::render();
    }

    private function save_forecast($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->forecast_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->forecast_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method


        $return = false;
        if ($type == 'insert') {
            $id = $this->forecast_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->forecast_model->update($id, $data);
        }

        return $return;
    }

    public function edit_forecast($id)
    {
        
        if (empty($id)) {
            Template::set_message(lang('forecast_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/sales/forecast');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            $response = $this->_client->request('PUT', 'sales/forecasts', [
                'form_params' => [
                    "X-API-KEY" => "1234",
                    "id" => $id,
                    "bp_id" => $this->input->post("bp_id"),
                    "model_id" => $this->input->post("model_id"),
                    "item_id" => $this->input->post("item_id"),
                    "cust_part" => $this->input->post("cust_part"),
                    "fy" => $this->input->post("fy"),
                    "period" => $this->input->post("period"),
                    "sales_qty" => $this->input->post("sales_qty"),
                    "user_id" => $this->session->userdata("user_id"),
                ]
            ]);
            Template::set_message('forecast updated', 'success');
            redirect(SITE_AREA . '/content/sales/forecast');
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->forecast_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('forecast_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'forecast');
                Template::set_message(lang('forecast_delete_success'), 'success');

                redirect(SITE_AREA . '/content/sales/forecast');
            }

            Template::set_message(lang('forecast_delete_failure') . $this->forecast_model->error, 'error');
        }

        $forecast = $this->_client->request('GET', 'sales/forecasts', [
            'query' => [
                'X-API-KEY' => '1234',
                'id' => $id
            ]
        ]);
        $forecast = json_decode($forecast->getBody()->getContents(), true);
        $client = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234',
            ]

        ]);
        $partners = json_decode($client->getBody()->getContents(), true);

        $client = $this->_client->request('GET', 'sales/models', [
            'query' => [
                'X-API-KEY' => '1234',
            ]

        ]);
        $models = json_decode($client->getBody()->getContents(), true);

        $client = $this->_client->request('GET', 'items/details', [
            'query' => [
                'X-API-KEY' => '1234',
            ]
        ]);
        $items = json_decode($client->getBody()->getContents(), true);


        Template::set('forecast', $forecast);
        Template::set('partners', $partners);
        Template::set('models', $models);
        Template::set('items', $items);
        Template::set('toolbar_title', lang('forecast_edit_heading'));
        Template::render();
    }
}
