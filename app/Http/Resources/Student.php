<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf;
            'telefone' => $this->telefone;
            'idade' => $this->idade;
            'boletim' => $this->boletim;
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
];
    }
}
