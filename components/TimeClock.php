<?php namespace Miravo\Timetracker\Components;

use Cms\Classes\ComponentBase;
use Miravo\Timetracker\Models\{Worker, WorkerSession, Company};
use Carbon\Carbon;
use Miravo\Timetracker\Classes\TranslateHelper;

/**
 * TimeClock Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class TimeClock extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Time Clock Component',
            'description' => 'This component enables searching for workers, displaying current details, and providing punch buttons along with punch history.'
        ];        
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [];
    }

    public function onRender() {
        $this->prepareVars($this->getWorker());
    }

    public function prepareVars($worker) {
        
        $workSessionHistoryItemsPerPage = $this->property('workSessionHistoryItemsPerPage') ?? 5; 
        $this->page['refreshDelayInSeconds'] = $this->property('refreshDelayInSeconds');
        $this->page['initialLoading'] = isset($_POST['login']) ? false : true;
        $this->page['worker'] = $worker;
        $this->page['company'] = $worker?->company;
        $this->page['lastWorkSession'] = $worker?->workSessions()->whereDate('check_in_time', Carbon::today())->latest()->first();
        $this->page['workSessions'] = $worker?->workSessions()->orderBy('created_at', 'desc')->paginate($workSessionHistoryItemsPerPage);
    }

    public function onSearch() {
        $this->prepareVars($this->getWorker());
    }

    public function onPunch() {
        if ($worker = $this->getWorker()) {
            // Get the latest work session regardless of the date
            $lastWorkSession = $worker?->workSessions()->latest()->first();
    
            // Check if the last work session is from a previous day and not closed
            if ($lastWorkSession && !$lastWorkSession->check_out_time && !$lastWorkSession->isSameDay()) {
                // Mark the previous session as an error
                $lastWorkSession->update([
                    'is_error' => 1, // Assuming you use 'is_error' field
                ]);
            }
    
            // Now check today's session
            $todaysWorkSession = $worker?->workSessions()->whereDate('check_in_time', Carbon::today())->latest()->first();
    
            if (!$todaysWorkSession || ($todaysWorkSession && $todaysWorkSession->check_out_time)) {
                // No valid work session found for today, or the last session is complete
                // Create a new work session with check_in_time set to now
                $worker->workSessions()->create([
                    'check_in_time' => now(),
                    'is_error' => 0, // Mark this new session as correct
                ]);
                \Flash::success(TranslateHelper::string('You have successfully punched in.'));
    
            } elseif ($todaysWorkSession && !$todaysWorkSession->check_out_time) {
                // A session from today exists but check_out_time is not set (the worker has checked in but not out)
                // Update the existing work session with check_out_time and mark it as correct
                $todaysWorkSession->update([
                    'check_out_time' => now(),
                    'is_error' => 0, // Mark this session as correct
                ]);
    
                \Flash::success(TranslateHelper::string('You have successfully punched out.'));
            }
        }
        $this->prepareVars($this->getWorker());
    }

    public function getWorker() {
        $login = request()->input('login');
        if (empty($login)) {
            return null;
        }
        return Worker::where('code', $login)->first();
    }
}
