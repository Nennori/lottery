<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    const STORE_VALIDATION_RULES = [
        'first_name' => 'required|alpha|min:1|max:50',
        'last_name' => 'required|alpha|min:1|max:50',
        'email' => 'required|email|unique:users,email|max:255',
        'password' => 'required|regex:/^(?=.*?[a-zA-z)(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,22}$/',
    ];

    const UPDATE_VALIDATION_RULES = [
        'first_name' => 'alpha|min:1|max:50',
        'last_name' => 'alpha|min:1|max:50',
        'email' => 'email|unique|max:255',
        'old_password' => 'required_with:new_password|"/^(?=.*?[a-zA-z)(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,22}$/"',
        'new_password' => 'required_with:old_password|"/^(?=.*?[a-zA-z)(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,22}$/"',
    ];

    protected $fillable = [
        'first_name', 'last_name', 'email',
    ];

    protected $hidden = [
        'password', 'is_admin'
    ];

    protected $appends = ['won_matches'];

    public function getWonMatchesAttribute(): BelongsToMany
    {
        return $this->matches()->where('winner_id', $this->id);
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value,
            set: fn(string $value) => Hash::make($value),
        );
    }

    public function matches(): BelongsToMany
    {
        return $this->belongsToMany(LotteryGameMatch::class, 'lottery_game_match_users');
    }

    public static function createUser($data): User
    {
        $user = new self($data);
        $user->password = $data['password'];
        $user->save();

        return $user;
    }

    public static function updateUser($id, $data)
    {
        $user = self::findOrFail($id);

        if (isset($data['old_password']) && Hash::make($data['old_password'] == $user->password)) {
            $user->password = $data['new_password'];
            $user->save();
            unset($data['old_password']);
            unset($data['new_password']);
        }

        return $user->update($data);
    }

    public static function deleteUser(int $id)
    {
        $user = self::findOrFail($id);

        $user->delete();
    }
}
