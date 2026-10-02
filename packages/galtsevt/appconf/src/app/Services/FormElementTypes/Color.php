<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

use Illuminate\Support\Facades\View;

class Color extends AbstractFormElement
{
    protected string $name;


    public function __construct($name, array $params)
    {
        $this->name = $name;
        $this->rules = $params['rules'] ?? null;
        $this->config['labelName'] = $params['name'];
        $this->config['placeholder'] = $params['placeholder'] ?? null;
        $this->config['type'] = 'color';
        $this->config['default'] = $params['default'] ?? '';
        $this->config['element'] = 'color';
        $this->visible = isset($params['visible']) && is_callable($params['visible']) ? call_user_func($params['visible']) : true;
    }

}
