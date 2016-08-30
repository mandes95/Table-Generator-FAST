<?php

class Fakta extends Eloquent
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fakta';
    protected $primaryKey = 'id';

    public function itemKategori(){
    	return $this->belongsTo('ItemKategori','kode_item_kategori','kode');
    }

    public function wilayah(){
    	return $this->belongsTo('Wilayah','kode_wilayah');
    }

    public function topikVariabel(){
    	return $this->belongsTo('TopikVariabel','kode_topik_variabel');
    }
}