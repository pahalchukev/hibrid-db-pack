<?php

namespace HibridVod\Database\Models\Video\ValueObjects;

final class Priority
{
    private int $value;
    private string $slug;

    /**
     * @param string $slug
     */
    public function __construct(string $slug)
    {
        if ($slug != 'low' && $slug != 'normal' && $slug != 'high') {
            throw new \InvalidArgumentException('Undefined Priority');
        }

        $this->slug = $slug;

        switch ($slug) {
            case 'low':
                $this->value = 3;
                break;
            case 'normal':
                $this->value = 2;
                break;
            case 'high':
                $this->value = 1;
                break;
        }
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return self
     */
    public static function fromValue(int $value): self
    {
        switch ($value) {
            case 1:
                return new self('high');
            case 2:
                return new self('normal');
            case 3:
                return new self('low');
            default:
                throw new \InvalidArgumentException('Undefined Priority');
        }
    }
}
