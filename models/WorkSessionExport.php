<?php  namespace Miravo\Timetracker\Models;

class WorkSessionExport extends \Backend\Models\ExportModel
{

    public function exportData($columns, $sessionKey = null)
    {
        $workSessions = WorkSession::all();

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
