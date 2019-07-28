<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Skilltree;
use App\User;
use Facades\Tests\Setup\SkilltreeFactory;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function non_owners_may_not_invite_users()
    {
        $skilltree = SkilltreeFactory::create();
        $user = factory(User::class)->create();

        $assertInvitationForbidden = function () use ($user, $skilltree) {
            $this->actingAs($user)
                ->post($skilltree->path() . '/invitations')
                ->assertStatus(403);
        };

        $assertInvitationForbidden();

        $skilltree->invite($user);

        $assertInvitationForbidden();
    }

    /** @test **/
    public function a_skilltree_owner_can_invite_a_user()
    {
        $skilltree = SkilltreeFactory::create();

        $userToInvite = factory(User::class)->create(['email' => 'userToInvite@ga.ntig.se']);

        $this->actingAs($skilltree->owner)
            ->post($skilltree->path() . '/invitation', [
                'email' => $userToInvite->email
            ])
            ->assertRedirect($skilltree->path());

        $this->assertTrue($skilltree->members->contains($userToInvite));
    }

    /** @test **/
    public function the_email_address_must_be_a_ntig_address()
    {
        $skilltree = SkilltreeFactory::create();

        $userToInvite = factory(User::class)->create(['email' => 'userToInvite@google.com']);

        $this->actingAs($skilltree->owner)
            ->post($skilltree->path() . '/invitation', [
                'email' => $userToInvite->email
            ])
            ->assertSessionHasErrors([
                'email' => 'The email must be a valid account.'
            ], null, 'invitations');

        $this->assertFalse($skilltree->members->contains($userToInvite));
    }

    /** @test **/
    // public function the_email_address_must_be_associated_with_a_valid_skilltree_account()
    // {
    //     //$this->withoutExceptionHandling();
    //     $skilltree = SkilltreeFactory::create();

    //     $this->actingAs($skilltree->owner)
    //         ->post($skilltree->path() . '/invitations', [
    //             'email' => 'notauser@example.com'
    //         ])
    //         ->assertSessionHasErrors([
    //             'email' => 'The user you are inviting must have a Skilltree Teacher account.'
    //         ], null, 'invitations');
    // }


    /** @test **/
    public function invited_users_may_update_skilltree_details()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        // skilltree has owner
        $skilltree = SkilltreeFactory::create();

        // owner can invite users
        $skilltree->invite($newUser = factory(User::class)->create(['email' => 'inite@ga.ntig.se']));

        // invited user can add skills
        $this->signIn($newUser);
        $this->post(action('SkilltreeSkillsController@store', $skilltree), $skill = ['name' => 'Foo skill']);

        $this->assertDatabaseHas('skills', $skill);
    }
}
