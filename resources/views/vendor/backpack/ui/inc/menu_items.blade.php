{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />

<x-backpack::menu-item title="User profiles" icon="la la-question" :link="backpack_url('user-profile')" />
<x-backpack::menu-item title="Evaluations" icon="la la-question" :link="backpack_url('evaluations')" />
<x-backpack::menu-item title="Submissions" icon="la la-question" :link="backpack_url('submissions')" />