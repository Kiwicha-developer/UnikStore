<?php

namespace App\Providers;

use App\Repositories\AccesosRepository;
use App\Repositories\AccesosRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use App\Services\HeaderServiceInterface;
use App\Services\HeaderService;
use App\Services\CalculadoraServiceInterface;
use App\Services\CalculadoraService;
use App\Services\UsuarioServiceInterface;
use App\Services\UsuarioService;
use App\Services\ProductoServiceInterface;
use App\Services\ProductoService;
use App\Services\RegistroProductoServiceInterface;
use App\Services\RegistroProductoService;
use App\Services\ComprobanteServiceInterface;
use App\Services\ComprobanteService;
use App\Services\IngresoProductoServiceInterface;
use App\Services\IngresoProductoService;
use App\Services\PublicacionServiceInterface;
use App\Services\PublicacionService;

use App\Repositories\CalculadoraRepositoryInterface;
use App\Repositories\CalculadoraRepository;
use App\Repositories\UsuarioRepositoryInterface;
use App\Repositories\UsuarioRepository;
use App\Repositories\ProductoRepositoryInterface;
use App\Repositories\ProductoRepository;
use App\Repositories\GrupoProductoRepositoryInterface;
use App\Repositories\GrupoProductoRepository;
use App\Repositories\CategoriaProductoRepositoryInterface;
use App\Repositories\CategoriaProductoRepository;
use App\Repositories\MarcaProductoRepositoryInterface;
use App\Repositories\MarcaProductoRepository;
use App\Repositories\ProveedorRepositoryInterface;
use App\Repositories\ProveedorRepository;
use App\Repositories\AlmacenRepositoryInterface;
use App\Repositories\AlmacenRepository;
use App\Repositories\InventarioRepositoryInterface;
use App\Repositories\InventarioRepository;
use App\Repositories\ProveedorInventarioRepositoryInterface;
use App\Repositories\ProveedorInventarioRepository;
use App\Repositories\PlataformaRepositoryInterface;
use App\Repositories\PlataformaRepository;
use App\Repositories\CuentasPlataformaRepositoryInterface;
use App\Repositories\CuentasPlataformaRepository;
use App\Repositories\RegistroProductoRepositoryInterface;
use App\Repositories\RegistroProductoRepository;
use App\Repositories\TipoComprobanteRepositoryInterface;
use App\Repositories\TipoComprobanteRepository;
use App\Repositories\ComprobanteRepositoryInterface;
use App\Repositories\ComprobanteRepository;
use App\Repositories\IngresoProductoRepositoryInterface;
use App\Repositories\IngresoProductoRepository;
use App\Repositories\ComisionRepositoryInterface;
use App\Repositories\ComisionRepository;
use App\Repositories\DetalleComprobanteRepositoryInterface;
use App\Repositories\DetalleComprobanteRepository;
use App\Repositories\PublicacionRepositoryInterface;
use App\Repositories\PublicacionRepository;
use App\Repositories\VistaRepository;
use App\Repositories\VistaRepositoryInterface;
use App\Services\PlataformaService;
use App\Services\PlataformaServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HeaderServiceInterface::class, HeaderService::class);
        $this->app->bind(CalculadoraServiceInterface::class, CalculadoraService::class);
        $this->app->bind(UsuarioServiceInterface::class, UsuarioService::class);
        $this->app->bind(ProductoServiceInterface::class, ProductoService::class);
        $this->app->bind(RegistroProductoServiceInterface::class, RegistroProductoService::class);
        $this->app->bind(ComprobanteServiceInterface::class, ComprobanteService::class);
        $this->app->bind(IngresoProductoServiceInterface::class, IngresoProductoService::class);
        $this->app->bind(PublicacionServiceInterface::class, PublicacionService::class);
        
        $this->app->bind(CalculadoraRepositoryInterface::class, CalculadoraRepository::class);
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
        $this->app->bind(ProductoRepositoryInterface::class, ProductoRepository::class);
        $this->app->bind(GrupoProductoRepositoryInterface::class, GrupoProductoRepository::class);
        $this->app->bind(CategoriaProductoRepositoryInterface::class, CategoriaProductoRepository::class);
        $this->app->bind(MarcaProductoRepositoryInterface::class, MarcaProductoRepository::class);
        $this->app->bind(ProveedorRepositoryInterface::class, ProveedorRepository::class);
        $this->app->bind(AlmacenRepositoryInterface::class, AlmacenRepository::class);
        $this->app->bind(InventarioRepositoryInterface::class, InventarioRepository::class);
        $this->app->bind(ProveedorInventarioRepositoryInterface::class, ProveedorInventarioRepository::class);
        $this->app->bind(PlataformaRepositoryInterface::class, PlataformaRepository::class);
        $this->app->bind(CuentasPlataformaRepositoryInterface::class, CuentasPlataformaRepository::class);
        $this->app->bind(RegistroProductoRepositoryInterface::class, RegistroProductoRepository::class);
        $this->app->bind(TipoComprobanteRepositoryInterface::class, TipoComprobanteRepository::class);
        $this->app->bind(ComprobanteRepositoryInterface::class, ComprobanteRepository::class);
        $this->app->bind(IngresoProductoRepositoryInterface::class, IngresoProductoRepository::class);
        $this->app->bind(ComisionRepositoryInterface::class, ComisionRepository::class);
        $this->app->bind(DetalleComprobanteRepositoryInterface::class, DetalleComprobanteRepository::class);
        $this->app->bind(PublicacionRepositoryInterface::class, PublicacionRepository::class);
        $this->app->bind(VistaRepositoryInterface::class, VistaRepository::class);
        $this->app->bind(AccesosRepositoryInterface::class,AccesosRepository::class);
        $this->app->bind(PlataformaServiceInterface::class,PlataformaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
