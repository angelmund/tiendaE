<?php

use App\Http\Controllers\categoriasController;
use App\Http\Controllers\contadorRegistrosController;
use App\Http\Controllers\productosController;
use App\Http\Controllers\ProfileController;
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


Route::middleware(['auth', 'verified', 'checkUserStatus'])->group(function () {
   // Rutas que requieren autenticación y verificación del usuario
    Route::get('/dashboard', [productosController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    Route::middleware('auth', 'verified')->group(function () {
        Route::get('/productos/create', [productosController::class, 'create'])->name('productos.create');
        Route::get('/productos/edit/{id}', [productosController::class, 'edit'])->name('productos.edit');
        Route::post('/productos/store', [productosController::class, 'store'])->name('productos.store');
        Route::post('/productos/update/{id}', [productosController::class, 'update'])->name('productos.update');
        Route::post('/productos/delete/{id}', [productosController::class, 'destroy'])->name('productos.delete');
    });
    
    
    Route::middleware('auth', 'verified')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    Route::middleware('auth', 'verified')->group(function () {
        Route::get('/categorias/tabla', [categoriasController::class, 'index'])->name('categorias.index');
        Route::get('/categorias/create', [categoriasController::class, 'create'])->name('categorias.create');
        Route::post('/categorias/store', [categoriasController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/edi/{id}', [categoriasController::class, 'edit'])->name('categorias.edit');
        Route::post('/categorias/update/{id}', [categoriasController::class, 'actualizar'])->name('categorias.update');
        Route::post('/categorias/delete/{id}', [categoriasController::class, 'eliminar'])->name('categorias.eliminar');
        
    });
    
    
    
    //Ruta admin
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/usuarios', [App\Http\Controllers\AdminController::class, 'usuarios'])->name('usuarios.index');
        Route::get('/usuarios/create', [App\Http\Controllers\AdminController::class, 'create'])->name('usuarios.create');
        Route::post('/usuarios/nuevo', [App\Http\Controllers\AdminController::class, 'nuevoUsuario'])->name('usuarios.nuevo');
        Route::delete('/usuarios/delete/{id}', [App\Http\Controllers\AdminController::class, 'eliminarUsuario'])->name('usuarios.delete');
        Route::resource('/usuario/roles', App\Http\Controllers\RolesController::class)->names('usuarios.roles');
        Route::resource('/usuario/permisos', App\Http\Controllers\PermisosController::class)->names('usuarios.permisos');
        // Route::get('/usuario/asignarRol/{id}', [App\Http\Controllers\AdminController::class, 'asignarRolEdit'])->name('usuario.rol');
        Route::resource('/usuario/asignarRol', App\Http\Controllers\AsignarController::class)->names('usuario.RolAsignado');
        Route::delete('/usuario/asignarRol/{id}', [App\Http\Controllers\AsignarController::class, 'destroy'])->name('usuario.Roldelete');
    })->middleware(['auth', 'verified'])->name('admin');
    
    
});

// Ruta de inicio de sesión
Route::get('/', function () {
    return view('auth.login');
})->name('login');


Route::get('/landing', [App\Http\Controllers\landingController::class, 'landing'])->name('landing');
Route::get('/ASP/tienda', [App\Http\Controllers\tiendavirtualController::class, 'index'])->name('tienda');












require __DIR__ . '/auth.php';
