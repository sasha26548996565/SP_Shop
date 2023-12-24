<?php

declare(strict_types=1);

namespace Domain\Catalog\Filters;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Stringable;

abstract class AbstractFilter implements Stringable
{
    abstract public function apply(Builder $query): Builder;

    public function __construct(
        protected string $title,
        protected string $key,
        protected array $values,
        protected string $viewName,
    ) {
    }

    public function __invoke(Builder $query, Closure $next): mixed
    {
        return $next($this->apply($query));
    }

    public function __toString(): string
    {
        return view($this->getViewName(), [
            'filter' => $this
        ])->render();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getViewName(): string
    {
        return $this->viewName;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getRequestValue(?string $index, mixed $default = null): mixed
    {
        return request(
            'filters.' . $this->getKey() . ($index ? ".$index" : ''),
            $default
        );
    }

    public function getInputName(?string $index): string
    {
        return str($this->getKey())
            ->wrap('[', ']')
            ->prepend('filters')
            ->when($index, fn ($str) => $str->append("[$index]"))
            ->value();
    }

    public function getInputId(?string $index): string
    {
        return str($this->getInputName($index))
            ->slug('_')
            ->value();
    }
}
