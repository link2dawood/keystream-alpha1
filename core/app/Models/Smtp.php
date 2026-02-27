<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Smtp extends Model
{
    use GlobalStatus;
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function statusBadge(): Attribute
    {
        return new Attribute(function(){
            $html = '';
            if($this->status == Status::ACTIVE){
                $html = '<span class="badge badge--success">'.trans('Activated').'</span>';
            }else{
                $html = '<span class="badge badge--danger">'.trans('Inactivated').'</span>';
            }
            return $html;
        });
    }
}
