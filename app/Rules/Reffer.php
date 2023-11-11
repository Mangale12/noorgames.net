<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Form;

class Reffer implements Rule
{
    protected $table;
    protected $column;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //return Form::where(DB::raw("SUBSTRING($this->column, 3)"), '=', $value)->exists();
        return DB::table($this->table)->where($this->column, $value)
                                        ->orWhere(function ($query) use ($value) {
                                            $query->where(DB::raw("SUBSTRING($this->column, 3)"), '=', $value);
                                        })->exists();

        //  return DB::table($this->table)
            // ->where($this->column, $value)
            // ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The refer_id doesn't exist in our database";
    }
}
