<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleAndPermissionController extends Controller
{
    public function index()
    {

        return view('backend.roles_and_permissions');
    }

    public function storeRole(Request $request) {}

    public function updateRole(Request $request) {}

    public function deleteRole(Request $request) {}

    public function storePermission(Request $request) {}

    public function updatePermission(Request $request) {}

    public function deletPermission(Request $request) {}

    public function assignPermission(Request $request) {}
}
