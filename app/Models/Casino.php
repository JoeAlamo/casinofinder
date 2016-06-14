<?php
/**
 * Created by PhpStorm.
 * User: Joe Alamo
 * Date: 15/05/2016
 * Time: 19:40
 */

namespace CasinoFinder\Models;


use Illuminate\Database\Eloquent\Model;

class Casino extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    protected $appends = [
        'formatted_casino_opening_times'
    ];


    public function casinoLocation() {
        return $this->hasOne(CasinoLocation::class);
    }

    public function casinoOpeningTimes() {
        return $this->hasMany(CasinoOpeningTime::class)
            ->orderBy('day')
            ->orderBy('open_time');
    }

    /**
     * Get the opening times for the casino in a collapsed, user friendly format
     * @return \Illuminate\Support\Collection
     */
    public function getFormattedCasinoOpeningTimesAttribute() {
        // Only calculate it once
        if (isset($this->casino_opening_times_formatted)) {
            return $this->casino_opening_times_formatted;
        }

        // Format opening times, and identify the redundant contiguous opening times
        $casinoOpeningTimes = $this->casinoOpeningTimes->groupBy('day');
        $redundantOpeningTimes = $this->getRedundantContiguousOpeningTimes($casinoOpeningTimes);

        $this->casino_opening_times_formatted = $casinoOpeningTimes->map(function($day) use ($redundantOpeningTimes) {
            // Loop through that days opening times
            foreach($day as $openingTimeKey => $openingTime) {
                foreach ($redundantOpeningTimes as $redundantOpeningTime) {
                    // If it is now a redundant opening time, remove it from that days opening time collection
                    if ($openingTime->id == $redundantOpeningTime['redundant_id']) {
                        $day->forget($openingTimeKey);
                        // If it needs it's closing time updated, update it
                    } elseif ($openingTime->id == $redundantOpeningTime['relevant_id']) {
                        $openingTime->close_time = $redundantOpeningTime['new_close_time'];
                    }
                }
            }

            return $day;
        })->reject(function($day) {
            return $day->isEmpty();
        })->flatten();

        return $this->casino_opening_times_formatted;
    }

    /**
     * Iterates through the opening times, identifying redundant contiguous opening times
     *
     * Imagine the following opening times:
     * Monday   16:00 to 23:59
     * Tuesday  00:00 to 04:00
     * In reality, this means it opens on Monday 16:00 and closes at 04:00 Tuesday.
     * The two opening times are contiguous. We'd like to display to the user "Monday 16:00 to 04:00".
     * This method identifies Monday's new closing time, and that the Tuesday opening time is now redundant
     * @param \Illuminate\Support\Collection $openingTimes
     * Must be a collection of CasinoOpeningTimes ordered by day & open_time, grouped by day and keyed by day
     * @return array
     */
    private function getRedundantContiguousOpeningTimes($openingTimes) {
        $redundantOpeningTimes = [];
        // Caching Iterator is one behind the inner ArrayIterator
        // This allows us to peek at the next iteration
        $collection = new \CachingIterator(
            new \ArrayIterator($openingTimes->toArray()),
            \CachingIterator::TOSTRING_USE_CURRENT
        );

        $collection->rewind();
        // Save the first day so we can peek at it on the last iteration
        $firstDay = $collection->current();
        while ($collection->valid()) {
            // Retrieve the next day's opening times so we can peek at it. If at end, wrap around
            if ($collection->hasNext()) {
                $nextDayOpeningTimes = $collection->getInnerIterator()->current();
            } else {
                $nextDayOpeningTimes = $firstDay;
            }

            foreach ($collection->current() as $openingTime) {
                /**
                 * If the close time is midnight, the next day in the collection is the actual following day,
                 * the next day opens immediately and it isn't open all day, then it is a contiguous opening time
                 */
                if ($openingTime['close_time'] === '23:59:59' &&
                    ($openingTime['day'] + 1) % 7 === $nextDayOpeningTimes[0]['day'] &&
                    $nextDayOpeningTimes[0]['open_time'] === '00:00:00' &&
                    $nextDayOpeningTimes[0]['close_time'] !== '23:59:59'
                ) {
                    $redundantOpeningTimes[] = [
                        'redundant_id' => $nextDayOpeningTimes[0]['id'],
                        'relevant_id' => $openingTime['id'],
                        'new_close_time' => $nextDayOpeningTimes[0]['close_time']
                    ];
                }
            }

            $collection->next();
        }

        return $redundantOpeningTimes;
    }
} 