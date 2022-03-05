<?php

namespace App\Editors;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class Editor
{
    protected ?Model $model;
    protected $data;
    protected $beforeSaveHandler;
    protected $afterSaveHandler;

    public function __construct(Model $model = null)
    {
        $this->model = $model;
    }

    public static function open(Model $model = null)
    {
        return new static($model);
    }

    public function withData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function withDataFromRequest(Request $request)
    {
        return $this->withData($request->all());
    }

    public function getData()
    {
        return $this->data;
    }

    public function beforeSave(callable $callback)
    {
        $this->beforeSaveHandler = $callback;
        return $this;
    }

    public function afterSave(callable $callback)
    {
        $this->afterSaveHandler = $callback;
        return $this;
    }

    public function save()
    {
        if (!empty($this->beforeSaveHandler)) call_user_func($this->beforeSaveHandler, $this->model, $this->data);
        $this->handleSave();
        if (!empty($this->afterSaveHandler)) call_user_func($this->afterSaveHandler, $this->model, $this->data);
        return $this->model;
    }

    abstract public function handleSave();
}
