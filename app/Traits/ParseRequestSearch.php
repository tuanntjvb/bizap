<?php
/**
 * Created by PhpStorm.
 * User: batri
 * Date: 1/14/2018
 * Time: 10:55 PM
 */

namespace App\Traits;

use Illuminate\Http\Request;

trait ParseRequestSearch
{
    /**
     * @param Request $request
     * @param array $field_operator Eg: ['name'=>'like']
     * @return array
     */
    private function parseRequest(Request $request, $field_operator = [])
    {
        $result = [];
        $skip_paging_order_field = $this->skipRequestSearchParams();
        if (!$field_operator) {
            foreach ($request->all() as $field => $value) {
                if ($value === 'null' || $value === null || $value === false) {
                    continue;
                }
                if (in_array($field, $skip_paging_order_field)) {
                    $result[$field] = $value;
                } else {
                    $result[$field] = ['field' => $field, 'operator' => '=', 'value' => $value];
                }
            }
        } else {
            foreach ($field_operator as $field => $operator) {
                if ($request->get($field) === null) {
                    continue;
                }
                $result[$field] = ['field' => $field, 'operator' => $operator, 'value' => $request->get($field)];
            }
        }
        return $result;
    }

    public function skipRequestSearchParams()
    {
        return ['page', 'page_size', 'orders', 'with'];
    }
}