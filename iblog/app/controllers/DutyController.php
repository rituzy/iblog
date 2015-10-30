<?php
     
interface iDuty
{
    public function listDuties();    
}

class fillDuty implements iDuty 
{
    public function listDuties()
    {
        //return Duty::getDutiesOrderedFill();        
        return Duty::getDutiesFill();
    }

    public function getNow()
    {        
        return Duty::getNowFill();
    }
}

class updDuty implements iDuty
{
    public function listDuties()
    {
        //return Duty::getDutiesOrderedUpd();
        return Duty::getDutiesUpd();
    }

    public function getNow()
    {        
        return Duty::getNowUpd();
    }
    
}

class DutyController extends BaseController
{    

    /* get functions */
    public function listDutiesFill()
    {
        $duties              = (new fillDuty())->listDuties();
        $nowDuty             = (new fillDuty())->getNow();
        $this->layout->title = 'List Fill Duty';                        
        $this->layout->main  = View::make('users.dashboard')
             ->nest('content','duties.list',compact('duties','nowDuty')); 
    }

    public function listDutiesUpd()
    {
        
        $duties              = (new updDuty())->listDuties();
        $nowDuty             = (new updDuty())->getNow();
        $this->layout->title = 'List Update Duty';                        
        $this->layout->main  = View::make('users.dashboard')
             ->nest('content','duties.list',compact('duties','nowDuty')); 
             
    }   

    public function newDuty()
    {
        $this->layout->title = 'New Duty';
        $worker_opt          = Worker::getWorkerOptions();                        
        $this->layout->main  = View::make('admin.dashboard')
                                     ->nest('content','duties.new',compact('worker_opt'));
     }
     
    public function editDuty(Duty $duty)
    {
        $this->layout->title = 'Edit Duty';                
        $worker_opt          = Worker::getWorkerOptions();                        
        $this->layout->main  = View::make('admin.dashboard')
                                     ->nest('content', 'duties.edit',compact('duty','worker_opt'));
    }
     
    public function deleteDuty(Duty $duty)
    {
        $duty->delete();
        return Redirect::route('duty.list_fill')
                         ->with('success', 'Duty is deleted!');
    }
    
    // post functions 
    public function saveDuty()
    {
        $inputs = [            
            'monthPart'     => Input::get('monthPart'),
            'month'         => Input::get('month'),
            'year'          => Input::get('year'),           
            'worker_id'     => Input::get('worker_id'),            
        ];        
       
        $valid = Validator::make($inputs, Duty::$rules);        
        
        if ($valid->passes())
        {            
            $duty = new Duty();            
            $duty->monthPart   = $inputs['monthPart'];            
            $duty->month       = $inputs['month'];            
            $duty->year        = $inputs['year'];
            $duty->worker_id   = $inputs['worker_id'];                        
            
            $duty->save();
            return Redirect::route('duty.list_fill')
                             ->with('success', 'Duty is saved!');
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();       
    }
     
    public function updateDuty(Duty $duty)
    {
        $inputs = [            
            'monthPart'     => Input::get('monthPart'),
            'month'         => Input::get('month'),
            'year'          => Input::get('year'),           
            'worker_id'     => Input::get('worker_id'),            
        ];        
       
        $valid = Validator::make($inputs, Duty::$rules);

        if ($valid->passes())
        {            
            $duty->monthPart   = $inputs['monthPart'];            
            $duty->month       = $inputs['month'];            
            $duty->year        = $inputs['year'];
            $duty->worker_id   = $inputs['worker_id'];                        
            
            $duty->save();
            return Redirect::route('duty.list_fill')
                             ->with('success', 'Duty is saved!');
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }

    
}
