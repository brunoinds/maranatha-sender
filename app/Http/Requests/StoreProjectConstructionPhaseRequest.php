<?php

namespace App\Http\Requests;

use App\Helpers\Enums\ProjectConstructionPhaseStatus;
use App\Helpers\Enums\ProjectConstructionTaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectConstructionPhaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project_job_id' => ['required', 'integer', 'exists:project_jobs,id'],
            'expense_code' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'color' => ['nullable', 'string', 'max:255'],
            'status' => ['string', Rule::in(ProjectConstructionPhaseStatus::toArray())],
            'scheduled_start_date' => ['date'],
            'scheduled_end_date' => ['date'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date'],
            'progress' => ['integer'],
            'tasks' => ['present', 'array'],
            'tasks.*.name' => ['required', 'string', 'max:255'],
            'tasks.*.description' => ['nullable', 'string', 'max:255'],
            'tasks.*.status' => ['string', Rule::in(ProjectConstructionTaskStatus::toArray())],
            'tasks.*.scheduled_start_date' => ['date'],
            'tasks.*.scheduled_end_date' => ['date'],
            'tasks.*.started_at' => ['nullable', 'date'],
            'tasks.*.ended_at' => ['nullable', 'date'],
            'tasks.*.count_workers' => ['integer', 'min:0'],
            'tasks.*.progress' => ['integer', 'min:0'],
            /*'final_report' => ['nullable', 'array'],
            'final_report.attachments_ids' => ['present', 'array'],
            'final_report.attachments_ids.*' => ['string'],
            'final_report.notes' => ['string'],*/
        ];
    }
}
