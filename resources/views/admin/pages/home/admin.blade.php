@extends('admin.templates.template-admin')

@section('contect')
<section id="main-menu" class="menu-container" data-active="true">
    <h3>Links rápidos</h3>

    <section id="quick-links" class="menu-area">
        <button type="button" data-event="goto-link" data-goto="/plans">
            <i class="fa fa-link"></i>
            <span id="quick-link:plans"></span>
        </button>

        <button type="button" data-event="goto-link" data-goto="/signatures">
            <i class="fa fa-link"></i>
            <span id="quick-link:signatures"></span>
        </button>

        <button type="button" data-event="goto-link" data-goto="/producers">
            <i class="fa fa-link"></i>
            <span id="quick-link:producers"></span>
        </button>

        <button type="button" data-event="goto-link" data-goto="/members">
            <i class="fa fa-link"></i>
            <span id="quick-link:members"></span>
        </button>

        <button type="button" data-event="goto-link" data-goto="/platform">
            <i class="fa fa-link"></i>
            <span id="quick-link:platform"></span>
        </button>
    </section>
</section>

@endsection
