<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

/**
 * Content controller
 */
class Content extends Admin_Controller
{

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
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/planning/partners') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $partners = $this->partners_model->get_partners();

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $partners['total'];
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->partners_model->limit($limit, $offset);

        $records = $partners['rows'];

        Template::set('records', $records);

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

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->models_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
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
        $pager['total_rows']  = $this->models_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->models_model->limit($limit, $offset);

        $records = $this->models_model->find_all();

        Template::set('records', $records);

        Template::set_block('sub_nav', 'content/_sub_nav_model');

        Template::set('toolbar_title', lang('models_manage'));

        Template::render();
    }

    public function create_model()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_models()) {
                log_activity($this->auth->user_id(), lang('models_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'models');
                Template::set_message(lang('models_create_success'), 'success');

                redirect(SITE_AREA . '/content/models');
            }

            // Not validation error
            if (!empty($this->models_model->error)) {
                Template::set_message(lang('models_create_failure') . $this->models_model->error, 'error');
            }
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

            redirect(SITE_AREA . '/content/sales');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_models('update', $id)) {
                log_activity($this->auth->user_id(), lang('models_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'models');
                Template::set_message(lang('models_edit_success'), 'success');
                redirect(SITE_AREA . '/content/sales/models');
            }

            // Not validation error
            if (!empty($this->models_model->error)) {
                Template::set_message(lang('models_edit_failure') . $this->models_model->error, 'error');
            }
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->models_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('models_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'models');
                Template::set_message(lang('models_delete_success'), 'success');

                redirect(SITE_AREA . '/content/sales/models');
            }

            Template::set_message(lang('models_delete_failure') . $this->models_model->error, 'error');
        }

        Template::set('models', $this->models_model->find($id));

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
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->forecast_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
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
        $pager['total_rows']  = $this->forecast_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->forecast_model->limit($limit, $offset);

        $records = $this->forecast_model->find_all();

        Template::set('records', $records);

        Template::set_block('sub_nav', 'content/_sub_nav_forecast');

        Template::set('toolbar_title', lang('forecast_manage'));

        Template::render();
    }

    public function create_forecast()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_forecast()) {
                log_activity($this->auth->user_id(), lang('forecast_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'forecast');
                Template::set_message(lang('forecast_create_success'), 'success');

                redirect(SITE_AREA . '/content/sales/forecast');
            }

            // Not validation error
            if (!empty($this->forecast_model->error)) {
                Template::set_message(lang('forecast_create_failure') . $this->forecast_model->error, 'error');
            }
        }

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

    public function edit_forecast()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('forecast_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/sales');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_forecast('update', $id)) {
                log_activity($this->auth->user_id(), lang('forecast_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'forecast');
                Template::set_message(lang('forecast_edit_success'), 'success');
                redirect(SITE_AREA . '/content/sales/forecast');
            }

            // Not validation error
            if (!empty($this->forecast_model->error)) {
                Template::set_message(lang('forecast_edit_failure') . $this->forecast_model->error, 'error');
            }
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->forecast_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('forecast_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'forecast');
                Template::set_message(lang('forecast_delete_success'), 'success');

                redirect(SITE_AREA . '/content/sales/forecast');
            }

            Template::set_message(lang('forecast_delete_failure') . $this->forecast_model->error, 'error');
        }

        Template::set('forecast', $this->forecast_model->find($id));

        Template::set('toolbar_title', lang('forecast_edit_heading'));
        Template::render();
    }
}
