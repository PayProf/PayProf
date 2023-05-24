<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

// Usage : Performing series of unit tests for the AuthController::class.

class UserTest extends TestCase
{
    /**
     * A basic unit test for AuthController::login() .
     * We create a JSON request to the 'api/login' Route 
     * With POST method to trigger the AuthController::login() method
     * @return void
     */
    public function test_login_method_works_correctly(): void
    {
        /* 
        *  Hint: if the test passes it means that the user who's is already in the users table
        *  Can login in.
        */
        $user = User::factory()->create([
            // Had to encrypt the password for the attempt() method in AuthController::login() to work properly 
            'password' => Hash::make('oussama2020')
        ]);

        $response = $this->json('POST', 'api/login', [
            'email' => $user->email,
            'password' => 'oussama2020'
        ]);
        // method is used to assert the expected HTTP response status code.
        $response->assertStatus(200);
    }

    /**
     * We create a JSON request to the 'api/login' Route 
     * With POST method to trigger the AuthController::login() and
     * make sure it blocks the user from trying to create 
     * LoginUserRequest instance if logged in. 
     * @return void
     */
    public function test_make_sure_user_cannot_Create_LoginUserRequest_Instance_If_Logged_In(): void
    {
        /* 
        *  Hint: if the test passes it means that the user is Unauthorized 
        *  To try to login if already logged in.
        */
        $user = User::factory()->create([
            // Had to encrypt the password for the attempt() method in AuthController::login() to work properly 
            'password' => Hash::make('oussama2020')
        ]);
        $response = $this->actingAs($user)
            ->json('POST', 'api/login', [
                'email' => $user->email,
                // password entered manually because the $user->password is encrypted 
                'password' => 'oussama2020'
            ]);
        // method is used to assert the expected HTTP response status code 403.
        $this->assertSame($response->status(), 403, 'User Is Not Allowed To Create A LoginUserRequest Instance If Already Logged In');
    }


    /**
     * A basic unit test for AuthController::logout() .
     * check if the accessToken is deleted after the logout method is called
     * @return void
     */
    public function test_check_tokens_deleted_After_Logout()
    {
        /* 
        *  Hint: if the test passes it means that the user is successfully logged out 
        *  it means that the token is not valid 
        */

        // we create a random user with hashed password 
        $user = User::factory()->create([
            // Had to encrypt the password for the attempt() method in AuthController::login() to work properly 
            'password' => Hash::make('oussama2020')
        ]);

        // we log the dummy user in by calling the login method from the controller
        $response = $this->json('POST', 'api/login', [
            'email' => $user->email,
            // password entered manually because the $user->password is encrypted 
            'password' => 'oussama2020'
        ]);
        // we log the dummy user out using his proper token
        $res = $this->json('GET', 'api/logout', [], [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $response->getData()->data->token
        ]);
        // method is used to assert the expected HTTP response status code 200.
        $res->assertStatus(200);
        // retreive the dummy user because he was logged out
        $user = $user->fresh();
        // to make sure that the user accesstoken is deleted
        $this->assertNull($user->currentAccessToken());
    }


    /**
     * A basic unit test for AuthController::logout() .
     * To make sure that the user who's trying to log out has a token
     * or already logged in 
     * @return void
     */
    public function test_User_Cannot_Logout_Without_token()
    {
        /* 
        *  Hint : if the test passes it means that the user cannot logout without a token
        */
        // we try to logout without a token
        $res = $this->json('GET', 'api/logout', [], [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
        // the expected response is 401 'Unauthorized'
        $res->assertStatus(401);
    }
}
