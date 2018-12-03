<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Mensagem extends Model
{
    protected $table = 'mensagens';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = ['pedido_id', 'email_cliente', 'email_agente'];


    protected $fillable = ['pedido_id', 'email_cliente', 'email_agente', 'mensagem_id', 'mensagem', 'isCliente', 'isFile', 'fileName'];

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
