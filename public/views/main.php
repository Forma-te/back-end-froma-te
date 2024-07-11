<h3>Links rápidos</h3>

<section id="quick-links" class="menu-area">
    <a href="{{ url('admin/plans') }}">
        <i class="fa fa-link"></i>
        <span id="quick-link:plans">
            {{ $data->translation->quick_link_plan }}
        </span>
    </a>
    
    <a href="{{ url('admin/signatures/list?page=1&quantity=10') }}">
        <i class="fa fa-link"></i>
        <span id="quick-link:signatures">
            {{ $data->translation->quick_link_signatures }}
        </span>
    </a>

    <a href="{{ url('admin/producers?list?page=1&quantity=10'') }}">
        <i class="fa fa-link"></i>
        <span id="quick-link:producers">
            {{ $data->translation->quick_link_producers }}
        </span>
    </a>

    <a href="{{ url('admin/members?page=1&quantity=10'') }}">
        <i class="fa fa-link"></i>
        <span id="quick-link:members">
            {{ $data->translation->quick_link_members }}
        </span>
    </a>

    <a href="{{ url('admin/platform') }}">
        <i class="fa fa-link"></i>
        <span id="quick-link:platform">
            {{ $data->translation->quick_link_platform }}
        </span>
    </a>
</section>