<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $trackId
 * @property string $name
 */
class Track extends Model
{
    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'trackId';

    /**
     * @var array
     */
    protected $fillable = ['name'];

}
