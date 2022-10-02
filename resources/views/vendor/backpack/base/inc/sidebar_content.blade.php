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
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('affaire') }}'>Affaires</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('contrat') }}'>Contrats</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('echange') }}'>Mes échanges</a></li>
@elseif (backpack_user()->role == "Service marché")
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('soustraitant') }}'>Sous traitants</a></li>
@elseif (backpack_user()->role == "RH")
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'>Utilisateurs</a></li>
@elseif (backpack_user()->role == "Cadre administrative")
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('affaire') }}'>Affaires</a></li>
@elseif (backpack_user()->role == "Admin")
    <li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}">{{ trans('backpack::base.dashboard') }}</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('affaire') }}'>Affaires</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('contrat') }}'>Contrats</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('division') }}'>Divisions</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('echange') }}'>Echanges</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('pole') }}'>Poles</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('soustraitant') }}'>Sous traitants</a></li>
    <li class='nav-item'><a class='nav-link' href='{{ backpack_url('user') }}'>Utilisateurs</a></li>
@endif


