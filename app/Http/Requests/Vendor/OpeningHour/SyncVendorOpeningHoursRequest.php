<?php

namespace App\Http\Requests\Vendor\OpeningHour;

use App\Http\Requests\Vendor\VendorMutationFormRequest;
use Illuminate\Validation\Rule;

class SyncVendorOpeningHoursRequest extends VendorMutationFormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->input('branch_id') === '') {
            $this->merge(['branch_id' => null]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $restaurant = $this->vendorRestaurant();

        return [
            'branch_id' => [
                'nullable',
                'integer',
                Rule::exists('branches', 'id')->where(fn ($q) => $q->where('restaurant_id', $restaurant->getKey())),
            ],
            'hours' => ['required', 'array', 'size:7'],
            'hours.*.day_of_week' => ['required', 'integer', 'between:0,6'],
            'hours.*.is_closed' => ['required', 'boolean'],
            'hours.*.open_time' => ['nullable', 'date_format:H:i'],
            'hours.*.close_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            foreach ($this->input('hours', []) as $i => $row) {
                if (! empty($row['is_closed'])) {
                    continue;
                }
                if (empty($row['open_time']) || empty($row['close_time'])) {
                    $validator->errors()->add("hours.{$i}.open_time", __('Open and close times are required when the day is not closed.'));

                    continue;
                }
                if ($row['close_time'] <= $row['open_time']) {
                    $validator->errors()->add("hours.{$i}.close_time", __('Close time must be after open time.'));
                }
            }
        });
    }
}
