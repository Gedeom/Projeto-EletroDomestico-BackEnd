<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation;

class MarcaRequest extends FormRequest
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
            'descricao' => 'required',
        ];
    }

    /**
     *
     * @param Validation\Validator $validator
     * @return HttpResponseException
     */
    public function withValidator($validator)
    {
        $id = $this->route('brand');
        $validation = $validator;

        if ($validator->errors()->count()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validator->errors(),
                'url' => $id ? route('brands.update', ['brand' => $id]) : route('brands.store')
            ], 403));
        }
    }
}
