<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRoleNameAttribute() {
        return $this->roles->first()?->name;
    }

    public function expertProfile() {
        return $this->hasOne(ExpertProfile::class, 'user_id');
    }

    public function commissionHistories() {
        return $this->hasMany(CommissionHistory::class, 'parent_id');
    }

    public function referees() {
        return $this->hasMany(Referee::class, 'parent_id', 'id');
    }

    public function userDocs() {
        return $this->hasMany(UserDoc::class);
    }

    public function authentications() {
        return $this->hasMany(Authentication::class);
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function approvedPurchases() {
        return $this->hasMany(Purchase::class)->where('approved', 1);
    }

    public function result() {
        return $this->hasMany(Result::class);
    }

    public function exams() {
        return $this->belongsToMany(Exam::class);
    }

    /**
     * Returns items that user has purchased based on the item model.
     *
     * @return array
     */
    public function purchased(string $modelName) {
        $modelName = str($modelName)->singular();
        $modelName = str($modelName)->studly();
        $items = $this->purchases()->where('purchasable_type', $modelName)->get()->map(function ($purchase) {
            return $purchase->purchasable;
        });

        return $items;
    }

    public function approvedCourse(string $modelName) {
        $modelName = str($modelName)->singular();
        $modelName = str($modelName)->studly();
        $items = $this->purchases()->where('purchasable_type', 'Course')->where('approved', true)->get()->map(function ($purchase) {
            return $purchase->purchasable;
        });

        return $items;
    }

    public function promoCodes() {
        return $this->belongsToMany(PromoCode::class)
            ->withPivot('limit');
    }

    public function clients(): BelongsToMany {
        return $this->belongsToMany(Client::class);
    }

    public function withdrawals() {
        return $this->hasMany(Withdrawal::class);
    }

    public function videos(): BelongsToMany {
        return $this->belongsToMany(Video::class)->withPivot(['is_completed']);
    }

    public function hasCompletedVideo(int $id): bool {
        $isCompleted = $this->videos()->find($id)?->pivot?->is_completed;

        return true == $isCompleted;
    }

    public function toggleVideoStatus(int $id): bool {
        $isCompleted = $this->videos()->find($id)?->pivot?->is_completed;
        $toggle = !$isCompleted;
        $this->videos()->updateExistingPivot($id, [
            'is_completed' => $toggle,
        ]);

        return true == $toggle;
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function partnerRequest(): HasOne {
        return $this->hasOne(PartnerRequest::class);
    }

    public function taxCalulators(): HasMany {
        return $this->hasMany(TaxCalculator::class);
    }

    public function isPartner(): bool {
        return $this->hasRole('partner');
    }

    public function canWithdraw() {
        $withdrawalAmount = Setting::first()->reference->withdrawal;
        $lastWithdrawal = $this
        ->withdrawals()
        ->latest()
        ->first();
        $hasAmount = $this->remaining_commission >= $withdrawalAmount;
        $isLastRequestCompleted = null === $lastWithdrawal ? true : $lastWithdrawal->status;

        return $hasAmount && $isLastRequestCompleted;
    }

    public function video_comments(): HasMany {
        return $this->hasMany(VideoComment::class);
    }
}
