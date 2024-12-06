<div
    x-data="{
        {{-- Bit of a hack, as @json directive outputs double quotes, which breaks scope --}}
        numbers: JSON.parse('{{ json_encode($value) }}'),
        init() {
            if (this.numbers.length === 0) {
                // Add a default number input
                this.numbers.push('');
            }
        },
        addRow() {
            // Only add row if last one is not empty
            var last = String(this.numbers.slice(-1));

            if (last.trim() === '') {
                return;
            }

            this.numbers.push('');
        },
        removeRow(index) {
            // Only allow removing row if there is more than one
            if (this.numbers.length > 1) {
                this.numbers.splice(index, 1);
            }
        },
    }"
>
    <template x-for="(number, index) in numbers">
        <div class="row">
            <div class="col-auto">
                <label class="form-label">Phone Number
                    <input name="number[]" required type="tel" x-model="numbers[index]">
                </label>
            </div>
            <div class="col-auto">
                <button type="button" x-bind:disabled="numbers.length === 1" x-on:click="removeRow(index)">{{ __('Remove') }}</button>
            </div>
        </div>
    </template>
    <button type="button" x-on:click="addRow">{{ __('Add phone number') }}</button>
</div>
<div class="row">
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Add</button>
    </div>
</div>
