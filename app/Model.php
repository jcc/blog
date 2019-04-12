<?php

namespace App;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    use Filterable;
}
