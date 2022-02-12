<?php

namespace Tests\Feature\Api;

use App\Models\Reservation;
use App\Models\Spot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservations_post_endpoint_requires_an_user()
    {
        $this->postJson('api/reservations', [])
            ->assertJsonFragment([
                'message' => 'Unauthenticated.'
            ])
            ->assertStatus(401);

        $this->assertDatabaseCount('reservations', 0);
    }

    public function test_required_fields()
    {
        $this->actingAs(User::factory()->create())->postJson('api/reservations', [])
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'start'   => [
                        'The start field is required.'
                    ],
                    'end'     => [
                        'The end field is required.'
                    ],
                    'spot_id' => [
                        'The spot id field is required.'
                    ]
                ]
            ])
            ->assertStatus(422);

        $this->assertDatabaseCount('reservations', 0);
    }

    public function test_start_needs_to_be_before_end_in_time()
    {
        $this->actingAs(User::factory()->create())->postJson('api/reservations', [
            'start'   => now()->toISOString(),
            'end'     => now()->subHours(3)->toISOString(),
            'spot_id' => Spot::factory()->create()->id
        ])
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'end' => [
                        'The end must be a date after start.'
                    ]
                ]
            ])
            ->assertStatus(422);

        $this->assertDatabaseCount('reservations', 0);
    }

    public function test_it_can_successfully_store_reservation()
    {
        $start = now();
        $end = $start->clone()->addHours(3);

        $this->actingAs(User::factory()->create())
            ->postJson('api/reservations', [
                'start'   => $start->toISOString(),
                'end'     => $end->toISOString(),
                'spot_id' => $spotId = Spot::factory()->create()->id
            ])
            ->assertJsonFragment([
                'id'      => 1,
                'spot_id' => $spotId,
                'paid_at' => null,
                'start'   => $start->toDateTimeString(),
                'end'     => $end->toDateTimeString()
            ])
            ->assertStatus(201);

        $this->assertDatabaseCount('reservations', 1);
    }


    public function test_you_can_update_only_reservations_belonging_to_you()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user2->id
        ]);

        $this->actingAs($user1)
            ->patchJson("api/reservations/{$reservation->id}", [])
            ->assertJsonFragment([
                'message' => 'This action is unauthorized.'
            ])
            ->assertStatus(403);
    }

    public function test_update_endpoint_required_fields()
    {
        $user = User::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->patchJson("api/reservations/{$reservation->id}", [])
            ->assertJson([
                'message' => 'The given data was invalid.',
                'errors'  => [
                    'start' => [
                        'The start field is required.'
                    ],
                    'end'   => [
                        'The end field is required.'
                    ]
                ]
            ])
            ->assertStatus(422);
    }

    public function test_it_can_successfully_update_reservation()
    {
        $reservation = Reservation::factory()->create([
            'start' => $start = now(),
            'end'   => $end = $start->clone()->addHours(3)
        ]);

        $newStart = $start->clone()->addHour();
        $newEnd = $end->clone()->addHour();

        $this->actingAs($reservation->user)
            ->patchJson("api/reservations/{$reservation->id}", [
                'start' => $newStart->toISOString(),
                'end'   => $newEnd->toISOString()
            ])
            ->assertJson([
                'data' => [
                    'id'      => 1,
                    'spot_id' => "{$reservation->spot_id}",
                    'start'   => $newStart->toDateTimeString(),
                    'end'     => $newEnd->toDateTimeString(),
                    'paid_at' => null
                ]
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('reservations', [
            'id'      => 1,
            'spot_id' => "{$reservation->spot_id}",
            'start'   => $newStart->toDateTimeString(),
            'end'     => $newEnd->toDateTimeString(),
            'paid_at' => null
        ]);
    }

    public function test_can_delete_only_reservations_you_own()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $reservation = Reservation::factory()->create([
            'user_id' => $user2->id
        ]);

        $this->actingAs($user1)
            ->deleteJson("api/reservations/{$reservation->id}", [])
            ->assertJsonFragment([
                'message' => 'This action is unauthorized.'
            ])
            ->assertStatus(403);
    }

    public function test_it_can_delete_reservation_successfully()
    {
        $reservation = Reservation::factory()->create();

        $this
            ->actingAs($reservation->user)
            ->deleteJson("api/reservations/{$reservation->id}")
            ->assertStatus(204);

        $this->assertDatabaseCount('reservations', 0);
    }


    public function test_cannot_create_reservations_for_the_same_spot_with_overlapping_intervals()
    {
        self::markTestIncomplete('implement');
    }
}
