<?php
/**
 * Basic abstract class
 */
abstract class Page {
    public function __construct(protected string $title, protected string $content) {
        $this->title = $title;
        $this->content = $content;
    }

    public function title()
    {
        return $this->title;
    }

    public function content()
    {
        return $this->content;
    }

    public function render()
    {
        echo '<h1>' . htmlspecialchars($this->title()) . '</h1>';
        echo '<p>' . nl2br(htmlspecialchars($this->content())) . '</p>';
    }
}