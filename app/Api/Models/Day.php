<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Day arrange all stats and meals for a date.
 *
 * @property string $id
 * @property string|Carbon $date
 * @property float $protein
 * @property float $fat
 * @property float $carbohydrates
 * @property float $fiber
 * @property integer $weight
 * @property float $protein_eaten
 * @property float $fat_eaten
 * @property float $carbohydrates_eaten
 * @property float $fiber_eaten
 * @property float $weight_eaten
 * @property string $user_id
 * @property string|Carbon $created_at
 * @property string|Carbon $updated_at
 * @property Portion[] $portions
 */
class Day extends Model
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->timestamps = true;
        $this->incrementing = false;
        $this->table = 'days';
        $this->fillable = [
            'id',
            'date',
            'protein',
            'fat',
            'carbohydrates',
            'fiber',
            'weight',
            'protein_eaten',
            'fat_eaten',
            'carbohydrates_eaten',
            'fiber_eaten',
            'weight_eaten',
            'user_id',
        ];
        $this->dates = ['date'];
        parent::__construct($attributes);
    }

    /**
     * @return HasMany
     */
    public function portions(): HasMany
    {
        return $this->hasMany(Portion::class);
    }

    /**
     * @return bool
     */
    public function isEaten(): bool
    {
        foreach ($this->portions as $portion) {
            if (!$portion->eaten) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return int
     */
    public function getProteinEatenPercent(): int
    {
        if ($this->weight === 0) {
            return 0;
        }

        return ceil($this->protein_eaten / ($this->protein / 100));
    }

    /**
     * @return int
     */
    public function getFatEatenPercent(): int
    {
        if ($this->weight === 0) {
            return 0;
        }

        return ceil($this->fat_eaten / ($this->fat / 100));
    }

    /**
     * @return int
     */
    public function getCarbohydratesEatenPercent(): int
    {
        if ($this->weight === 0) {
            return 0;
        }

        return ceil($this->carbohydrates_eaten / ($this->carbohydrates / 100));
    }
}