<?php
namespace Framework;

class JsonResponse
{
    private array $data;
    private int $status;

    public function __construct(array $data = [], int $status = 200)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }
}
