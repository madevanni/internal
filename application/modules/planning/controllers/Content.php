<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;

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

        $this->load->model(array('planning/planning_model', 'planning/items_model', 'planning/calendar_model'));

        $this->auth->restrict($this->permissionView);
        $this->lang->load(array('planning', 'items', 'calendar'));

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

    // /**
    //  * Create a Planning object.
    //  *
    //  * @return void
    //  */
    // public function create() {
    //     $this->auth->restrict($this->permissionCreate);

    //     Template::set('toolbar_title', lang('planning_action_create'));

    //     Template::render();
    // }

    // /**
    //  * Allows editing of Planning data.
    //  *
    //  * @return void
    //  */
    // public function edit() {
    //     $id = $this->uri->segment(5);
    //     if (empty($id)) {
    //         Template::set_message(lang('planning_invalid_id'), 'error');

    //         redirect(SITE_AREA . '/content/planning');
    //     }

    //     Template::set('toolbar_title', lang('planning_edit_heading'));
    //     Template::render();
    // }

}
