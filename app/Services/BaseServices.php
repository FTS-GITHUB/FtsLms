<?php

namespace App\Services;
use App\Notifications\UserNotification;
class BaseServices
{
    const PAGINATE = 5;
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        $record = $this->findById($id);
        if ($record) {
            $record->delete();
            return $record;
        }
        return false;
    }
}
