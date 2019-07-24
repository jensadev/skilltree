<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class SkilltreeInvitationRequest extends FormRequest
{
    /**
     * The key to be used for the view error bag.
     *
     * @var string
     */
    protected $errorBag = 'invitations';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('manage', $this->route('skilltree'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'email' => ['required', 'exists:users,email', 'not_regex:/(@elev)/'] // 'not_regex:/(@elev)/']
            'email' => [
                'email',
                'required',
                'regex:/(ga.ntig.se)/'
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'You must enter a valid email address.',
            //            'email.exists' => 'The user you are inviting must have a Skilltree Teacher account.',
            'email.regex' => 'The email must be a valid account.'
        ];
    }
}
