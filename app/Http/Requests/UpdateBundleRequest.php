<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateBundleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bundleId = $this->route('bundle') ?? $this->route('id') ?? $this->input('id');
        if (is_object($bundleId)) {
            $bundleId = $bundleId->id;
        }

        return [
            'bundle_no' => [
                'required',
                'string',
                'max:100',
                Rule::unique('production_bundles', 'bundle_no')->ignore($bundleId),
            ],
            'buyer_id' => ['required', 'exists:buyers,id'],
            'style_id' => ['required', 'exists:styles,id'],
            'line_id' => ['required', 'exists:sewing_lines,id'],
            'color' => ['required', 'string', 'max:50'],
            'size' => ['required', 'string', 'max:20'],
            'quantity' => ['required', 'integer', 'min:1'],
            'completed_qty' => ['required', 'integer', 'min:0', 'lte:quantity'],
            'rejected_qty' => ['required', 'integer', 'min:0', 'lte:quantity'],
            'operator_name' => ['nullable', 'string', 'max:100'],
            'production_date' => ['required', 'date', 'before_or_equal:today'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'bundle_no.required' => 'The bundle number is required.',
            'bundle_no.unique' => 'This bundle number is already in use by another bundle.',
            'buyer_id.required' => 'Please select a valid buyer.',
            'style_id.required' => 'Please select a valid style.',
            'line_id.required' => 'Please select a sewing line.',
            'quantity.min' => 'Quantity must be greater than zero.',
            'completed_qty.lte' => 'Completed quantity cannot exceed total bundle quantity.',
            'rejected_qty.lte' => 'Rejected quantity cannot exceed total bundle quantity.',
            'production_date.before_or_equal' => 'Production date cannot be a future date.',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $qty = (int)$this->input('quantity', 0);
            $completed = (int)$this->input('completed_qty', 0);
            $rejected = (int)$this->input('rejected_qty', 0);

            if (($completed + $rejected) > $qty) {
                $validator->errors()->add(
                    'completed_qty',
                    'The sum of Completed Quantity (' . $completed . ') and Rejected Quantity (' . $rejected . ') cannot exceed Total Quantity (' . $qty . ').'
                );
            }
        });
    }
}
