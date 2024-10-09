<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioControllerTest extends TestCase
{
    use RefreshDatabase; // Para garantir que o banco de dados seja limpo entre os testes

    public function testStoreRequiresNameEmailAndPassword()
    {
        // Testar se a validação falha quando os campos obrigatórios estão vazios
        $response = $this->postJson('/api/usuarios', []);
        
        $response->assertStatus(422); // 422 Unprocessable Entity
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function testStoreRequiresValidEmail()
    {
        // Testar se a validação falha quando o email não é válido
        $response = $this->postJson('/api/usuarios', [
            'name' => 'Teste',
            'email' => 'invalid-email',
            'password' => 'senha123',
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testStoreRequiresPasswordConfirmation()
    {
        // Testar se a validação falha quando a confirmação de senha não é igual à senha
        $response = $this->postJson('/api/usuarios', [
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 'senha123',
            'password_confirmation' => 'senhaDiferente',
        ]);
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }

    public function testStoreSavesUser()
    {
        // Testar se o usuário é salvo corretamente
        $response = $this->postJson('/api/usuarios', [
            'name' => 'Teste',
            'email' => 'teste@example.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
        ]);

        $response->assertStatus(201); // 201 Created
        $this->assertDatabaseHas('usuarios', [
            'name' => 'Teste',
            'email' => 'teste@example.com',
        ]);
    }
}
