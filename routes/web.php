<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\control\AportacionController;
use App\Http\Controllers\control\SolicitudController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\RubroController;
use App\Http\Controllers\SolicitudCatalogoController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UsuarioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

Route::get('/', [HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::resource('estado', EstadoController::class);
Route::resource('banco', BancoController::class);
Route::resource('persona', PersonaController::class);
Route::resource('tipo', TipoController::class);
route::resource('rubro', RubroController::class);
Route::resource('usuario', UsuarioController::class);
Route::resource('egreso', EgresoController::class);
Route::resource('catalogo/solicitudes', SolicitudCatalogoController::class);
Route::resource('recibo', ReciboController::class);

Route::get('control/solicitud/calculo_recibo/{id}/{fecha}', [SolicitudController::class, 'calculo_recibo']);
Route::post('control/solicitud/recibo', [SolicitudController::class, 'recibo_nuevo']);
Route::post('control/solicitud/create_persona', [SolicitudController::class, 'create_persona']);
Route::get('control/solicitud/reporte_solicitud/{id}/{opcion}', [SolicitudController::class, 'reporte_solicitud']);
Route::get('control/solicitud/reporte_recibo/{id}/{opcion}', [SolicitudController::class, 'reporte_recibo']);
Route::get('control/solicitud/get_fiador/{id}', [SolicitudController::class, 'get_fiador']);
Route::resource('control/solicitud', SolicitudController::class);

Route::get('control/aportacion/reporte_aportacion/{socio}/{mes}/{axo}/{opcion}', [AportacionController::class, 'reporte_aportacion']);
Route::resource('control/aportacion', AportacionController::class);

Route::get('persona/get_banco/{id}', [PersonaController::class, 'get_banco']);
Route::get('persona/get_dui/{id}', [PersonaController::class, 'get_dui']);

Route::get('reportes/ingresos', [ReportesController::class, 'ingresos']);
Route::post('reportes/ingresos', [ReportesController::class, 'ingresos_generar']);

Route::get('reportes/saldos', [ReportesController::class, 'saldos']);
Route::post('reportes/saldos', [ReportesController::class, 'saldos_generar']);

Route::get('reportes/rubros', [ReportesController::class, 'rubros']);
Route::get('reportes/rubros_generar', [ReportesController::class, 'rubros_generar']);