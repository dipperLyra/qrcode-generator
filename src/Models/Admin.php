<?php


namespace API\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use API\Database\CapsuleSetUp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    protected $table = 'admin';
}