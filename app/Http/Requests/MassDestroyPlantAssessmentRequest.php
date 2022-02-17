<?php

namespace App\Http\Requests;

use App\Models\PlantAssessment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyPlantAssessmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('plant_assessment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:plant_assessments,id',
        ];
    }
}
