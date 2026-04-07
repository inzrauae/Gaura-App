<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'expense_date' => ['sometimes', 'date'],
            'project_name' => ['sometimes', 'nullable', 'string', 'max:100'],
            'category' => ['sometimes', 'string', 'in:Labor,Excavation and Earthwork,Concrete and Cement,Steel and Metal,Masonry and Blockwork,MEP Works,Electrical and Lighting,Plumbing and Sanitary,Waterproofing and Roofing,Transport and Logistics,Equipment Rental,Site Safety and PPE,Finishing Works,Doors and Windows,Permits and Compliance,Other'],
            'title' => ['sometimes', 'string', 'max:255'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'payment_type' => ['sometimes', 'in:company_paid,director_paid'],
            'director_name' => ['nullable', 'required_if:payment_type,director_paid', 'in:Buddhika,Nilitha,Vihaga'],
            'director_fund_source' => ['nullable', 'required_if:payment_type,director_paid', 'in:cash_in_hand,bank_balance'],
            'notes' => ['nullable', 'string'],
            'receipt' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
        ];
    }
}
