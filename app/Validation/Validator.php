<?php

namespace App\Validation;

class Validator{

    private array $data;
    private array $errors = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): array
    {
        foreach($rules as $name => $rulesArray){
            if(isset($this->data[$name])){
                foreach($rulesArray as $rule){
                    if($rule === 'required'){
                        $this->required($name, $this->data[$name]);
                    } elseif(str_starts_with($rule, 'min')){
                        $this->minLength($name, $this->data[$name], (int) str_replace('min', '', $rule));
                    } elseif($rule === 'email'){
                        $this->email($name, $this->data[$name]);
                    } elseif($rule === 'password'){
                        $this->passwordComplexity($name, $this->data[$name]);
                    }
                }
            } else {
                $this->errors[$name] = "{$name} est requis";
            }
        }
        return $this->getErrors();
    }

    private function required(string $name, string $value): void
    {
        $value = trim($value);

        if (trim($value) === ''){
            $this->errors[$name][] = "{$name} est requis";
        }
    }

    private function minLength(string $name, string $value, string $min): void
    {
        if(strlen(trim($value)) < $min){
            $this->errors[$name][] = "{$name} doit comporter au moin {$min} caractères";
        }
    }

    private function email(string $name, string $value): void
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            $this->errors[$name][] = "L'adresse e-mail n'est pas valide";
        }
    }

    private function passwordComplexity(string $name, string $value): void
    {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $value)) {
            $this->errors[$name][] = "Le mot de passe doit contenir au moins 8 caractères dont une majuscule, une minuscule, un chiffre et un caractère spécial.";
        }
    }

    private function getErrors(): array
    {
        return $this->errors;
    }

}