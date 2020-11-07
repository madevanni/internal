<?php

defined('BASEPATH') || exit('No direct script access allowed');

use GuzzleHttp\Client;

class Sales_model extends BF_Model
{
    /*
     * Infor ERP LN Software Architecture
     * http://www.baanboard.com/node/42
     * tc	Common	master data
     */

    private $_client;

    // You may need to move certain rules (like required) into the
    // $insert_validation_rules array and out of the standard validation array.
    // That way it is only required during inserts, not updates which may only
    // be updating a portion of the data.
    protected $validation_rules         = array(
        array(
            'field' => 'bp_id',
            'label' => 'lang:forecast_field_bp_id',
            'rules' => 'max_length[255]',
        ),
        array(
            'field' => 'model_id',
            'label' => 'lang:forecast_field_model_id',
            'rules' => 'max_length[11]',
        ),
        array(
            'field' => 'item_id',
            'label' => 'lang:forecast_field_item_id',
            'rules' => 'max_length[255]',
        ),
        array(
            'field' => 'cust_part',
            'label' => 'lang:forecast_field_cust_part',
            'rules' => 'max_length[255]',
        ),
        array(
            'field' => 'fy',
            'label' => 'lang:forecast_field_fy',
            'rules' => 'max_length[4]',
        ),
        array(
            'field' => 'period',
            'label' => 'lang:forecast_field_period',
            'rules' => 'max_length[2]',
        ),
        array(
            'field' => 'sales_qty',
            'label' => 'lang:forecast_field_sales_qty',
            'rules' => 'max_length[11]',
        ),
        array(
            'field' => 'inv_qty',
            'label' => 'lang:forecast_field_inv_qty',
            'rules' => 'max_length[11]',
        ),
        array(
            'field' => 'prod_qty',
            'label' => 'lang:forecast_field_prod_qty',
            'rules' => 'max_length[11]',
        ),
    );
    protected $insert_validation_rules  = array();
    protected $skip_validation             = false;

    function __construct()
    {
        parent::__construct();
        $this->_client = new Client([
            'base_uri' => 'http://localhost/api/',
            'auth' => ['admin', '1234']
        ]);
    }

    public function getPartners()
    {
        $response = $this->_client->request('GET', 'sales/partners', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function getModels()
    {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = isset($_GET['rows']) ? intval($_GET['rows']) : 10;

        $response = $this->_client->request('GET', 'sales/models', [
            'query' => [
                'X-API-KEY' => '1234',
                'page' => $page,
                'limit' => $limit
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function saveModel($name)
    {
        $data = [
            'model' => $name,
            'created_by' => $this->auth->user_id(),
            'X-API-KEY' => '1234'
        ];

        $response = $this->_client->request('POST', 'sales/models', [
            'form_params' => $data
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function updateModel($id, $name)
    {
        $data = [
            'id' => $id,
            'name' => $name,
            'modified_by' => $this->auth->user_id(),
            'X-API-KEY' => '1234'
        ];

        $response = $this->_client->request('PUT', 'sales/models', [
            'form_params' => $data
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function deleteModel($id)
    {
        $response = $this->_client->request('DELETE', 'sales/models', [
            'form_params' => [
                'X-API-KEY' => '1234',
                'id' => $id
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return $result;
    }

    public function count_all_forecasts()
    {
        $response = $this->_client->request('GET', 'sales/forecastsCountAll', [
            'query' => [
                'X-API-KEY' => '1234'
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function find_all_forecasts($offset, $limit)
    {
        $response = $this->_client->request('GET', 'sales/forecasts', [
            'query' => [
                'X-API-KEY' => '1234',
                'offset' => $offset,
                'limit' => $limit
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Get the validation rules for the model.
     *
     * @uses $empty_validation_rules Observer to generate validation rules if
     * they are empty.
     *
     * @param String $type The type of validation rules to retrieve: 'update' or
     * 'insert'. If 'insert', appends rules set in $insert_validation_rules.
     *
     * @return array    The validation rules for the model or an empty array.
     */
    public function get_validation_rules($type = 'update')
    {
        $temp_validation_rules = $this->validation_rules;

        // When $validation_rules is empty (or not an array), try to generate the
        // rules by triggering the $empty_validation_rules observer.
        if (empty($temp_validation_rules) || !is_array($temp_validation_rules)) {
            $temp_validation_rules = $this->trigger('empty_validation_rules', $temp_validation_rules);
            if (empty($temp_validation_rules) || !is_array($temp_validation_rules)) {
                return array();
            }

            // If the observer returns a non-empty array, set $validation_rules
            // so they aren't re-generated for this instance of the model.
            $this->validation_rules = $temp_validation_rules;
        }

        // Any insert additions?
        if (
            $type == 'insert'
            && is_array($this->insert_validation_rules)
            && !empty($this->insert_validation_rules)
        ) {
            // Get the index for each field in the validation rules
            $fieldIndexes = array();
            foreach ($temp_validation_rules as $key => $validation_rule) {
                $fieldIndexes[$validation_rule['field']] = $key;
            }

            foreach ($this->insert_validation_rules as $key => $rule) {
                if (is_array($rule)) {
                    $insert_rule = $rule;
                } else {
                    // If $key isn't a field name and $insert_rule isn't an array,
                    // there's nothing useful to do, so skip it.
                    if (is_numeric($key)) {
                        continue;
                    }

                    $insert_rule = array(
                        'field' => $key,
                        'rules' => $rule,
                    );
                }

                // If the field is already in the validation rules, update the
                // validation rule to merge the insert rule (replace empty rules).
                if (isset($fieldIndexes[$insert_rule['field']])) {
                    $fieldKey = $fieldIndexes[$insert_rule['field']];
                    if (empty($temp_validation_rules[$fieldKey]['rules'])) {
                        $temp_validation_rules[$fieldKey]['rules'] = $insert_rule['rules'];
                    } else {
                        $temp_validation_rules[$fieldKey]['rules'] .= "|{$insert_rule['rules']}";
                    }
                } else {
                    // Otherwise, add the insert rule to the validation rules
                    $temp_validation_rules[] = $insert_rule;
                }
            }
        }

        return $temp_validation_rules;
    }
}
