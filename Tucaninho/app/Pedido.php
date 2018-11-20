<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Pedido extends Model {
  protected $table = 'pedidos';

  public $timestamps = false;

  public $incrementing = false;

  protected $primaryKey = ['pedido_id', 'email_cliente'];


  protected $fillable = ['pedido_id', 'email_cliente', 'url', 'descricao', 'qnt_adultos',
                        'qnt_criancas', 'qnt_bebes', 'tipo_viagem', 'tipo_passagem', 'preferencia', 'preco', 'expirou'];

  protected $hidden = ['email_cliente'];

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
