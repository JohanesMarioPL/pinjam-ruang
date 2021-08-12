<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BorrowRoom extends Model
{
    use SoftDeletes;

    protected $table = 'borrow_rooms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'borrower_id',
        'room_id',
        'borrow_at',
        'until_at',
        'lecturer_id',
        // 'lecturer_approval_status',
        // 'admin_id',
        // 'admin_approval_status',
        // 'processed_at',
        // 'returned_at',
        // 'notes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'borrow_at' =>  'date',
        'until_at' =>   'date',
    ];

    /**
     * Relationship
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function borrower()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function admin()
    {
        return $this->belongsTo(Administrator::class);
    }

    /**
     * Scope
     *
     */
    public function scopeIsNotFinished($query)
    {
        return $query->where('returned_at', '=', null);
    }

    /**
     * Accessor
     */


    /**
     * Mutators
     */
}
