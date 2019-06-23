<?php

namespace App\Http\Requests;

use App\Skilltree;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSkilltreeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->skilltree());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'description' => 'required|min:3'
        ];
    }

    public function skilltree()
    {
        return Skilltree::findOrFail($this->route('skilltree'));
    }

    public function persist()
    {
        $this->skilltree()->update($this->validated());
    }
}
