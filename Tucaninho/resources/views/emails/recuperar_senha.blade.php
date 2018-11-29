@component('mail::message')
# Introduction

Clique no botão a baixo para criar uma nova senha a senha. Caso não reconheça essa requisição clique neste link: {{$url_cancelar_recuperacao}}

@component('mail::button', ['url' => $url_recuperar_senha, 'color' => 'primary'])
Recuperar Senha
@endcomponent

@endcomponent
