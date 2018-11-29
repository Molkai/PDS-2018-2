<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Data extends Model
{
    protected $table = 'datas';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = ['pedido_id', 'email_cliente', 'data', 'cidade'];

    protected $fillable = ['pedido_id', 'email_cliente', 'data', 'cidade', 'pais', 'aeroporto', 'cidadeDestino', 'paisDestino', 'aeroportoDestino'];

    protected $hidden = ['email_cliente', 'pedido_id'];

    protected function setKeysForSaveQuery(Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
