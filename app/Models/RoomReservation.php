<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class RoomReservation extends Model
{
    use SoftDeletes;

    protected $table = 'rooms_reservations';

    protected $fillable = ['name', 'second_name', 'start_date', 'end_date', 'room_id'];

}