<?php

class Topik extends Eloquent
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topik';
    protected $primaryKey = 'kode';

    public function topikVariabel(){
    	return $this->hasMany('TopikVariabel','kode_topik','kode');
    }


}