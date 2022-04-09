<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'email|required',
            'name' => 'required',
        ];
    }

    /**
     *
     * @param Validation\Validator $validator
     * @return HttpResponseException
     */
    public function withValidator($validator)
    {
        $id = $this->route('user');
        $validation = $validator;

        if(!$id && !$this->password){
            $validation->errors()->add('password','Informe a senha');
        }

        if (User::hasEmail($this->email, $id)) {
            $validation->errors()->add('email', 'Já existe esse email cadastrado!');
        }

        if ($validator->errors()->count()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validator->errors(),
                'url' => $id ? route('users.update', ['user' => $id]) : route('users.store')
            ], 403));
        }
    }
}
