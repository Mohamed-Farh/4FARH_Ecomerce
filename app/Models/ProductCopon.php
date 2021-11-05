<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Carbon;

class ProductCopon extends Model
{

    use Sluggable, SearchableTrait;

    protected $guarded = [];


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $searchable = [
        'columns' => [
            'product_copons.code' => 10,
            'product_copons.description' => 10,
        ],
    ];

    protected $dates = [ 'start_date', 'expire_date'];




    public function status()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function discount($total)
    {
        if (!$this->checkDate() || !$this->checkUsedTimes()){
            return 0;
        }
        return $this->checkGreaterThan($total) ? $this->doProcess($total) : 0;
    }

    protected function checkDate()
    {
        //رجع القيمه الفرديه الل بين start data and expire data
        return $this->expire_date != '' ? (Carbon::now()->between($this->start_date, $this->expire_date, true)) ? true : false : true;
    }

    protected function checkUsedTimes()
    {
        return $this->use_times != '' ? ( $this->use_times > $this->used_times ) ? true : false : true;
    }

    protected function checkGreaterThan($total)
    {
        return $this->greater_than != '' ? ($this->greater_than >= $total) ? true : false : true;
    }

    protected function doProcess($total)
    {
        switch ($this->type) {
            case 'fixed':
                return $this->value;
            case 'percentage':
                return ($this->value / 100) * $total;
            default:
                return 0;
        }
    }


}

