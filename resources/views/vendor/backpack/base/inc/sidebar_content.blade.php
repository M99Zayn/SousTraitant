@php
    $roles1 = array("Chef de projet",
                "Chef de division",
                "Directeur de pole",
                "Division controle de gestion",
                "DAF",
                "DG",);
    $roles2 = array("Chef de projet",
                "Chef de division",
                "Directeur de pole",
                "Division controle de gestion",
                "DAF",
                "DG",
                "Service marché",
                "RH",
                "Cadre administrative",
                "Admin");
    if (backpack_user()->user != null){
        $chef_role = backpack_user()->user->role;
    }else $chef_role = "";
@endphp

<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
@if (in_array(backpack_user()->role, $roles1) or in_array($chef_role, $roles1))
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('contrat') }}'><i class='nav-icon la la-question'></i> Contrats</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('echange') }}'><i class='nav-icon la la-question'></i> Echanges</a></li>
@elseif (backpack_user()->role == "Service marché")
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('soustraitant') }}'><i class='nav-icon la la-question'></i> Sous traitants</a></li>
@elseif (backpack_user()->role == "RH")
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-question'></i> Utilisateurs</a></li>
@elseif (backpack_user()->role == "Cadre administrative")
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('affaire') }}'><i class='nav-icon la la-question'></i> Affaires</a></li>
@elseif (backpack_user()->role == "Admin")
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('affaire') }}'><i class='nav-icon la la-question'></i> Affaires</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('contrat') }}'><i class='nav-icon la la-question'></i> Contrats</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('division') }}'><i class='nav-icon la la-question'></i> Divisions</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('echange') }}'><i class='nav-icon la la-question'></i> Echanges</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pole') }}'><i class='nav-icon la la-question'></i> Poles</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('soustraitant') }}'><i class='nav-icon la la-question'></i> Sous traitants</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'><i class='nav-icon la la-question'></i> Utilisateurs</a></li>
@endif


