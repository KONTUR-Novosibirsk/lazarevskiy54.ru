<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

use Illuminate\Support\Facades\View;

class Checkbox extends AbstractFormElement
{
    protected string $name;


    public function __construct($name, array $params)
    {
        $this->name = $name;
        $this->rules = $params['rules'] ?? null;
        $this->config['labelName'] = $params['name'];
        $this->config['type'] = $params['type'] ?? 'text';
        $this->config['element'] = 'checkbox';
        $this->config['default'] = $params['default'] ?? false;
        $this->visible = isset($params['visible']) && is_callable($params['visible']) ? call_user_func($params['visible']) : true;
    }

}
