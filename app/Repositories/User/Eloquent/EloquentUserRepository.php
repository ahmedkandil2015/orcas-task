<?php
namespace App\Repositories\User\Eloquent;

use App\Repositories\EloquentBaseRepository;
use App\Repositories\User\UserRepository;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    public function list ($attrabuit=[]){
        return $this->getByAttributes($attrabuit)->sortByDesc('created_at');

    }

}
