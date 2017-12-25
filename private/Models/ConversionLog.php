<?php
namespace QuickBetOnline\Models;

use Illuminate\Database\Eloquent\Model;
class ConversionLog extends Model
{
    public function save(array $options = [])
    {
        //sanitize the data before inserting
        $filters = array(
            'decimal' => FILTER_SANITIZE_NUMBER_FLOAT,
            'type' => FILTER_SANITIZE_STRING,
            'fractional' => FILTER_SANITIZE_STRING,
            'moneyline' => FILTER_SANITIZE_NUMBER_FLOAT,
        );

        $options = array(
            'decimal'=>array(
                'flags' => FILTER_FLAG_ALLOW_FRACTION
            ),
            'type'=>array(
                'flags' => FILTER_NULL_ON_FAILURE
            ),
            'fractional'=>array(
                'flags' => FILTER_NULL_ON_FAILURE
            ),
            'moneyline'=>array(
                'flags' => FILTER_FLAG_ALLOW_FRACTION
            ),
        );

        $filtered = array();
        $data = json_decode($this->data);
        foreach($data as $key => $value) {
            $filtered[$key] = filter_var($value, $filters[$key], $options[$key]);
        }
        $this->data = json_encode($filtered);

        // before save code
        parent::save();
    }
}