<?php namespace Xl1034\Likes\Models;

use Model;

/**
 * Model
 */
class Like extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $fillable = ['likeable_id', 'likeable_type', 'is_dislike', 'user_id'];

    public $morphTo = [
        'likeable' => []
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'xl1034_likes_index';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

}
