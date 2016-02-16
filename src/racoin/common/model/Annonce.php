<?php

namespace racoin\common\model;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    protected $table = 'annonce';
    protected $primaryKey = 'id';
    public $timestamps = true;
}