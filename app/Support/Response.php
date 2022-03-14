<?php


namespace App\Support;


class Response
{
    private int    $status  = 200;
    private string $title   = "";
    private string $message = "";
    private string $icon    = "";
    private        $data    = [];

    public function title(string $title): Response
    {
        if (strlen($title) > 0) {
            $this->title = $title;
        }

        return $this;
    }

    public function message(string $message): Response
    {
        if (strlen($message) > 0) {
            $this->message = $message . "<br>";
        }

        return $this;
    }

    public function icon(string $icon): Response
    {
        if (in_array($icon, ["success", "info", "warning", "error", "question"])) {
            $this->icon = $icon;
        }

        return $this;
    }

    public function addData(string $key, $value): Response
    {
        $this->data[$key] = $value;

        return $this;
    }

    public function addDataSimple($value): Response
    {
        $this->data = $value;

        return $this;
    }

    public function status($status): Response
    {
        $this->status = (int) $status;

        return $this;
    }

    public function getResponse(): array
    {
        return [
            "status"  => HttpStatus::statusMessagePtBr($this->status),
            "title"   => $this->title,
            "message" => trim($this->message, "<br>"),
            "icon"    => $this->icon,
            "data"    => $this->data,
        ];
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
