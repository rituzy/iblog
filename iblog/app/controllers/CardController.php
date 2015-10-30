<?php
     
class CardController extends BaseController
{    

    /* get functions */
    public function listCards()
    {
        $cards              = Card::getCards();
        $this->layout->title = trans('messages.Card listings');                        
        $this->layout->main  = View::make('users.dashboard')
             ->nest('content','cards.list',compact('cards')); 
    }

    public function newCard()
    {
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Cards', 1);
        $worker_opt          = Worker::getWorkerOptions();                        
        $this->layout->main  = View::make('users.dashboard')
                                     ->nest('content','cards.new',compact('worker_opt'));
     }
     
    public function editCard(Card $card)
    {
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Cards', 1);
        $worker_opt          = Worker::getWorkerOptions();                        
        $this->layout->main  = View::make('users.dashboard')
                                     ->nest('content', 'cards.edit',compact('card','worker_opt'));
    }
     
    public function deleteCard(Card $card)
    {
        $card->delete();
        return Redirect::route('card.list')
                         ->with('success', Lang::choice('messages.Cards', 1).' '.trans('is deleted') );
    }
    
    // post functions 
    public function saveCard()
    {
        $inputs = [            
            'color'     => Input::get('color'),
            'content'   => Input::get('content'),
            'comment'   => Input::get('comment'),           
            'worker_id' => Input::get('worker_id'),            
        ];        
       
        $valid = Validator::make($inputs, Card::$rules);        
        
        if ($valid->passes())
        {            
            $card = new Card();            
            $card->color     = $inputs['color'];            
            $card->content   = $inputs['content'];            
            $card->comment   = $inputs['comment'];
            $card->worker_id = $inputs['worker_id'];                        
            
            $card->save();
            return Redirect::route('card.list')
                             ->with('success', Lang::choice('messages.Cards', 1).' '.trans('is saved') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }
     
    public function updateCard(Card $card)
    {
        $inputs = [            
            'color'     => Input::get('color'),
            'content'   => Input::get('content'),
            'comment'   => Input::get('comment'),           
            'worker_id' => Input::get('worker_id'),            
        ];       
       
        $valid = Validator::make($inputs, Card::$rules);

        if ($valid->passes())
        {            
        $card->color     = $inputs['color'];            
            $card->content   = $inputs['content'];            
            $card->comment   = $inputs['comment'];
            $card->worker_id = $inputs['worker_id'];                        
            
            $card->save();
            return Redirect::route('card.list')
                             ->with('success', Lang::choice('messages.Cards', 1).' '.trans('is updated'));
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }

    
}
