<?php

namespace Tests\Unit;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\User;
use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class UsersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use RefreshDatabase;
    use WithFaker;

    /**
     * @var Model|mixed
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }

    public function testLoginUser()
    {
        $this->actingAs($this->user)
            ->withSession(['foo' => 'bar'])
            ->get('/users')
            ->assertSee($this->user->name);
    }

    public function testEditUserGeneralInfo()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->post('/editUserGeneralInfo', [
                'id'=>$this->user->id,
                'name'=>$this->faker->name,
                'workplace'=>$this->faker->company,
                'mobile'=>$this->faker->phoneNumber,
                'adress'=>$this->faker->address,
            ]);
        $response->assertStatus(302);
    }

    public function testEditUserStatuslInfo()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->post('/editUserStatusInfo', [
                'id'=>$this->user->id,
                'status'=>'1'
            ]);
        $response->assertStatus(302);
    }

    public function testEditUserUserSecurInfo()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->post('/editUserSecurInfo', [
                'id'=>$this->user->id,
                'email'=>$this->faker->email,
                'password'=>$this->faker->password,
            ]);
        $response->assertStatus(302);
    }

    public function testShowUsersList()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->get('/users');
        $response->assertStatus(200);
    }

    public function testShowUserSecurForm()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->get('/security/'.$this->user->id);
        $response->assertStatus(200);
    }

    public function testShowUserGeneralForm()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->get('/general/'.$this->user->id);
        $response->assertStatus(200);
    }

    public function testShowUserMediaForm()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->get('/media/'.$this->user->id);
        $response->assertStatus(200);
    }

    public function testShowUserStatusForm()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->get('/status/'.$this->user->id);
        $response->assertStatus(200);
    }

    public function testShowUserProfile()
    {
        $response = $this->actingAs($this->user)
            ->withSession(['one' => 'two'])
            ->get('/profile/'.$this->user->id);
        $response->assertStatus(200);
    }

}
