<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

//Refresca la base de datos entre pruebas
uses(RefreshDatabase::class);

test('un usuario no puede eliminarse a si mismo', function () {
    
    //1) Crea un usuario en la BD de pruebas
    $user = User::factory()->create(
        [
            'email_verified_at'=> now()
        ]
    );


    //2) Simular que el usuario esta logueado
    $this->actingAs($user, 'web');

    //3)simular que intenta borrar el usuario
    $response = $this->delete(route('admin.users.destroy', $user));

    //4) Esperar a que el servidor bloquee esta accion
    $response->assertStatus(403);

    //5)Veridicamos que el usuario siga existiendo en la base de datos
    $this->assertDatabaseHas('users', [
        'id' => $user->id, 
    ]);


});
