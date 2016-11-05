<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Articles extends Model{
    protected $table = 'articles';
    protected $fillable = ['author',
                           'name',
                           'created_at'];

    public function setCreatedAtAttribute($date){
        //format lại $date được gửi vào từ form
        $this->attributes['created_at'] = Carbon::createFromFormat('Y-m-d',
                                                                   $date);
    }

}