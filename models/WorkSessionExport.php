<?php  namespace Miravo\Timetracker\Models;

class WorkSessionExport extends \Backend\Models\ExportModel
{

    protected $fillable = [
        'from_date', 'to_date', 'companies', 'workers'
    ];

    public function getCompaniesOptions() {
        return Company::all()->sortBy('name')->pluck('name', 'id')->toArray();
    }

    public function getWorkersOptions() {
        if ($this->companies) {
            // Assuming $this->companies is an array of company IDs
            return Worker::whereIn('company_id', $this->companies)
                     ->orderBy('first_name')
                     ->get()
                     ->pluck('name', 'id')
                     ->toArray();
        }
    
        return Worker::all()->sortBy('first_name')->pluck('name', 'id')->toArray();
    }

    public function exportData($columns, $sessionKey = null)
    {

        $workSessions = WorkSession::query();

        if ($fromDate = $this->from_date) {
            // Set the time to the start of the day
            $startOfDay = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $fromDate)->startOfDay();
            $workSessions->where('check_in_time', '>=', $startOfDay);
        }

        if ($toDate = $this->to_date) {
            // Set the time to the end of the day
            $endOfDay = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $toDate)->endOfDay();
            $workSessions->where('check_out_time', '<=', $endOfDay);
        }

        if ($workers = $this->workers) {
            $workSessions->whereIn('worker_id', $workers);
        }

        $workSessions = $workSessions->get();


        foreach ($workSessions as &$workSession) {
            $workSession->worker_name = $workSession->worker->name;
            $workSession->company_name = $workSession->worker?->company?->name;
        
            // Format check_in_time and check_out_time to a more user-friendly format directly
            if ($workSession->check_in_time) {
                $workSession->check_in_time_formatted = (new \DateTime($workSession->check_in_time))->format('Y-m-d H:i:s');
            }
        
            if ($workSession->check_out_time) {
                $workSession->check_out_time_formatted = (new \DateTime($workSession->check_out_time))->format('Y-m-d H:i:s');
            }

            if ($workSession->created_at) {
                $workSession->created_at_formatted = (new \DateTime($workSession->created_at))->format('Y-m-d H:i:s');
            }
        
            if ($workSession->is_error != 1 && $workSession->check_out_time && $workSession->check_in_time) {
                $checkInTime = new \DateTime($workSession->check_in_time);
                $checkOutTime = new \DateTime($workSession->check_out_time);
                $interval = $checkOutTime->diff($checkInTime);
                $workSession->duration = $interval->format('%H:%I:%S');
            } else {
                $workSession->duration = null; // or you can set it to a default value like '00:00:00'
            }
        }        

        $workSessions->each(function($workSession) use ($columns) {
            $workSession->addVisible($columns);
        });

        return $workSessions->toArray();
    }
}
