<?php

namespace App\Http\Requests;

use App\Models\Eletrodomestico;
use App\Models\Marca;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation;
use Illuminate\Validation\Rule;

class EletrodomesticoRequest extends FormRequest
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
            'marca_id' => [
                'required',
                Rule::in(Marca::pluck('id', 'id'))
            ],];
    }

    /**
     *
     * @param Validation\Validator $validator
     * @return HttpResponseException
     */
    public function withValidator($validator)
    {
        $id = (int)$this->route('appliance');
        $validation = $validator;

        $has_eletro = Eletrodomestico::hasEletrodomestico($this->descricao, $this->marca_id, $id);

        if ($has_eletro) {
            $validation->errors()->add('descricao', 'Já existe esse eletrodomestico com a descrição e marca cadastrada!');
        }

        if ($validator->errors()->count()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validator->errors(),
                'url' => $id ? route('appliances.update', ['appliance' => $id]) : route('appliances.store')
            ], 403));
        }
    }
}
