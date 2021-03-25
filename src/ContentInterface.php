<?php


namespace Messerli90\Ghost;


interface ContentInterface
{
    public function get();

    public function with(...$includes): Ghost;

    public function fields(...$fields): Ghost;

    public function format(string $format): Ghost;

    public function limit(int $limit): Ghost;

    public function page(int $page): Ghost;

    public function orderBy(string $attr, string $order): Ghost;
}
