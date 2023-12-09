<?php

declare(strict_types=1);

namespace Support;

use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

final class Transaction
{
    public static function run(Closure $callback, Closure $finished = null, Closure $onError = null): mixed
    {
        try {
            DB::beginTransaction();

            return tap($callback(), function ($result) use ($finished) {
                if (is_null($finished) == false) {
                    $finished($result);
                }

                DB::commit();
            });
        } catch (Throwable $error) {
            DB::rollBack();

            if (is_null($onError) == false) {
                $onError($error);
            }

            throw $error;
        }
    }
}
