<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

/**
 * Content controller
 */
class Content extends Admin_Controller
{

    protected $permissionCreate = 'Planning.Content.Create';
    protected $permissionDelete = 'Planning.Content.Delete';
    protected $permissionEdit = 'Planning.Content.Edit';
    protected $permissionView = 'Planning.Content.View';

    private $_client;

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
            'auth' => ['admin', '1234'],
            'query' => ['X-API-KEY' => '1234']
        ]);

        $this->load->model(array('planning/planning_model', 'planning/items_model', 'planning/calendar_model', 'planning/psi_model', 'planning/tpp_model'));

        $this->auth->restrict($this->permissionView);
        $this->lang->load(array('planning', 'items', 'calendar', 'psi', 'tpp'));

        $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");

        Assets::add_js(array(
            'jquery-ui-1.8.13.min.js'
        ));
        Assets::add_module_js('planning', 'planning.js');
        Assets::add_module_js('planning', 'calendar.js');
        Assets::add_css(array(
            'flick/jquery-ui-1.8.13.custom.css'
        ));
        Assets::add_module_css('planning', 'planning.css');
    }

    public function calendar($offset = 0)
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
                    $deleted = $this->calendar_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('calendar_delete_success'), 'success');
                } else {
                    Template::set_message(lang('calendar_delete_failure') . $this->calendar_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/planning/calendar') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->calendar_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->calendar_model->limit($limit, $offset);

        $records = $this->calendar_model->find_all();

        Template::set('records', $records);

        Template::set_block('sub_nav', 'content/_sub_nav_calendar');

        Template::set('toolbar_title', lang('calendar_manage'));

        Template::render();
    }

    public function create_calendar()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_calendar()) {
                log_activity($this->auth->user_id(), lang('calendar_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'calendar');
                Template::set_message(lang('calendar_create_success'), 'success');

                redirect(SITE_AREA . '/content/planning/calendar');
            }

            // Not validation error
            if (!empty($this->calendar_model->error)) {
                Template::set_message(lang('calendar_create_failure') . $this->calendar_model->error, 'error');
            }
        }

        Template::set_block('sub_nav', 'content/_sub_nav_calendar');

        Template::set('toolbar_title', lang('calendar_action_create'));

        Template::render();
    }

    public function edit_calendar()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('calendar_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/planning/calendar');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_calendar('update', $id)) {
                log_activity($this->auth->user_id(), lang('calendar_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'calendar');
                Template::set_message(lang('calendar_edit_success'), 'success');
                redirect(SITE_AREA . '/content/planning/calendar');
            }

            // Not validation error
            if (!empty($this->calendar_model->error)) {
                Template::set_message(lang('calendar_edit_failure') . $this->calendar_model->error, 'error');
            }
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->calendar_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('calendar_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'calendar');
                Template::set_message(lang('calendar_delete_success'), 'success');

                redirect(SITE_AREA . '/content/planning/calendar');
            }

            Template::set_message(lang('calendar_delete_failure') . $this->calendar_model->error, 'error');
        }

        Template::set('calendar', $this->calendar_model->find($id));

        Template::set_block('sub_nav', 'content/_sub_nav_calendar');

        Template::set('toolbar_title', lang('calendar_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_calendar($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['db_date'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->calendar_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->calendar_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method

        $data['db_date']    = $this->input->post('db_date') ? $this->input->post('db_date') : '0000-00-00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->calendar_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->calendar_model->update($id, $data);
        }

        return $return;
    }

    /**
     * Display a list of Items data.
     * 
     * @return void
     */
    public function items($offset = 0)
    {
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/planning/items') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $items = $this->items_model->get_items();

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $items['total'];
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);

        $records = $items['rows'];

        Template::set('records', $records);

        Template::set_block('sub_nav', 'content/_sub_nav_item');

        Template::set('toolbar_title', lang('items_manage'));

        Template::render();
    }

    public function getItems()
    {
        $result = $this->planning_model->getItems();
        return json_encode($result);
    }

    /**
     * Display a list of PSI data.
     *
     * @return void
     */
    public function psi($offset = 0)
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
                    $deleted = $this->psi_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('psi_delete_success'), 'success');
                } else {
                    Template::set_message(lang('psi_delete_failure') . $this->psi_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/planning/psi') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->psi_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->psi_model->limit($limit, $offset);

        $records = $this->psi_model->find_all();

        Template::set('records', $records);

        Template::set_block('sub_nav', 'content/_sub_nav_psi');

        Template::set('toolbar_title', lang('psi_manage'));

        Template::render();
    }

    /**
     * Create a PSI object.
     *
     * @return void
     */
    public function create_psi()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_psi()) {
                log_activity($this->auth->user_id(), lang('psi_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'psi');
                Template::set_message(lang('psi_create_success'), 'success');

                redirect(SITE_AREA . '/content/planning/psi');
            }

            // Not validation error
            if (!empty($this->psi_model->error)) {
                Template::set_message(lang('psi_create_failure') . $this->psi_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('psi_action_create'));

        Template::set_block('sub_nav', 'content/_sub_nav_psi');

        Template::render();
    }
    /**
     * Allows editing of PSI data.
     *
     * @return void
     */
    public function edit_psi()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('psi_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/planning/psi');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_psi('update', $id)) {
                log_activity($this->auth->user_id(), lang('psi_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'psi');
                Template::set_message(lang('psi_edit_success'), 'success');
                redirect(SITE_AREA . '/content/planning/psi');
            }

            // Not validation error
            if (!empty($this->psi_model->error)) {
                Template::set_message(lang('psi_edit_failure') . $this->psi_model->error, 'error');
            }
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->psi_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('psi_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'psi');
                Template::set_message(lang('psi_delete_success'), 'success');

                redirect(SITE_AREA . '/content/planning/psi');
            }

            Template::set_message(lang('psi_delete_failure') . $this->psi_model->error, 'error');
        }

        Template::set('psi', $this->psi_model->find($id));

        Template::set_block('sub_nav', 'content/_sub_nav_psi');

        Template::set('toolbar_title', lang('psi_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_psi($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->psi_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->psi_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method

        $data['created_on']    = $this->input->post('created_on') ? $this->input->post('created_on') : '0000-00-00 00:00:00';
        $data['modified_on']    = $this->input->post('modified_on') ? $this->input->post('modified_on') : '0000-00-00 00:00:00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->psi_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->psi_model->update($id, $data);
        }

        return $return;
    }

    /**
     * Display a list of TPP data.
     *
     * @return void
     */
    public function tpp($offset = 0)
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
                    $deleted = $this->tpp_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('tpp_delete_success'), 'success');
                } else {
                    Template::set_message(lang('tpp_delete_failure') . $this->tpp_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/content/planning/tpp') . '/';

        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->tpp_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->tpp_model->limit($limit, $offset);

        $records = $this->tpp_model->find_all();

        Template::set('records', $records);

        Template::set_block('sub_nav', 'content/_sub_nav_tpp');

        Template::set('toolbar_title', lang('tpp_manage'));

        Template::render();
    }

    /**
     * Create a TPP object.
     *
     * @return void
     */
    public function create_tpp()
    {
        $this->auth->restrict($this->permissionCreate);

        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_tpp()) {
                log_activity($this->auth->user_id(), lang('tpp_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'tpp');
                Template::set_message(lang('tpp_create_success'), 'success');

                redirect(SITE_AREA . '/content/planning/tpp');
            }

            // Not validation error
            if (!empty($this->tpp_model->error)) {
                Template::set_message(lang('tpp_create_failure') . $this->tpp_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('tpp_action_create'));

        Template::set_block('sub_nav', 'content/_sub_nav_tpp');

        Template::render();
    }
    /**
     * Allows editing of TPP data.
     *
     * @return void
     */
    public function edit_tpp()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('tpp_invalid_id'), 'error');

            redirect(SITE_AREA . '/content/planning/tpp');
        }

        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_tpp('update', $id)) {
                log_activity($this->auth->user_id(), lang('tpp_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'tpp');
                Template::set_message(lang('tpp_edit_success'), 'success');
                redirect(SITE_AREA . '/content/planning/tpp');
            }

            // Not validation error
            if (!empty($this->tpp_model->error)) {
                Template::set_message(lang('tpp_edit_failure') . $this->tpp_model->error, 'error');
            }
        } elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->tpp_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('tpp_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'tpp');
                Template::set_message(lang('tpp_delete_success'), 'success');

                redirect(SITE_AREA . '/content/planning/tpp');
            }

            Template::set_message(lang('tpp_delete_failure') . $this->tpp_model->error, 'error');
        }

        Template::set('tpp', $this->tpp_model->find($id));

        Template::set_block('sub_nav', 'content/_sub_nav_tpp');

        Template::set('toolbar_title', lang('tpp_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_tpp($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->tpp_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want

        $data = $this->tpp_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method

        $data['inv_date']    = $this->input->post('inv_date') ? $this->input->post('inv_date') : '0000-00-00 00:00:00';
        $data['created_on']    = $this->input->post('created_on') ? $this->input->post('created_on') : '0000-00-00 00:00:00';
        $data['modified_on']    = $this->input->post('modified_on') ? $this->input->post('modified_on') : '0000-00-00 00:00:00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->tpp_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->tpp_model->update($id, $data);
        }

        return $return;
    }
}
