@extends('errors::minimal')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Bạn không có quyền truy cập chức năng này'))
