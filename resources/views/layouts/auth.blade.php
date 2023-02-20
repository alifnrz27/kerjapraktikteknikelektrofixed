@extends('layouts.base')

    @isset($slot)
        {{ $slot }}
    @endisset
