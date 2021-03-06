<?php

class TodoController extends BaseController
{   const NOTIFICATION_CREATE_TASK  = 'Тебе назначили новую задачу';
    const NOTIFICATION_UPDATE_TASK  = 'Тебе изменили задачу';
    /* get functions */
    public function listTodo()
    {
        $todos = Todo::getTodosOrdered();
        $users_opt = User::getUserOptions();
        $my = 1;
        $all = 0;
        $defaultActual = 1;
        $this->layout->title = trans('messages.Todo listings');
        $this->layout->main = View::make('users.dashboard')->nest('content','todos.list',compact('todos','users_opt','my','defaultActual','all'));
    }

    public function newTodo()
    {
        $users_opt = User::getUserOptions();
        $this->layout->title = trans('messages.New').' '.Lang::choice('messages.Todos', 1);
        $this->layout->main = View::make('users.dashboard')->nest('content','todos.new',compact('users_opt'));
     }

    public function editTodo(Todo $todo)
    {
        $users_opt = User::getUserOptions();
        $this->layout->title = trans('messages.Edit').' '.Lang::choice('messages.Todos', 1);
        $this->layout->main = View::make('users.dashboard')->nest('content', 'todos.edit', compact('todo','users_opt'));
    }

    public function deleteTodo(Todo $todo)
    {
        $todo->delete();
        return Redirect::route('todo.list')->with('success', Lang::choice('messages.Todos', 1).' '.trans('messages.is deleted'));
    }

    /* post functions */
    public function saveTodo()
    {
        $inputs = [
            'content'  => Input::get('content'),
            'deadline' => Input::get('deadline'),
            'priority' => Input::get('priority'),
            'status'   => Input::get('status'),
            'user_id'  => Input::get('uid'),
            'author_id'=> Input::get('author_uid'),
        ];

        $valid = Validator::make($inputs, Todo::$rules);
        if ($valid->passes())
        {
            $todo            = new Todo();
            $todo->content   = $inputs['content'];
            $todo->deadline  = $inputs['deadline'];
            $todo->priority  = $inputs['priority'];
            $todo->status    = $inputs['status'];
            $todo->user_id   = $inputs['user_id'];
            $todo->author_id = $inputs['author_id'];
            $todo->save();

            $todo->sendNotification(self::NOTIFICATION_CREATE_TASK );
            return Redirect::route('todo.list')
                             ->with('success', Lang::choice('messages.Todos', 1).' '.trans('messages.is saved') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }

    public function updateTodo(Todo $todo)
    {
        $inputs = [
            'content'  => Input::get('content'),
            'deadline' => Input::get('deadline'),
            'priority' => Input::get('priority'),
            'status'   => Input::get('status'),
            'user_id'  => Input::get('uid'),
            'author_id'=> Input::get('author_uid'),
        ];

        $valid = Validator::make($inputs, Todo::$rules);
        if ($valid->passes())
        {
            $todo->content   = $inputs['content'];
            $todo->deadline  = $inputs['deadline'];
            $todo->priority  = $inputs['priority'];
            $todo->status    = $inputs['status'];
            $todo->user_id   = $inputs['user_id'];
            $todo->author_id = $inputs['author_id'];

            if(count($todo->getDirty()) > 0)
            {
                $todo->sendNotification(self::NOTIFICATION_UPDATE_TASK );
                $todo->save();
                return Redirect::route('todo.list')
                                 ->with('success', Lang::choice('messages.Todos', 1).' '.trans('messages.is updated'));
            }
            else
                return Redirect::back()
                                 ->with('success',trans('messages.Nothing to update') );
        }
        else
            return Redirect::back()
                             ->withErrors($valid)
                             ->withInput();
    }

    public function listFiltered()
    {
        $flag      = Input::get('filter');
        $my        = Input::get('my');
        $all       = Input::get('all');
        $todos     = Todo::getFilteredTodosByFlag($flag);
        $defaultActual = $flag;

        $users_opt = User::getUserOptions();
        $this->layout->title = trans('messages.Todo listings');
        $this->layout->main = View::make('users.dashboard')->nest('content','todos.list',compact('todos','users_opt','my','defaultActual','all'));
    }

}
