<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service_id',
        'status',
        'description',
        'reason_of_cancel',
        'reason_of_decline',
        'appointment_date',
    ];

    public function patient()
    {
        return $this->belongsTo('App\Models\User', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Models\User', 'doctor_id');
    }

	public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function appointmentStatus()
	{
		$status = "";
		switch ($this->status) {
			case 'pending':
				$status = "Pending";
				break;

			case 'confirmed':
				$status = "Confirmed";
				break;

			case 'done':
				$status = "Done";
				break;

			case 'canceled':
				$status = "Canceled";
				break;
            
            case 'declined':
                $status = "Declined";
                break;

			default:
				$status = "";
				break;
		}
		return $status;
	}

	public function statusBadge()
	{
		$badge = "";
		switch ($this->status) {
			case 'pending':
				$badge = '<span class="badge badge-warning text-md">Pending</span>';
				break;

			case 'confirmed':
				$badge = '<span class="badge badge-primary text-md">Confirmed</span>';
				break;

			case 'done':
				$badge = '<span class="badge badge-success text-md">Done</span>';
				break;

			case 'canceled':
				$badge = '<span class="badge badge-danger text-md">Canceled</span>';
				break;

			case 'declined':
				$badge = '<span class="badge badge-danger text-md">Declined</span>';
				break;

			default:
				$badge = "";
				break;
		}
		return $badge;
	}

	public function statusAlert($additionalClass = null)
	{
		$alert = "";
		switch ($this->status) {
			case 'pending':
				$alert = '<div class="alert '.$additionalClass.' text-center alert-warning" role="alert">Pending</div>';
				break;

			case 'confirmed':
				$alert = '<div class="alert '.$additionalClass.' text-center alert-primary" role="alert">Confirmed</div>';
				break;

			case 'done':
				$alert = '<div class="alert '.$additionalClass.' text-center alert-success" role="alert">Done</div>';
				break;

			case 'canceled':
				$alert = '<div class="alert '.$additionalClass.' text-center alert-danger" role="alert">Canceled</div>';
				break;

			case 'declined':
				$alert = '<div class="alert '.$additionalClass.' text-center alert-danger" role="alert">Declined</div>';
				break;

			default:
				$alert = "";
				break;
		}
		return $alert;
	}

    public function appointmentTime()
    {
        $time [
            '9:00am'
        ];
        return $time;
    }

	/**
	 * Static functions
	 */
	public static function getStatus($status)
	{
		$statusName = "";
		switch ($status) {
			case 'pending':
				$statusName = "Pending";
				break;

			case 'confirmed':
				$statusName = "Confirmed";
				break;

			case 'done':
				$statusName = "Done";
				break;

			case 'canceled':
				$statusName = "Canceled";
				break;

			case 'declined':
				$statusName = "Declined";
				break;

			default:
				$statusName = "";
				break;
		}
		return $statusName;
	}

	public static function getStatusBadge($status)
	{
		$badge = "";
		switch ($status) {
			case 'pending':
				$badge = '<span class="badge badge-warning text-md">Pending</span>';
				break;

			case 'confirmed':
				$badge = '<span class="badge badge-primary text-md">Confirmed</span>';
				break;

			case 'done':
				$badge = '<span class="badge badge-success text-md">Done</span>';
				break;

			case 'canceled':
				$badge = '<span class="badge badge-danger text-md">Canceled</span>';
				break;

			case 'declined':
				$badge = '<span class="badge badge-danger text-md">Declined</span>';
				break;

			default:
				$badge = "";
				break;
		}
		return $badge;
	}
}
