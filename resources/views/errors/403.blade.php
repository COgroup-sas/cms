@extends('errors.error')

@section('title', 'Unauthorized action.')

@section('number', '403')

@section('icon', 'fa fa-lock')

@section('message', 'Sorry, the action is not authorized for the assigned role.')