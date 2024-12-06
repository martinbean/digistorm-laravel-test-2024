<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use InvalidArgumentException;

class PhoneNumbersInput extends Component
{
    /**
     * The existing phone numbers.
     *
     * @var array<string>
     */
    public array $value;

    /**
     * Create a new component instance.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $value = [])
    {
        $this->value = $value;

        // Assert all elements are strings
        foreach ($this->value as $index => $value) {
            if (! is_string($value)) {
                throw new InvalidArgumentException(
                    message: vsprintf('Value should contain strings only. Element %d was %s.', [
                        $index,
                        get_debug_type($value),
                    ]),
                );
            }
        }
    }

    /**
     * Get the view that represents the component.
     */
    public function render(): View
    {
        return view('components.phone-numbers-input');
    }
}
