<?php

namespace App\Support;

trait ProvidesValidation
{
    protected function validationMessages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser un texto válido.',
            'email' => 'El campo :attribute debe ser un correo electrónico válido.',
            'numeric' => 'El campo :attribute debe ser un número válido.',
            'integer' => 'El campo :attribute debe ser un número entero válido.',
            'boolean' => 'El campo :attribute debe tener un valor válido.',
            'array' => 'El campo :attribute debe ser una lista válida.',
            'confirmed' => 'La confirmación del campo :attribute no coincide.',
            'in' => 'El valor seleccionado para :attribute no es válido.',
            'date' => 'El campo :attribute debe contener una fecha válida.',
            'date_format' => 'El campo :attribute debe tener el formato :format.',
            'min.string' => 'El campo :attribute debe tener al menos :min caracteres.',
            'min.numeric' => 'El campo :attribute debe ser mayor o igual a :min.',
            'min.array' => 'El campo :attribute debe tener al menos :min elementos.',
            'max.string' => 'El campo :attribute no puede exceder :max caracteres.',
            'max.numeric' => 'El campo :attribute no puede ser mayor a :max.',
            'max.array' => 'El campo :attribute no puede tener más de :max elementos.',
            'after_or_equal' => 'El campo :attribute debe ser una fecha igual o posterior a :date.',
            'before_or_equal' => 'El campo :attribute debe ser una fecha igual o anterior a :date.',
        ];
    }

    protected function validationAttributes(array $attributes = []): array
    {
        return collect($attributes)
            ->mapWithKeys(fn (string $label, string $key) => [$key => mb_strtolower($label)])
            ->all();
    }
}
