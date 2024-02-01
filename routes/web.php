<?php

use App\Models\Tenant;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json(Tenant::with('domains')->get());
});

Route::get('/create-tenant', function () {
   $tenantName = request('name');
   $subdomain = request('subdomain');

   if (! $tenantName || ! $subdomain) {
       return response()->json([
           'message' => 'Name and subdomain is required',
           'inputs' => request()->all()
       ]);
   }

   $tenant = Tenant::create(['id' => $tenantName]);
   $tenant->domains()->create(['domain' => $subdomain]);

   return response()->json($tenant);
});
