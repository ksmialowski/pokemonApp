<?php

namespace App\Http\Requests\v1\BannedPokemon;

use App\Http\Requests\v1\Request;

class StoreBannedPokemonRequest extends Request
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
            'name' => 'required|string|unique:banned_pokemons,name|max:255',
        ];
    }
}
