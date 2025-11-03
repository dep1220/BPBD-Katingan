<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Agenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'is_active',
        'sequence',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Accessor untuk format tanggal yang mudah dibaca
    public function getFormattedDateAttribute()
    {
        return $this->start_date->format('d');
    }

    public function getFormattedMonthAttribute()
    {
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Ags',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        return $months[$this->start_date->month];
    }

    public function getFormattedTimeRangeAttribute()
    {
        if ($this->end_time) {
            return Carbon::parse($this->start_time)->format('H:i') . ' WIB - ' . Carbon::parse($this->end_time)->format('H:i') . ' WIB';
        }
        return Carbon::parse($this->start_time)->format('H:i') . ' WIB - Selesai';
    }

    // Accessor untuk status agenda otomatis
    public function getStatusAttribute()
    {
        $now = Carbon::now();
        $today = Carbon::today();
        
        // Jika ada tanggal akhir, gunakan tanggal akhir
        $endDate = $this->end_date ?? $this->start_date;
        
        // Jika ada waktu akhir, kombinasikan dengan tanggal akhir
        if ($this->end_time) {
            $endDateTime = Carbon::parse($endDate->format('Y-m-d') . ' ' . $this->end_time);
        } else {
            // Jika tidak ada waktu akhir, anggap berakhir di akhir hari
            $endDateTime = $endDate->copy()->endOfDay();
        }
        
        // Waktu mulai agenda
        $startDateTime = Carbon::parse($this->start_date->format('Y-m-d') . ' ' . $this->start_time);
        
        if ($now < $startDateTime) {
            return 'akan_datang';
        } elseif ($now >= $startDateTime && $now <= $endDateTime) {
            return 'sedang_berlangsung';
        } else {
            return 'selesai';
        }
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'akan_datang':
                return 'Akan Datang';
            case 'sedang_berlangsung':
                return 'Sedang Berlangsung';
            case 'selesai':
                return 'Selesai';
            default:
                return 'Tidak Diketahui';
        }
    }

    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'akan_datang':
                return 'bg-blue-100 text-blue-800';
            case 'sedang_berlangsung':
                return 'bg-green-100 text-green-800';
            case 'selesai':
                return 'bg-gray-100 text-gray-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    // Scope untuk agenda yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk agenda yang akan tampil di public (akan datang dan sedang berlangsung)
    public function scopeForPublic($query)
    {
        $now = Carbon::now();
        
        return $query->where(function ($q) use ($now) {
            // Agenda yang akan datang
            $q->whereDate('start_date', '>', $now->toDateString())
              // Atau agenda hari ini yang sedang berlangsung
              ->orWhere(function ($subQ) use ($now) {
                  $subQ->whereDate('start_date', '<=', $now->toDateString())
                       ->where(function ($timeQ) use ($now) {
                           // Jika ada end_date dan end_time
                           $timeQ->where(function ($endQ) use ($now) {
                               $endQ->whereNotNull('end_date')
                                    ->whereNotNull('end_time')
                                    ->where(function ($combineQ) use ($now) {
                                        $combineQ->whereDate('end_date', '>', $now->toDateString())
                                                 ->orWhere(function ($sameDayQ) use ($now) {
                                                     $sameDayQ->whereDate('end_date', $now->toDateString())
                                                              ->whereTime('end_time', '>=', $now->toTimeString());
                                                 });
                                    });
                           })
                           // Atau jika ada end_date tapi tidak ada end_time
                           ->orWhere(function ($endDateOnlyQ) use ($now) {
                               $endDateOnlyQ->whereNotNull('end_date')
                                           ->whereNull('end_time')
                                           ->whereDate('end_date', '>=', $now->toDateString());
                           })
                           // Atau jika tidak ada end_date dan end_time (agenda sehari)
                           ->orWhere(function ($singleDayQ) use ($now) {
                               $singleDayQ->whereNull('end_date')
                                         ->whereDate('start_date', $now->toDateString())
                                         ->where(function ($timeCheckQ) use ($now) {
                                             $timeCheckQ->whereNull('end_time')
                                                       ->orWhereTime('end_time', '>=', $now->toTimeString());
                                         });
                           });
                       });
              });
        });
    }

    // Scope untuk agenda yang akan datang atau sedang berlangsung
    public function scopeUpcomingOrOngoing($query)
    {
        $now = Carbon::now();
        
        return $query->where(function ($q) use ($now) {
            // Agenda yang akan datang
            $q->whereDate('start_date', '>', $now->toDateString())
              // Atau agenda hari ini yang belum berakhir
              ->orWhere(function ($subQ) use ($now) {
                  $subQ->whereDate('start_date', '<=', $now->toDateString())
                       ->where(function ($timeQ) use ($now) {
                           // Jika ada end_date dan end_time
                           $timeQ->where(function ($endQ) use ($now) {
                               $endQ->whereNotNull('end_date')
                                    ->whereNotNull('end_time')
                                    ->where(function ($combineQ) use ($now) {
                                        $combineQ->whereDate('end_date', '>', $now->toDateString())
                                                 ->orWhere(function ($sameDayQ) use ($now) {
                                                     $sameDayQ->whereDate('end_date', $now->toDateString())
                                                              ->whereTime('end_time', '>=', $now->toTimeString());
                                                 });
                                    });
                           })
                           // Atau jika ada end_date tapi tidak ada end_time
                           ->orWhere(function ($endDateOnlyQ) use ($now) {
                               $endDateOnlyQ->whereNotNull('end_date')
                                           ->whereNull('end_time')
                                           ->whereDate('end_date', '>=', $now->toDateString());
                           })
                           // Atau jika tidak ada end_date dan end_time (agenda sehari)
                           ->orWhere(function ($singleDayQ) use ($now) {
                               $singleDayQ->whereNull('end_date')
                                         ->whereDate('start_date', $now->toDateString())
                                         ->where(function ($timeCheckQ) use ($now) {
                                             $timeCheckQ->whereNull('end_time')
                                                       ->orWhereTime('end_time', '>=', $now->toTimeString());
                                         });
                           });
                       });
              });
        });
    }
}