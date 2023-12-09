<?php

declare(strict_types=1);

namespace Domain\Order\Processes;

use Domain\Order\Events\OrderCreated;
use Domain\Order\Models\Order;
use DomainException;
use Illuminate\Pipeline\Pipeline;
use Support\Transaction;
use Throwable;

final class OrderProcess
{
    private array $processes = [];

    public function __construct(private Order $order)
    {
    }

    public function setProccesses(array $proccesses): self
    {
        $this->processes = $proccesses;

        return $this;
    }

    public function run(): Order
    {
        return Transaction::run(function () {
            return app(Pipeline::class)
                ->send($this->order)
                ->through($this->processes)
                ->thenReturn();
        }, function (Order $order) {
            flash()->info('Заказ отправлен в обработку');

            event(new OrderCreated($order));
        }, function (Throwable $error) {
            $textMessage = app()->isLocal() ? $error->getMessage() : 'Произошла ошибка';

            throw new DomainException($textMessage);
        });
    }
}
