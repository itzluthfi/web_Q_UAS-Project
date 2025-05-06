<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Isi array ini dengan mal_id dari Jikan, misalnya: [1, 20, 100, 1735, 5114]
     */
    protected static array $validAnimeIds = [
        // Isi dengan mal_id dari Jikan API
        51818,56038,16498
    ];

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'anime_id' => collect(static::$validAnimeIds)->random(),
            'content' => fake()->sentence(),
            'parent_id' => null,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Comment $comment) {
            if (fake()->boolean(50)) {
                $parentId = Comment::where('id', '<', $comment->id)->inRandomOrder()->value('id');
                $comment->parent_id = $parentId;
                $comment->save();
            }
        });
    }
}