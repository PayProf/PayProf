<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Http\Controllers\api\AdministrateurController;
use App\Http\Controllers\AuthController;
use App\Models\Administrateur;
use App\Models\User;
use PHPUnit\Framework;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertThat;



class AdministrateurTest extends TestCase
{
    public function test_index_method_is_functional()
    {
        $controller = new AdministrateurController(new AuthController());
        $response = $controller->index();
        assertSame($response->status(), 200, 'index is not working');
    }

    public function test_store_is_working()
    {

    }
}
