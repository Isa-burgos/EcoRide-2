<?php

namespace App\Models;

abstract class Model{

    public function hydrate(array $data): self
    {
        foreach ($data as $key => $value) {
            $camelCase = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));

            $method = 'set' . $camelCase;

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        return $this;
    }
    
}