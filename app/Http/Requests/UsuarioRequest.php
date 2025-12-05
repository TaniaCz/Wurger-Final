<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'Nom_usuario' => 'required|string|max:50',
            'Apellido_usuario' => 'required|string|max:50',
            'Cedula_usuario' => 'required|string|max:20|unique:usuario,Cedula_usuario',
            'Salario_usuario' => 'required|numeric|min:0',
            'Fecha_ingreso_usuario' => 'required|date',
            'Fecha_nac_usuario' => 'required|date|before:today',
            'Sexo_usuario' => 'required|in:M,F',
            'Tel_usuario' => 'required|string|max:15',
            'Email_usuario' => 'required|email|max:100|unique:usuario,Email_usuario',
            'Password_usuario' => 'required|string|min:6|confirmed',
            'Estado_usuario' => 'required|in:Activo,Inactivo',
            'id_rol_FK' => 'required|exists:rol,id_rol'
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['Cedula_usuario'] = 'required|string|max:20|unique:usuario,Cedula_usuario,' . $this->route('usuario');
            $rules['Email_usuario'] = 'required|email|max:100|unique:usuario,Email_usuario,' . $this->route('usuario');
            $rules['Password_usuario'] = 'nullable|string|min:6|confirmed';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'Nom_usuario.required' => 'El nombre es obligatorio.',
            'Nom_usuario.max' => 'El nombre no puede tener más de 50 caracteres.',
            'Apellido_usuario.required' => 'El apellido es obligatorio.',
            'Apellido_usuario.max' => 'El apellido no puede tener más de 50 caracteres.',
            'Cedula_usuario.required' => 'La cédula es obligatoria.',
            'Cedula_usuario.unique' => 'Esta cédula ya está registrada.',
            'Cedula_usuario.max' => 'La cédula no puede tener más de 20 caracteres.',
            'Salario_usuario.required' => 'El salario es obligatorio.',
            'Salario_usuario.numeric' => 'El salario debe ser un número.',
            'Salario_usuario.min' => 'El salario no puede ser negativo.',
            'Fecha_ingreso_usuario.required' => 'La fecha de ingreso es obligatoria.',
            'Fecha_ingreso_usuario.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'Fecha_nac_usuario.required' => 'La fecha de nacimiento es obligatoria.',
            'Fecha_nac_usuario.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'Fecha_nac_usuario.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'Sexo_usuario.required' => 'El sexo es obligatorio.',
            'Sexo_usuario.in' => 'El sexo debe ser M o F.',
            'Tel_usuario.required' => 'El teléfono es obligatorio.',
            'Tel_usuario.max' => 'El teléfono no puede tener más de 15 caracteres.',
            'Email_usuario.required' => 'El email es obligatorio.',
            'Email_usuario.email' => 'El email debe tener un formato válido.',
            'Email_usuario.unique' => 'Este email ya está registrado.',
            'Email_usuario.max' => 'El email no puede tener más de 100 caracteres.',
            'Password_usuario.required' => 'La contraseña es obligatoria.',
            'Password_usuario.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'Password_usuario.confirmed' => 'La confirmación de contraseña no coincide.',
            'Estado_usuario.required' => 'El estado es obligatorio.',
            'Estado_usuario.in' => 'El estado debe ser Activo o Inactivo.',
            'id_rol_FK.required' => 'El rol es obligatorio.',
            'id_rol_FK.exists' => 'El rol seleccionado no es válido.'
        ];
    }
}
