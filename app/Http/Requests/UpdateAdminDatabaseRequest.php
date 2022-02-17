<?php

namespace App\Http\Requests;

use App\Models\AdminDatabase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateAdminDatabaseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('admin_database_edit');
    }

    public function rules()
    {
        return [
            'image' => [
                'array',
            ],
            'title' => [
                'string',
                'nullable',
            ],
            'subtitle' => [
                'string',
                'nullable',
            ],
            'tags.*' => [
                'integer',
            ],
            'tags' => [
                'array',
            ],
        ];
    }
}
