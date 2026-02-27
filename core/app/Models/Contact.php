<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\FileExport;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Contact extends Model
{
    use FileExport,GlobalStatus;
    public function groupContact()
    {
        return $this->belongsToMany(Group::class, 'group_contacts', 'contact_id');
    }
    public function scopeActive()
    {
        return $this->where('status', 1);
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
