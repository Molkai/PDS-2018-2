@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            Tucaninho
        @endcomponent
    @endslot

# Olá,

Clique no botão a baixo para criar uma nova senha a senha.

@component('mail::button', ['url' => $url_recuperar_senha, 'color' => 'success'])
    Recuperar Senha
@endcomponent

Caso não reconheça essa requisição clique no botão a baixo.

@component('mail::button', ['url' => $url_cancelar_recuperacao, 'color' => 'primary'])
    Cancelar operação
@endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            2018 T4So Development Team
        @endcomponent
    @endslot

@endcomponent
