<?php

namespace App;

use App\Translator\Translatable;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\TranslatableInterface;
use App\Http\Controllers\Traits\RecordSignature;

class Category extends Model implements TranslatableInterface
{
    use RecordSignature;
    use Translatable;

    protected $guarded = ['id'];
    protected $table = 'categories';

    protected static $translatable = ['name' => 'label'];

    const ORDERING_ASC = 1;
    const ORDERING_DESC = 2;

    public function userFollow()
    {
        return $this->hasMany('App\UserFollow');
    }

    public function dataSet()
    {
        return $this->hasMany('App\DataSet');
    }

    public function dataSetSubCategory()
    {
        return $this->hasMany('App\DataSetSubCategories');
    }
}