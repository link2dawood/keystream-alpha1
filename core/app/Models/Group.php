<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Group extends Model
{
    use GlobalStatus;

    public function scopeEmail($query)
    {
        $query->where('type', 1);
    }
    public function scopeSms($query)
    {
        $query->where('type', 2);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeBanned($query)
    {
        return $query->where('status', 0);
    }
    public function contact()
    {
        return $this->belongsToMany(Contact::class, 'group_contacts', 'group_id');
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
