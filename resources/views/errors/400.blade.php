@extends('errors::minimal')

@section('title', __('请求异常'))
@section('code', '400')
@section('message', __($exception->getMessage() ?: '请求异常'))
