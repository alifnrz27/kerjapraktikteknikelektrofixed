@extends('layouts.base')

@yield('body')
    
    @isset($slot)
        {{ $slot }}
    @endisset