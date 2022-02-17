<?php

namespace App\Http\Requests;

use App\Models\AdminPlan;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdminPlanRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_plan_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'subtitle' => [
                'string',
                'nullable',
            ],
            'price' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'discount' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
