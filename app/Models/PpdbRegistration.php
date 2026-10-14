php

namespace App\Models;

use App\Models\Monitoring\PpdbActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'student_name',
        'birth_place',
        'birth_date',
        'gender',
        'nik',
        'kk_number',
        'parent_name',
        'phone',
        'email',
        'address',
        'previous_school',
        'status',
        'notes',
        'supporting_file_kk',
        'supporting_file_akte',
        'supporting_file_rapor',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relationship to activities
    public function activities()
    {
        return $this->hasMany(PpdbActivity::class, 'registration_id');
    }
}
