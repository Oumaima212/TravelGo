<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $primaryKey = 'idInvoice';
    protected $casts = [
        'invoiceDate' => 'date',
    ];

    protected $fillable = [
        'invoiceReference',
        'invoiceDate',
        'totalAmount',
        'amountDue',
        'discount',
        'client_id',
        'program_id',
        'reservation_id',
        'paymentMethod',
        'paidAmount',
        'remainingAmount',
        'paymentDescription',
    ];


    // Spécifie que 'invoiceDate' doit être traité comme un objet Carbon
    protected $dates = ['invoiceDate']; // Ajoutez 'invoiceDate' ici

    // Relations
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'id');
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

}
